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
          this.runCommand();
          break;
        case '\u007F': // Backspace (DEL)
          // Do not delete the prompt
          if (this.term._core.buffer.x > 2) {
            this.term.write('\b \b');
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
    this.socket.send(JSON.stringify({ terminalId: this.terminalId, startupCommand: this.startupCommand }));
  }

  runCommand() {
    const command = this.term._core.buffer.getLine(0).translateToString().trim();
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
