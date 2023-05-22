const socket = new WebSocket("ws://localhost:6060");

// Array to hold all terminal instances
const terminals = [];

// Function to initialize a terminal
function initializeTerminal(element, startupCommand) {
  const term = new window.Terminal({
    cursorBlink: true,
  });
  term.open(element);

  term.prompt = () => {
    term.write('\r\n$ ');
  };
  prompt(term);

  term.onData(e => {
    switch (e) {
      case '\u0003': // Ctrl+C
        term.write('^C');
        prompt(term);
        break;
      case '\r': // Enter
        runCommand(term, command);
        command = '';
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
      case '\u0009':
        console.log('tabbed', output, ["dd", "ls"]);
        break;
      default:
        if (e >= String.fromCharCode(0x20) && e <= String.fromCharCode(0x7E) || e >= '\u00a0') {
          command += e;
          term.write(e);
        }
    }
  });

  // Store the terminal instance in the array
  terminals.push({ term, startupCommand });
}

// Function to clear input
function clearInput(command) {
  var inputLength = command.length;
  for (var i = 0; i < inputLength; i++) {
    term.write('\b \b');
  }
}

// Function to prompt
function prompt(term) {
  command = '';
  term.write('\r\n$ ');
}

// WebSocket message event handler
socket.onmessage = event => {
  const data = JSON.parse(event.data);
  const { terminalId, message } = data;
  const terminal = terminals.find(term => term.term._container.id === `terminal-${terminalId}`);
  if (terminal) {
    terminal.term.write(message);
  }
};

// Function to run a command
function runCommand(term, command) {
  if (command.length > 0) {
    clearInput(command);

    // List of forbidden commands
    const forbiddenCommands = ["exit", "sudo shutdown", /^rm(\s.*)?$/i, "reboot"];

    // Check if the entered command is forbidden
    if (forbiddenCommands.includes(command)) {
      term.write(`Command "${command}" is not allowed.\r\n`);
    } else {
      const terminalId = terminals.findIndex(term => term.term === term);
      socket.send(JSON.stringify({ terminalId, command }));
    }
  }
}

// Initialize all terminals
document.addEventListener('DOMContentLoaded', () => {
  const terminalElements = document.getElementsByClassName('terminal');
  for (let i = 0; i < terminalElements.length; i++) {
    const element = terminalElements[i];
    const startupCommand = element.getAttribute('data-startup-command');
    initializeTerminal(element, startupCommand);
  }
});
