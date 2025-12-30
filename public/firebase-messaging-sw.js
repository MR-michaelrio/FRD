// WAJIB pakai COMPAT version
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "AIzaSyDHeVWGv57jQCs5ixwtKlXjOu-bgM9yOYY",
  authDomain: "ier-notif.firebaseapp.com",
  projectId: "ier-notif",
  messagingSenderId: "876665599326",
  appId: "1:876665599326:web:5a1be26bdd56bd42350bcf"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  console.log('[SW] Background message:', payload);

  self.registration.showNotification(
    payload.notification.title,
    {
      body: payload.notification.body,
      icon: '/icon.png'
    }
  );
});
