const venom = require('venom-bot');
const express = require('express');
const app = express();
const port = 3000;

app.use(express.urlencoded({ extended: true }));

venom
  .create({
    session: 'session-name'
  })
  .then((client) => {
    console.log('Venom session created');

    app.get('/send-whatsapp-message', (req, res) => {
      const groupId = '120363184341579466@g.us';

      const tanggal_kejadian = req.query.tanggal_kejadian;
      const nama_petugas = req.query.nama_petugas;
      const petugas_piket = req.query.petugas_piket;
      const regu = req.query.regu;
      const kejadian = req.query.kejadian;

      const message = `Regu: ${regu}\nTanggal Kejadian: ${tanggal_kejadian}\nNama Petugas: ${nama_petugas}\nNama Petugas Piket: ${petugas_piket}\n*Kejadian*: \n${kejadian}\n\nDemikian Sebagai Laporan, Terima Kasih🙏🙏🙏.
    `;

      client.sendText(groupId, message)
        .then(() => {
          res.redirect('https://gmci.or.id/gmci/laporan.php');
        })
        .catch((error) => {
          console.error('Error sending message:', error);
          res.status(500).send('Error sending message');
        });
    });

    
  })
  .catch((error) => {
    console.log(error);
  });

app.listen(port, () => {
  console.log(`API listening at http://localhost:${port}`);
});
