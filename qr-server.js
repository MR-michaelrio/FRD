const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const venom = require('venom-bot');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: '*', // allow Laravel frontend
  },
});

let clientSocket = null;

io.on('connection', (socket) => {
  console.log('🔌 Client connected');
  clientSocket = socket;
});

venom.create({ session: 'liveqr' }).then((client) => {
  client.onQRChanged((qr) => {
    console.log('🔄 QR updated');
    if (clientSocket) {
      clientSocket.emit('qr', qr);
    }
  });

  client.onMessage((msg) => {
    console.log('📩 Message received:', msg.body);
  });
});

server.listen(3001, () => {
  console.log('QR Server live at http://localhost:3001');
});
