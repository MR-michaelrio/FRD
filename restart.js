// File: routes/restart.js (atau sesuaikan)
const express = require("express");
const router = express.Router();
const { exec } = require("child_process");

router.post("/restart-wa", (req, res) => {
  exec("pm2 restart wa", (error, stdout, stderr) => {
    if (error) {
      console.error(`Gagal restart PM2 WA: ${error.message}`);
      return res.json({ success: false, message: error.message });
    }
    console.log(`PM2 WA restarted: ${stdout}`);
    res.json({ success: true });
  });
});

module.exports = router;
