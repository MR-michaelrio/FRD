const venom = require('venom-bot');
const express = require('express');
const app = express();
const port = 3000;
const mysql = require('mysql2/promise');
const schedule = require('node-schedule');
const https = require('http');
const { Server } = require('socket.io');

const server = https.createServer(app);
const io = new Server(server, {
  cors: {
    origin: '*',
  }
});
let socketClient = null;

io.on('connection', (socket) => {
  console.log('🟢 Web Client connected');
  socketClient = socket;
});

  // Create a MySQL connection pool
const pool = mysql.createPool({
  host: '127.0.0.1',      // Database host
  user: 'frd',             // Database username
  password: 'tomsK9as',        // Database password
  database: 'frd',             // Database name
  port: 3306                   // Database port (default 3306)
});

app.use(express.urlencoded({ extended: true }));

const teams = ["A", "B", "C"];
let currentTeamIndex = 0;
const sendMessage = (client) => {
  const team = teams[currentTeamIndex];
  const message = `Petugas Piket Hari Ini\nREGU PIKET "${team}"`;

  // Kirim pesan ke nomor yang ditentukan
  client.sendText('6282114578009@c.us', message)
      .then((result) => {
          console.log(`Pesan terkirim ke regu ${team} pada ${new Date()}`);
      })
      .catch((error) => {
          console.error(`Gagal mengirim pesan ke regu ${team}:`, error);
      });

  // Update indeks regu untuk pengiriman berikutnya
  currentTeamIndex = (currentTeamIndex + 1) % teams.length;
};

venom
  .create({
    session: 'live-qr',
    puppeteerOptions: {
      headless: "new",
      executablePath: '/usr/bin/google-chrome-stable',
      args: [
        "--no-sandbox",
        "--disable-setuid-sandbox",
      ]
    }
  })
  .then(async (client) => {
    client.onQRChanged((qr) => {
      console.log('🔁 QR updated');
      if (socketClient) {
        socketClient.emit('qr', qr);
      }
    });
    console.log('Venom session created');
    
    
    start(client);

    app.get('/laporanfinal', async (req, res) => {
      const groupIds = ['6282114578009@c.us','120363026258560001@g.us','120363183182250375@g.us', '120363173044009164@g.us','120363277021729569@g.us'];
      const kejadian = req.query.kejadian;
      const kejadian_arr = JSON.parse(kejadian);

      if (Array.isArray(kejadian_arr)) {
        const message = `*LAPORAN KEJADIAN*\n\n${kejadian_arr.map((item) => `Kejadian: ${item.kejadian}\nAlamat: ${item.alamat}\nObjek: ${item.objek}\nRegu: ${item.regu}\nTanggal Input Form: ${item.tanggal}\nNama Petugas: ${item.nama_petugas}\nNama Petugas Piket: ${item.petugas_piket}\n\nResponder: \n${item.responder}\n-----------------------------------------------------\n`
        ).join("\n")}\nDemikian Sebagai Laporan, Terima Kasih🙏🙏🙏.`;
      
        try {
          for (const groupId of groupIds) {
            await client.sendText(groupId, message);
          }
          // res.redirect('http://101.255.101.60:8081/laporan1');
          res.status(200).send("success")
        } catch (error) {
          console.error('Error sending message:', error);
          res.status(500).send('Error sending message');
        }
      } else {
        console.error("The 'kejadian' variable is not an array.");
      }
      
    });

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

        // Dua versi pesan
        const message1 = `*DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nStatus: ${status}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;
        const message2 = `*DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nAlamat: ${alamat}\nStatus: ${status}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;

        // Kirim pesan berdasarkan isSSC setiap nomor_group
        const promises = groupIds.map(async (groupId) => {
          // Ambil isSSC berdasarkan nomor_group
          const group = results.find(row => row.nomor_group === groupId);
            const isSSC = group ? group.isSSC : 0;  // Jika tidak ditemukan, gunakan 0 sebagai default

            const message = `*DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nStatus: ${status}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;
            const message2 = `*DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nAlamat: ${alamat}\nStatus: ${status}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;

            // Tentukan pesan yang akan dikirim berdasarkan nilai isSSC
            const msgToSend = isSSC === 1 ? message2 : message;

            try {
                await client.sendText(groupId, msgToSend);
                console.log(`✅ Pesan berhasil dikirim ke: ${groupId}`);
            } catch (error) {
                console.error(`❌ Gagal mengirim pesan ke ${groupId}:`, error.message);
            }
        });

        // Tunggu semua pesan selesai
        await Promise.allSettled(promises);
        res.redirect('https://laporan.id-responder.org/lpr');
      }catch (error) {
        console.error('⚠️ Terjadi kesalahan saat memproses laporan:', error.message);
        
        try {
          await client.sendText('6282114578009@c.us', `❗ Error laporan: ${error.message}`);
        } catch (errNotif) {
          console.error('❌ Gagal mengirim notifikasi error ke admin:', errNotif.message);
        }
    
        res.redirect('https://laporan.id-responder.org/lpr');
      }
    });
  
    app.get('/updatelaporan', async (req, res) => {
      try {
          // Ambil nomor_group dan isSSC dari database
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
  
          // Template pesan
          const message = `*UPDATE DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nStatus: ${status}\nWaktu Selesai: ${selesai}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;
          const message2 = `*UPDATE DATA LAPORAN KEJADIAN*\n\nKejadian: ${kjd}\nAlamat: ${alamat}\nStatus: ${status}\nWaktu Selesai: ${selesai}\nObjek: ${objek}\nSituasi: ${situasi}\nRegu: ${regu}\nTanggal Input Form: ${tanggal}\nNama Petugas: ${nama}\n\nResponder: \n${responder}\n\n*NOTE: DATA INTERNAL MOHON UNTUK TIDAK KELUAR GRUP ‼*`;
  
          console.log('Update Laporan 1:', message);
          console.log('Update Laporan 2:', message2);
  
          // Kirim pesan ke semua grup
          const promises = groupIds.map(async (groupId) => {
              // Ambil isSSC berdasarkan nomor_group
              const group = results.find(row => row.nomor_group === groupId);
              const isSSC = group ? group.isSSC : 0; // Default 0 kalau tidak ada
  
              // Pilih pesan sesuai isSSC
              const msgToSend = isSSC === 1 ? message2 : message;
  
              try {
                  await client.sendText(groupId, msgToSend);
                  console.log(`✅ Pesan update berhasil dikirim ke: ${groupId}`);
              } catch (error) {
                  console.error(`❌ Gagal mengirim pesan update ke ${groupId}:`, error.message);
              }
          });
  
          // Tunggu semua proses selesai
          await Promise.allSettled(promises);
          console.log("📌 Semua pesan update telah diproses. Redirecting...");
          res.redirect('https://laporan.id-responder.org/lpr');
  
      } catch (error) {
          console.error('⚠️ Terjadi kesalahan saat memproses update laporan:', error.message);
          try {
              await client.sendText('6282114578009@c.us', error.message);
          } catch (err) {
              console.error('❌ Gagal mengirim pesan error:', err.message);
          }
          res.redirect('https://laporan.id-responder.org/lpr');
      }
    });

    app.get('/absen', async (req, res) => {
      const pdfFileName = req.query.namafile;
      const wilayah = req.query.wilayah;

      try {
          const [results] = await pool.query('SELECT nomor_group, id_wilayah, isSSC FROM wa');

          // Path to the PDF file you want to send
          const filePath = `../laporan.id-responder.org/FRD/public/pdf/${pdfFileName}`;
          const caption = 'Absen'
  
          console.log(`Sending file: ${filePath}`);
  
          const promises = results.map(async (row) => {
            if (String(row.id_wilayah) === String(wilayah)) {
                try {
                    await client.sendFile(row.nomor_group, filePath, pdfFileName, caption);
                    console.log(`✅ File berhasil dikirim ke: ${row.nomor_group}`);
                } catch (err) {
                    console.error(`❌ Gagal kirim file ke ${row.nomor_group}:`, err.message);
                }
            }
        });

        // Tunggu semua kiriman selesai
        await Promise.allSettled(promises);

        console.log('📌 Semua file berhasil diproses');
        res.redirect('https://laporan.id-responder.org/home');
  
      } catch (error) {
          console.error('Error sending file:', error);
          res.status(500).send('Error sending file');
      }
    });

    schedule.scheduleJob('0 8 * * *', () => {
      sendMessage(client);
    });
  })
  .catch((error) => {
    console.error('Venom initialization error:', error);
  });

  function start(client) {
    client.onMessage(async (message) => {
      console.log('Received message:', message);
      const dataKeyword = 'Data Kejadian Kebakaran';
      const dataKeyword2 = 'Data Kejadian KEBAKARAN';
      const updateKeyword = 'Update Data Kejadian Kebakaran';
      const updateKeyword2 = 'Update Data Kejadian KEBAKARAN';

      if (message.body && (message.body.includes(dataKeyword) || message.body.includes(dataKeyword2) || message.body.includes(updateKeyword) || message.body.includes(updateKeyword2))) {
        const text = message.body;

        // Extract the value of "Grup Jaga" and "Alamat TKP" using regular expressions
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
        // Save the extracted values to the MySQL database
        try {
          const connection = await pool.getConnection();
          await connection.query('INSERT INTO damkar_65 (grup_jaga, hari_tgl, waktu_terima_berita, sumber_info, alamat, objek, jenis_bangunan, pengerahan_awal, waktu_tiba, waktu_mulai_operasi, situasi, waktu_dilokalisir, waktu_pendinginan, waktu_selesai_operasi, pengerahan, dugaan, kronologi, maps, judul) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [grupJaga, hari, waktuterima, submerinfo, alamat, objek, jenisbangungan, pengerahanawal, waktutiba, waktumulai, situasi, waktulokalisir, pendinginan, selesai, pengerahan, dugaan, Kronologi, maps, judul]);
          connection.release();
          const targetNumbers = ['120363026258560001@g.us', '120363183182250375@g.us', '120363173044009164@g.us'];
              
          for (const targetNumber of targetNumbers) {
            await client.sendText(targetNumber, text);
          }
          console.log('Data saved to the database successfully');
        }catch (error) {
          console.error('Error saving data to the database:', error);
        }
      }
        // console.log(message)
    });
  }

app.listen(port, () => {
  console.log(`API listening at http://localhost:${port}`);
});
