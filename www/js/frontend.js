// This Script handles the Frontend a client sees when testing a Hacking Experiment
// IMPORTANT: The Frontend has a loop in the end, creating Terminals for EVERY DIV with the class "vhlterminal"

// Event listener for new connections; If all Elements are loaded, Terminals can be spawned.
document.addEventListener('DOMContentLoaded', () => {
  const terminalElements = document.getElementsByClassName('vhlterminal'); // Get all Elements with class "vhlterminal"
  for (let i = 0; i < terminalElements.length; i++) {
    const element = terminalElements[i];
    const startupCommand = element.getAttribute('data-startup-command');
    const terminal = new VHLTerminal(element, startupCommand);
    terminal.initialize();
  }
});

// The Class Terminal has the necessary constructor and functions, which are described in detail
class VHLTerminal {
  constructor(element, startupCommand) { // Currently Constructor expects a startup command defined in the div tag of the html
    this.element = element;
    this.startupCommand = startupCommand;
    this.term = null;
    this.command = ''
    // List of forbidden commands
    this.forbiddenCommands = [
      /exit/i,
      /sudo shutdown/i,
      /^rm(\s.*)?$/i,
      /reboot/i
    ]; 
  }
  
  initialize() {
    this.term = new window.Terminal({ // Here it is possible to define configurations of the terminal
      cursorBlink: true
    });
    this.term.open(this.element);
    if (this.term._initialized) {
      return;
    }
    this.term.prompt = () => {
      this.term.write('\r\n$ ');
    };
    this.term._initialized = true;

    // XTERMJS Event, handling keystrokes of the user with switch cases
    // New cases can be added for specific Keystrokes; e.g. Arrow-Keys are currently missing
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
        default: // Default are normal characters, which are just written into the terminal and added to the command-string
          if (e >= String.fromCharCode(0x20) && e <= String.fromCharCode(0x7E) || e >= '\u00a0') {
            this.term.write(e);
            this.command += e;
          }
      }
    });
    // Execute Function, creating a Websocket
    this.initializeWebSocket();
  }
  // Socket on Port defined in Backend.js is used to connect to Websocket; EACH TERMINAL NEEDS A WEBSOCKET
  initializeWebSocket() {
    const socket = new WebSocket("ws://localhost:6060");
    this.socket = socket;
    this.socket.send(this.startupCommand);
    // Socket event handling incoming "answers" of backend
    this.socket.onmessage = (event) => {
      this.term.write(event.data);
    }
  }

    
  // Default function being executed upon hitting Enter
  runCommand() { 
    if (this.command.trim().length > 0) {
      const forbidden = this.forbiddenCommands.some(pattern => pattern.test(this.command));
      if (forbidden) {
        this.term.write(`\nCommand "${this.command}" is not allowed.\r\n`);
        this.command = '';
      } else {
        this.term.prompt();
        this.term.write('\r\n');
        this.socket.send(this.command);
        this.command = '';
      }
    }
  }
}
