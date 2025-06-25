<!DOCTYPE html>
<html>
<head>
  <title>Scan QR WhatsApp</title>
</head>
<body>
  <h1>Scan QR untuk Login WhatsApp</h1>
  <img id="qrImage" src="" style="width:300px;">

  <script>
    const ws = new WebSocket('wss://101.255.101.60:7071');

    ws.onmessage = (event) => {
      const message = JSON.parse(event.data);
      if (message.type === 'qr') {
        document.getElementById('qrImage').src = message.data;
      }
    };
  </script>
</body>
</html>
