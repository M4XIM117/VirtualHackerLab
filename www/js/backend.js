const WebSocket = require('ws');
const os = require('os');
const pty = require('node-pty');

const wss = new WebSocket.Server({ port: 6060 });
const terminals = new Map();

console.log("Socket is up and running...");

wss.on('connection', (ws, req) => {
  const index = new URL(req.url, 'http://localhost').searchParams.get('index');
  console.log(`New session with index: ${index}`);

  ws.on('message', message => {
    const { index, command } = JSON.parse(message);

    const ptyProcess = terminals.get(index);

    if (ptyProcess) {
      ptyProcess.write(command);
    }
  });

  const shell = os.platform() === 'win32' ? 'powershell.exe' : 'bash';
  const ptyProcess = pty.spawn(shell, [], {
    name: 'xterm-color',
    env: process.env,
  });

  terminals.set(index, ptyProcess);

  ptyProcess.on('data', data => {
    ws.send(JSON.stringify({ index, data }));
    console.log(data);
  });

  ws.on('close', () => {
    const ptyProcess = terminals.get(index);
    if (ptyProcess) {
      ptyProcess.kill();
      terminals.delete(ws);
    }
  });
});
