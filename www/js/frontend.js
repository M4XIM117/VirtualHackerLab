const terminals = new Map();

function initTerminal(element, index, startupCommand) {
  const term = new window.Terminal({
    cursorBlink: true
  });
  term.open(element);
  terminals.set(index, term);

  const socket = new WebSocket("ws://localhost:6060");

  // Send startup command to the backend when the terminal is initialized
  if (startupCommand) {
    socket.addEventListener('open', () => {
      socket.send(JSON.stringify({ index, command: startupCommand }));
    });
  }

  term.onData(e => {
    switch (e) {
      case '\u0003': // Ctrl+C
        term.write('^C');
        prompt(term);
        break;
      case '\r': // Enter
        socket.send(JSON.stringify({ index, command: e }));;
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


  socket.addEventListener('message', event => {
    const { index, data } = JSON.parse(event.data);
    terminals.get(index).write(data);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const terminalElements = document.getElementsByClassName("terminal");

  Array.from(terminalElements).forEach((element, index) => {
    const startupCommand = element.dataset.startupCommand;
    initTerminal(element, index + 1, startupCommand);
  });
});
