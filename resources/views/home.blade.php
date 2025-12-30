<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indonesia Emergency Responder</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">

    <div class="text-center">
        <a href="{{route('home')}}" class="btn btn-primary btn-lg m-2" role="button">Laporan</a>
        <a href="{{route('anggota.indexdaftar')}}" class="btn btn-secondary btn-lg m-2" role="button">Pendaftaran Anggota</a>
    </div>

    <!-- Link to Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.7.0/firebase-app.js";
import { getMessaging, getToken, onMessage } 
from "https://www.gstatic.com/firebasejs/12.7.0/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyDHeVWGv57jQCs5ixwtKlXjOu-bgM9yOYY",
    authDomain: "ier-notif.firebaseapp.com",
    projectId: "ier-notif",
    storageBucket: "ier-notif.firebasestorage.app",
    messagingSenderId: "876665599326",
    appId: "1:876665599326:web:5a1be26bdd56bd42350bcf"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Register service worker
const registration = await navigator.serviceWorker.register(
    '/firebase-messaging-sw.js'
);

console.log('SW REGISTERED:', registration);

// Request permission
const permission = await Notification.requestPermission();
if (permission === 'granted') {

    const token = await getToken(messaging, {
        vapidKey: 'BBlPfuteR8wFlVbzQNQ7FFN6XT_MKw2Hmqs9vHOPgXN0WIOVBugpRdxwD8G0x5_BgWSjEOsizucxvQUqUpQisL0',
        serviceWorkerRegistration: registration
    });

    if (token) {
        fetch('/save-fcm-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ token })
        });
    }
}

// Notif saat browser aktif
onMessage(messaging, (payload) => {
    new Notification(payload.notification.title, {
        body: payload.notification.body
    });
});
</script>

</html>
