const socket = new WebSocket("ws://localhost:6060");
const terminals = [];

// Find all div elements with IDs starting with 'Terminal-'
const terminalDivs = Array.from(document.querySelectorAll("div[id^='Terminal-']"));

// Create and initialize terminals
terminalDivs.forEach((div, index) => {
  const term = new window.Terminal({
    cursorBlink: true
  });
  term.open(div);
  init(term, index + 1);
  terminals.push(term);
});

function init(term, index) {
  if (term._initialized) {
    return;
  }

  term._initialized = true;

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
        runCommand(term, command, index);
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
}

function clearInput(command, term) {
  var inputLength = command.length;
  for (var i = 0; i < inputLength; i++) {
    term.write('\b \b');
  }
}

function prompt(term) {
  command = '';
  term.write('\r\n$ ');
}

function runCommand(term, command, index) {
  if (command.length > 0) {
    clearInput(command, term);
    socket.send(`[${index}] ${command}\n`);
    return;
  }
}

socket.onmessage = (event) => {
  const message = event.data;
  const indexStart = message.indexOf('[');
  if (indexStart !== -1) {
    const indexEnd = message.indexOf(']');
    if (indexEnd !== -1) {
      const index = message.substring(indexStart + 1, indexEnd);
      const terminalIndex = parseInt(index) - 1;
      const output = message.substring(indexEnd + 1);
      if (terminals[terminalIndex]) {
        terminals[terminalIndex].write(output);
      }
    }
  }
};