// This Backend File handles client connections and executes incoming commands from the Frontend
// The Backend File represents a WebSocket, which awaits connections and incoming messages
// Has to be started on the Webserver with nodejs: $ node backend.js
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
    // Spawn a Terminal
    this.ptyProcess = pty.spawn(this.shell, [], {
      name: 'xterm-color',
      cwd: this.cwd,
      env: this.env
    });
    // XTERM Event to handle output of a executed command
    this.ptyProcess.on('data', data => {
      ws.send(JSON.stringify({ terminalId: this.id, message: data }));
    });

  }
}
// Map to store active terminals
const terminals = new Map();

// Event Listener: Triggered when Client connects
wss.on('connection', ws => {
  // Event Listener: Triggered when message is sent to Backend
    ws.on('message', data => {
      // Split incoming JSON from Frontend to terminalID and command
        const { terminalId, command } = JSON.parse(data);
        // If Terminal does not yet exist, add to list
        if (!(terminals.has(terminalId))) {
            const shell = os.platform() === 'win32' ? 'powershell.exe' : 'bash';
            const cwd = "/home/student/";
            const env = process.env;
        
            const terminal = new Terminal(terminalId, shell, cwd, env);
            terminals.set(terminalId, terminal);
        
            terminal.start(ws);
            // Execute Startup command defined in html DIV TAG of terminals
            terminal.ptyProcess.write(command + '\r');
            terminal.ptyProcess.write("clear\r")
        } else { // If Terminal already exists, just execute incoming command on the terminal
            const terminal = terminals.get(terminalId); 
            if (command) {
                terminal.ptyProcess.write(command + '\r');
            }
        }      
    });
    // Event Listener for clients closing page
    // ws.on('close', () => {
    //     terminals.forEach((terminalId) => {     BRAUCHT MAN DAS?
    //         terminals.delete(terminalId)  
    //     });
    // });
});
