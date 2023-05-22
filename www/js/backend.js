const WebSocket = require('ws');
const os = require('os');
const pty = require('node-pty');

const wss = new WebSocket.Server({ port: 6060 });

console.log("Socket is up and running...");

const shells = [];

wss.on('connection', ws => {
  console.log("New session");

  const shell = os.platform() === 'win32' ? 'powershell.exe' : 'bash';
  const ptyProcess = pty.spawn(shell, [], {
    name: 'xterm-color',
    uid: 1000,
    gid: 1000,
    cwd: "/home/student/",
    env: process.env,
  });

  const terminalId = shells.length;
  shells.push(ptyProcess);

  ws.on('message', message => {
    const data = JSON.parse(message);
    const { terminalId, command } = data;
    const ptyProcess = shells[terminalId];
    ptyProcess.write(command);
  });

  ptyProcess.on('data', data => {
    ws.send(JSON.stringify({ terminalId, message: data }));
    console.log(data);
  });
});