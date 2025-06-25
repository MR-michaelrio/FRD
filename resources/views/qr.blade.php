<!DOCTYPE html>
<html>
<head>
  <title>Scan QR WhatsApp</title>
</head>
<body>
  <h1>Scan QR untuk Login WhatsApp</h1>
  <img id="qrImage" src="" style="width:300px;"><br><br>

  <!-- Tombol Restart -->
  <button id="restartBtn">Restart PM2 WA</button>
  <p id="status"></p>

  <script>
    const ws = new WebSocket("wss://wa.id-responder.org:7071");

    ws.onopen = () => {
      console.log("WebSocket connected");
    };

    ws.onmessage = (event) => {
      try {
        const message = JSON.parse(event.data);
        console.log(message);
        if (message.type === 'qr') {
          document.getElementById('qrImage').src = message.data;
        }
      } catch (e) {
        console.error("Invalid message format:", event.data);
      }
    };

    ws.onerror = (error) => {
      console.error("WebSocket error:", error);
    };

    ws.onclose = () => {
      console.warn("WebSocket connection closed.");
    };

    // Tombol Restart PM2
    document.getElementById("restartBtn").onclick = async () => {
      document.getElementById("status").innerText = "Restarting PM2 WA...";
      try {
        const response = await fetch("https://wa.id-responder.org:3000/restart-wa", { method: "POST" });
        const result = await response.json();
        if (result.success) {
          document.getElementById("status").innerText = "PM2 WA berhasil direstart.";
        } else {
          document.getElementById("status").innerText = "Gagal restart PM2 WA.";
        }
      } catch (err) {
        console.error(err);
        document.getElementById("status").innerText = "Terjadi kesalahan saat restart.";
      }
    };
  </script>
</body>
</html>
