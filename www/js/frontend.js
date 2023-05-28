class Terminal {
  constructor(element, startupCommand) {
    this.element = element;
    this.startupCommand = startupCommand;
    this.term = null;
    this.terminalId = null;
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
          command = ''
          break;
        case '\u007F': // Backspace (DEL)
          // Do not delete the prompt
          if (term._core.buffer.x > 2) {
            term.write('\b \b');
            if (command.length > 0) {
                command = command.substr(0, command.length - 1);
            }
        }
          break;
        default:
          if (e >= String.fromCharCode(0x20) && e <= String.fromCharCode(0x7E) || e >= '\u00a0') {
            this.term.write(e);
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
    // const line = this.term._core.buffer.active.getLine(this.term._core.buffer.ybase + this.term._core.buffer.y);
    // const command = line.translateToString().trim();
    const command = this.command.trim();
  
    if (command.length > 0) {
      this.term.prompt();
      this.term.write('\r\n');
      this.socket.send(command);
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
