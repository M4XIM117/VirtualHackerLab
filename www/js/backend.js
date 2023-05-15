const WebSocket = require('ws');
const os = require('os');
const pty = require('node-pty');

const wss = new WebSocket.Server({ port: 6060 });
const terminals = new Map();

console.log("Socket is up and running...");

wss.on('connection', ws => {
  console.log("New session");
  
  // Create a new terminal process
  const shell = os.platform() === 'win32' ? 'powershell.exe' : 'bash';
  const ptyProcess = pty.spawn(shell, [], {
    name: 'xterm-color',
    env: process.env,
  });

  // Store the terminal process in the Map using the WebSocket as the key
  terminals.set(ws, ptyProcess);

  // Forward terminal output to the WebSocket client
  ptyProcess.on('data', function (data) {
    ws.send(data);
    console.log(data);
  });

  // Handle WebSocket messages from the client
  ws.on('message', command => {
    // Check if it's a startup command
    if (command.startsWith('[') && command.includes(']')) {
      const indexEnd = command.indexOf(']');
      const index = command.substring(1, indexEnd);
      const actualCommand = command.substring(indexEnd + 1).trim();

      // Execute the startup command in the terminal process
      ptyProcess.write(actualCommand + '\n');
    } else {
      // It's a regular command, send it to the terminal process
      ptyProcess.write(command);
    }
  });

  // Handle WebSocket closure
  ws.on('close', () => {
    const ptyProcess = terminals.get(ws);
    ptyProcess.kill(); // Terminate the associated terminal process
    terminals.delete(ws); // Remove the WebSocket entry from the Map
  });
});
