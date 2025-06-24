<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live QR WhatsApp</title>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
</head>
<body>
    <h2>Scan QR WhatsApp</h2>
    <div id="qrcode">Menunggu QR...</div>

    <script>
        const socket = io('http://localhost:3000'); // sesuaikan jika beda host

        socket.on('qr', function(qr) {
            console.log('QR diterima:', qr);
            const qrImage = `http://101.255.101.60:3000/create-qr-code/?size=300x300&data=${encodeURIComponent(qr)}`;
            document.getElementById('qrcode').innerHTML = `<img src="${qrImage}" alt="QR Code WhatsApp">`;
        });
    </script>
</body>
</html>
