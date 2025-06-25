<!DOCTYPE html>
<html>
<head>
  <title>Scan QR WhatsApp</title>
</head>
<body>
  <h1>Scan QR untuk Login WhatsApp</h1>
  <img id="qrImage" src="" style="width:300px;">

  <script>
    const ws = new WebSocket("wss://wa.id-responder.org:7071");

    ws.onopen = () => {
      console.log("WebSocket connected");
    };

    ws.onmessage = (event) => {
      try {
        const message = JSON.parse(event.data);
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
  </script>
</body>
</html>
