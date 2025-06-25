<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Scan QR WhatsApp</title>
</head>
<body>
  <h1>Scan QR untuk Login WhatsApp</h1>
  
  <div id="qrSection">
    <img id="qrImage" src="" alt="QR Code WhatsApp" style="width:300px;">
    <p id="statusMessage" style="display: none;">WhatsApp berhasil terhubung.</p>

  </div>

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

        if (message.type === 'ready') {
          // Hide QR when WA is ready
          document.getElementById('qrSection').style.display = 'none';
          document.getElementById('statusMessage').style.display = 'block';

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
  </script>
</body>
</html>
