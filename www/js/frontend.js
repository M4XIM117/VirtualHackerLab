class Terminal {
  constructor(element, startupCommand) {
    this.element = element;
    this.startupCommand = startupCommand;
    this.term = null;
    this.terminalId = null;
    this.command = ''
    this.forbiddenCommands = ["exit", "sudo shutdown", /^rm(\s.*)?$/i, "reboot"];
  }
  

  initialize() {
    this.term = new window.Terminal({
      cursorBlink: true
    });
    this.term.open(this.element);


    this.term.prompt = () => {
      this.term.write('\r\n$ ');
    };

    this.term._initialized = false;

    this.term.onData(e => {
      switch (e) {
        case '\u0003': // Ctrl+C
          this.term.write('^C');
          this.term.prompt();
          break;
        case '\r': // Enter
          this.runCommand(this.term, );
          this.command = ''
          break;
        case '\u007F': // Backspace
          if (this.term._core.buffer.x === 0 && this.command.length > 0) {
            this.term.write('\x1b[1A\x1b[1000C\x1b[K');
            this.command = this.command.substring(0, this.command.length - 1);
          } else if (this.term._core.buffer.x > 2 && this.command.length > 0) {
              this.term.write('\b \b');
              this.command = this.command.substring(0, this.command.length - 1);
          } else if (this.term._core.buffer.x <= 2 && this.command.length > 0) {
              this.term.write('\b \b');
              this.command = this.command.substring(0, this.command.length - 1);
          } 
          break;
        // case '\x1b[D': // Left arrow key
        //   if (!this.command.length == 0 && this.term._core.buffer.x > 2) {
        //     this.term.write('\x1b[1D');
        //   }
            
        //   break;
        // case '\x1b[C': // Right arrow key
        //   this.term.write('\x1b[1C')
        //   break;
        default:
          if (e >= String.fromCharCode(0x20) && e <= String.fromCharCode(0x7E) || e >= '\u00a0') {
            this.term.write(e);
            this.command += e;
          }
      }
    });

    this.initializeWebSocket();
  }

  initializeWebSocket() {
    const socket = new WebSocket("ws://localhost:6060");
    socket.onopen = () => {
      this.sendTerminalId();
    };

    socket.onmessage = event => {
      const data = JSON.parse(event.data);
      if (data.terminalId === this.terminalId) {
        this.term.write(data.message);
        this.term.prompt();
      }
    }

    this.socket = socket;
  }

  sendTerminalId() {
    this.socket.send(JSON.stringify({ terminalId: this.terminalId, command: this.startupCommand }));
  }

  runCommand() { 
    if (this.command.trim().length > 0) {
      if (this.forbiddenCommands.includes(this.command)) {
        this.term.write(`Command "${this.command}" is not allowed.\r\n`);
            this.command = '';
      } else {
          this.term.prompt();
          this.term.write('\r\n');
          this.socket.send(JSON.stringify({ terminalId: this.terminalId, command: this.command }));
          this.command = '';
        }
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const terminalElements = document.getElementsByClassName('vhlterminal');
  for (let i = 0; i < terminalElements.length; i++) {
    const element = terminalElements[i];
    const startupCommand = element.getAttribute('data-startup-command');
    const terminal = new Terminal(element, startupCommand);
    terminal.terminalId = i;
    terminal.initialize();
  }
});
