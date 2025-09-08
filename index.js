const { Client, LocalAuth, MessageMedia } = require('whatsapp-web.js');
const express = require('express');
const app = express();
const port = 3000;
const mysql = require('mysql2/promise');
const schedule = require('node-schedule');
const WebSocket = require('ws');
const path = require('path');
const https = require("https");
const restartRoute = require("./restart");
const cors = require('cors');
const { exec } = require("child_process");
const fs = require('fs');
const qrcode = require('qrcode');

app.use(cors({
  origin: 'https://laporan.id-responder.org'
}));

// ==================== WEBSOCKET SERVER ====================
let connectedClients = [];
const server = https.createServer({
  cert: fs.readFileSync('/www/wwwroot/wa/certs/fullchain.pem'),
  key: fs.readFileSync('/www/wwwroot/wa/certs/privkey.pem'),
});
const wss = new WebSocket.Server({ server });

wss.on("connection", (socket) => {
  console.log("Client connected");
  connectedClients.push(socket);

  socket.on("close", () => {
    connectedClients = connectedClients.filter(client => client !== socket);
  });

  socket.on("message", (msg) => {
    console.log("Received:", msg);
  });

  socket.send("Hello from server");
});

function broadcastQR(base64Qr) {
  connectedClients.forEach(client => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(JSON.stringify({ type: 'qr', data: base64Qr }));
    }
  });
}
function broadcastReady() {
  connectedClients.forEach(client => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(JSON.stringify({ type: 'ready' }));
    }
  });
}

server.listen(7071, () => {
  console.log("WebSocket WSS server running on port 7071");
});

// ==================== DATABASE ====================
const pool = mysql.createPool({
  host: '127.0.0.1',
  user: 'frd',
  password: 'tomsK9as',
  database: 'frd',
  port: 3306
});

app.use(express.urlencoded({ extended: true }));

// ==================== WHATSAPP CLIENT ====================
const client = new Client({
  authStrategy: new LocalAuth({ clientId: "live-qr" }),
  puppeteer: {
    headless: true,
    executablePath: '/usr/bin/google-chrome-stable',
    args: ["--no-sandbox", "--disable-setuid-sandbox"]
  }
});

client.on('qr', (qr) => {
  qrcode.toDataURL(qr, (err, url) => {
    if (!err) {
      broadcastQR(url);
    }
  });
});

client.on('ready', () => {
  console.log("✅ WhatsApp Client Ready!");
  broadcastReady();
});

// ==================== CRON JOB ====================
const teams = ["A", "B", "C"];
let currentTeamIndex = 0;
const sendMessage = async () => {
  const team = teams[currentTeamIndex];
  const message = `Petugas Piket Hari Ini\nREGU PIKET "${team}"`;

  try {
    await client.sendMessage('6282114578009@c.us', message);
    console.log(`Pesan terkirim ke regu ${team} pada ${new Date()}`);
  } catch (error) {
    console.error(`Gagal mengirim pesan ke regu ${team}:`, error);
  }
  currentTeamIndex = (currentTeamIndex + 1) % teams.length;
};
schedule.scheduleJob('0 8 * * *', sendMessage);

// ==================== ROUTES ====================

// LAPORAN FINAL
app.get('/laporanfinal', async (req, res) => {
  const groupIds = [
    '6282114578009@c.us',
    '120363026258560001@g.us',
    '120363183182250375@g.us',
    '120363173044009164@g.us',
    '120363277021729569@g.us'
  ];
  const kejadian = req.query.kejadian;
  const kejadian_arr = JSON.parse(kejadian);

  if (Array.isArray(kejadian_arr)) {
    const message = `*LAPORAN KEJADIAN*\n\n${kejadian_arr.map((item) =>
      `Kejadian: ${item.kejadian}\nAlamat: ${item.alamat}\nObjek: ${item.objek}\nRegu: ${item.regu}\nTanggal Input Form: ${item.tanggal}\nNama Petugas: ${item.nama_petugas}\nNama Petugas Piket: ${item.petugas_piket}\n\nResponder: \n${item.responder}\n-----------------------------------------------------\n`
    ).join("\n")}\nDemikian Sebagai Laporan, Terima Kasih🙏🙏🙏.`;

    try {
      for (const groupId of groupIds) {
        await client.sendMessage(groupId, message);
      }
      res.status(200).send("success");
    } catch (error) {
      console.error('Error sending message:', error);
      res.status(500).send('Error sending message');
    }
  } else {
    console.error("The 'kejadian' variable is not an array.");
  }
});

// LAPORAN
app.get('/laporan', async (req, res) => {
  try {
    const [results] = await pool.query('SELECT nomor_group, isSSC FROM wa');
    const groupIds = results.map(row => row.nomor_group);

    const kejadian = JSON.parse(req.query.kejadian);
    const regu = kejadian.regu;
    const objek = kejadian.objek;
    const kjd = kejadian.kejadian;
    const tanggal = kejadian.tanggal;
    const nama = kejadian.nama_petugas;
    const responder = kejadian.responder;
    const situasi = kejadian.situasi;
    const alamat = kejadian.alamat;
    const status = req.query.status;

    const message1 = `*DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nStatus: ${status}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;
    const message2 = `*DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nAlamat: ${alamat}\nStatus: ${status}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;

    const promises = groupIds.map(async (groupId) => {
      const group = results.find(row => row.nomor_group === groupId);
      const isSSC = group ? group.isSSC : 0;
      const msgToSend = isSSC === 1 ? message2 : message1;

      try {
        await client.sendMessage(groupId, msgToSend);
        console.log(`✅ Pesan berhasil dikirim ke: ${groupId}`);
      } catch (error) {
        console.error(`❌ Gagal mengirim pesan ke ${groupId}:`, error.message);
      }
    });

    await Promise.allSettled(promises);
    res.redirect('https://laporan.id-responder.org/lpr');
  } catch (error) {
    console.error('⚠️ Terjadi kesalahan saat memproses laporan:', error.message);
    try {
      await client.sendMessage('6282114578009@c.us', `❗ Error laporan: ${error.message}`);
    } catch (errNotif) {
      console.error('❌ Gagal mengirim notifikasi error ke admin:', errNotif.message);
    }
    res.redirect('https://laporan.id-responder.org/lpr');
  }
});

// UPDATE LAPORAN
app.get('/updatelaporan', async (req, res) => {
  try {
    const [results] = await pool.query('SELECT nomor_group, isSSC FROM wa');
    const groupIds = results.map(row => row.nomor_group);

    const kejadian = JSON.parse(req.query.kejadian);
    const regu = kejadian.regu;
    const objek = kejadian.objek;
    const kjd = kejadian.kejadian;
    const tanggal = kejadian.tanggal;
    const nama = kejadian.nama_petugas;
    const responder = kejadian.responder;
    const situasi = kejadian.situasi;
    const status = kejadian.status;
    const alamat = kejadian.alamat;
    const selesai = kejadian.waktu_selesai;

    const message1 = `*UPDATE DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nStatus: ${status}\nWaktu Selesai: ${selesai}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;
    const message2 = `*UPDATE DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nAlamat: ${alamat}\nStatus: ${status}\nWaktu Selesai: ${selesai}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;

    const promises = groupIds.map(async (groupId) => {
      const group = results.find(row => row.nomor_group === groupId);
      const isSSC = group ? group.isSSC : 0;
      const msgToSend = isSSC === 1 ? message2 : message1;

      try {
        await client.sendMessage(groupId, msgToSend);
        console.log(`✅ Pesan update berhasil dikirim ke: ${groupId}`);
      } catch (error) {
        console.error(`❌ Gagal mengirim pesan update ke ${groupId}:`, error.message);
      }
    });

    await Promise.allSettled(promises);
    console.log("📌 Semua pesan update telah diproses. Redirecting...");
    res.redirect('https://laporan.id-responder.org/lpr');
  } catch (error) {
    console.error('⚠️ Terjadi kesalahan saat memproses update laporan:', error.message);
    try {
      await client.sendMessage('6282114578009@c.us', error.message);
    } catch (err) {
      console.error('❌ Gagal mengirim pesan error:', err.message);
    }
    res.redirect('https://laporan.id-responder.org/lpr');
  }
});

// ABSEN
app.get('/absen', async (req, res) => {
  const pdfFileName = req.query.namafile;
  const wilayah = req.query.wilayah;

  try {
    const [results] = await pool.query('SELECT nomor_group, id_wilayah, isSSC FROM wa');
    const filePath = `../laporan.id-responder.org/FRD/public/pdf/${pdfFileName}`;
    const caption = 'Absen';

    const fileData = fs.readFileSync(filePath);
    const media = new MessageMedia("application/pdf", fileData.toString('base64'), pdfFileName);

    const promises = results.map(async (row) => {
      if (String(row.id_wilayah) === String(wilayah)) {
        try {
          await client.sendMessage(row.nomor_group, media, { caption });
          console.log(`✅ File berhasil dikirim ke: ${row.nomor_group}`);
        } catch (err) {
          console.error(`❌ Gagal kirim file ke ${row.nomor_group}:`, err.message);
        }
      }
    });

    await Promise.allSettled(promises);
    console.log('📌 Semua file berhasil diproses');
    res.redirect('https://laporan.id-responder.org/home');
  } catch (error) {
    console.error('Error sending file:', error);
    res.status(500).send('Error sending file');
  }
});

// ==================== MESSAGE HANDLER ====================
client.on('message', async (message) => {
  const dataKeyword = 'Data Kejadian Kebakaran';
  const dataKeyword2 = 'Data Kejadian KEBAKARAN';
  const updateKeyword = 'Update Data Kejadian Kebakaran';
  const updateKeyword2 = 'Update Data Kejadian KEBAKARAN';

  if (message.body && (message.body.includes(dataKeyword) || message.body.includes(dataKeyword2) || message.body.includes(updateKeyword) || message.body.includes(updateKeyword2))) {
    const text = message.body;

    const topPartMatch = text.match(/([\s\S]*?)(?=\n|$)/);
    const grupJagaMatch = text.match(/Grup Jaga\s*:\s*([^]+?)(?=\n|$)/);
    const hariMatch = text.match(/Hari\/Tgl\s*:\s*([^]+?)(?=\n|$)/);
    const waktuterimaMatch = text.match(/Waktu Terima Berita\s*:\s*([^]+?)(?=\n|$)/);
    const submerinfoMatch = text.match(/Sumber Informasi\s*:\s*([^]+?)(?=\n|$)/);
    const alamatMatch = text.match(/Alamat TKP\s*:\s*([^]+?)(?=\n|$)/);
    const objekMatch = text.match(/Objek\s*:\s*([^]+?)(?=\n|$)/);
    const jenisbangunanMatch = text.match(/Jenis Bangunan\s*:\s*([^]+?)(?=\n|$)/);
    const pengerahanawalMatch = text.match(/Pengerahan Awal\s*:\s*([^]+?)(?=\n|$)/);
    const waktutibaMatch = text.match(/Waktu Tiba\/10.2\s*:\s*([^]+?)(?=\n|$)/);
    const waktumulaiMatch = text.match(/Waktu Mulai Operasi\s*:\s*([^]+?)(?=\n|$)/);
    const waktulokalisirMatch = text.match(/Waktu Lokalisir\s*:\s*([^]+?)(?=\n|$)/);
    const pendinginanMatch = text.match(/Waktu Pendinginan\s*:\s*([^]+?)(?=\n|$)/);
    const situasiMatch = text.match(/Situasi \/ Status Kebakaran\s*:\s*([^]+?)(?=\n|$)/);
    const selesaiMatch = text.match(/Waktu Selesai Operasi\s*:\s*([^]+?)(?=\n|$)/);
    const pengerahanMatch = text.match(/Pengerahan Unit \/ Personil\s*:\s*([^]+?)(?=\n|$)/);
    const dugaanMatch = text.match(/Dugaan Penyebab\s*:\s*([^]+?)(?=\n|$)/);
    const kronologiMatch = text.match(/Kronologi\s*:\s*([^]+?)(?=\n|$)/);
    const mapsMatch = text.match(/Maps\s*:\s*([^]+?)(?=\n|$)/);

    const grupJaga = grupJagaMatch ? grupJagaMatch[1].trim() : null;
    const hari = hariMatch ? hariMatch[1].trim() : null;
    const waktuterima = waktuterimaMatch ? waktuterimaMatch[1].trim() : null;
    const submerinfo = submerinfoMatch ? submerinfoMatch[1].trim() : null;
    const alamat = alamatMatch ? alamatMatch[1].trim() : null;
    const objek = objekMatch ? objekMatch[1].trim() : null;
    const jenisbangungan = jenisbangunanMatch ? jenisbangunanMatch[1].trim() : null;
    const pengerahanawal = pengerahanawalMatch ? pengerahanawalMatch[1].trim() : null;
    const waktutiba = waktutibaMatch ? waktutibaMatch[1].trim() : null;
    const waktumulai = waktumulaiMatch ? waktumulaiMatch[1].trim() : null;
    const waktulokalisir = waktulokalisirMatch ? waktulokalisirMatch[1].trim() : null;
    const pendinginan = pendinginanMatch ? pendinginanMatch[1].trim() : null;
    const situasi = situasiMatch ? situasiMatch[1].trim() : null;
    const pengerahan = pengerahanMatch ? pengerahanMatch[1].trim() : null;
    const dugaan = dugaanMatch ? dugaanMatch[1].trim() : null;
    const Kronologi = kronologiMatch ? kronologiMatch[1].trim() : null;
    const selesai = selesaiMatch ? selesaiMatch[1].trim() : null;
    const maps = mapsMatch ? mapsMatch[1].trim() : null;
    const judul = topPartMatch ? topPartMatch[1].trim() : null;

    try {
      const connection = await pool.getConnection();
      await connection.query(
        'INSERT INTO damkar_65 (grup_jaga, hari_tgl, waktu_terima_berita, sumber_info, alamat, objek, jenis_bangunan, pengerahan_awal, waktu_tiba, waktu_mulai_operasi, situasi, waktu_dilokalisir, waktu_pendinginan, waktu_selesai_operasi, pengerahan, dugaan, kronologi, maps, judul) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [grupJaga, hari, waktuterima, submerinfo, alamat, objek, jenisbangungan, pengerahanawal, waktutiba, waktumulai, situasi, waktulokalisir, pendinginan, selesai, pengerahan, dugaan, Kronologi, maps, judul]
      );
      connection.release();

      const targetNumbers = [
        '120363026258560001@g.us',
        '120363183182250375@g.us',
        '120363173044009164@g.us',
        '120363277021729569@g.us'
      ];

      for (const number of targetNumbers) {
        await client.sendMessage(number, message.body);
      }
      console.log("Pesan berhasil diteruskan dan data berhasil disimpan.");
    } catch (err) {
      console.error("Terjadi kesalahan:", err);
    }
  }
});

// START
client.initialize();
app.listen(port, () => {
  console.log(`Server berjalan di http://localhost:${port}`);
});
