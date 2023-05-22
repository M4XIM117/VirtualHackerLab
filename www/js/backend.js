const WebSocket = require('ws');
const os = require('os');
const pty = require('node-pty');

const wss = new WebSocket.Server({ port: 6060 });
console.log("Socket is up and running...");

class Terminal {
  constructor(id, shell, cwd, env) {
    this.id = id;
    this.shell = shell;
    this.cwd = cwd;
    this.env = env;
    this.ptyProcess = null;
  }

  start(ws) {
    this.ptyProcess = pty.spawn(this.shell, [], {
      name: 'xterm-color',
      cwd: this.cwd,
      env: this.env
    });

    this.ptyProcess.on('data', data => {
      ws.send(JSON.stringify({ terminalId: this.id, message: data }));
    });

    ws.on('message', command => {
      this.ptyProcess.write(command);
    });
  }

  stop() {
    if (this.ptyProcess) {
      this.ptyProcess.kill();
      this.ptyProcess = null;
    }
  }
}

const terminals = new Map();

wss.on('connection', ws => {
  ws.on('message', data => {
    const { terminalId, startupCommand } = JSON.parse(data);
    const shell = os.platform() === 'win32' ? 'powershell.exe' : 'bash';
    const cwd = "/home/student/";
    const env = process.env;

    const terminal = new Terminal(terminalId, shell, cwd, env);
    terminals.set(terminalId, terminal);

    terminal.start(ws);

    if (startupCommand) {
      terminal.ptyProcess.write(startupCommand + '\r');
    }
  });

  ws.on('close', () => {
    terminals.forEach(terminal => {
      terminal.stop();
    });
  });
});
