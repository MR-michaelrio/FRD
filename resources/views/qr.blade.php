<!DOCTYPE html>
<html>
<head>
  <title>Scan QR WhatsApp</title>
</head>
<body>
  <h1>Scan QR untuk Login WhatsApp</h1>
  <img id="qr" />

  <script>
    const ws = new WebSocket("wss://wa.id-responder.org:7071");

    ws.onopen = () => {
      console.log("WebSocket connected");
    };

    ws.onmessage = (event) => {
      try {
        const message = JSON.parse(event.data);
        console.log(message);
        if (data.type === 'qr') {
            document.getElementById("qr").src = "data:image/png;base64," + data.data;
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
