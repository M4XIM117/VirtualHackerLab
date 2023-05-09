const WebSocket = require('ws')
var os = require('os');
var pty = require('node-pty');

const wss = new WebSocket.Server({ port: 6060 })

console.log("Socket is up and running...")

var shell = os.platform() === 'win32' ? 'powershell.exe' : 'bash';
var ptyProcess = pty.spawn(shell, [], {
    name: 'xterm-color',
    uid: 1000,
    gid: 1000,
    cwd: "/home/student/",
    env: process.env,
});
wss.on('connection', ws => {
    console.log("new session")
    ptyProcess.write('docker exec -it password_cracking_kali-client_1 bash\r');
    ptyProcess.write('clear')
    ws.on('message', command => {
        ptyProcess.write(command);
    })

    ptyProcess.on('data', function (data) {
        ws.send(data)
        console.log(data);

    });
})