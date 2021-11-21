/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-analytics.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyDmcog1VurBdAI9iUEimZ39nwreJMzn19Y",
    authDomain: "user-app-ncc.firebaseapp.com",
    projectId: "user-app-ncc",
    storageBucket: "user-app-ncc.appspot.com",
    messagingSenderId: "618198775963",
    appId: "1:618198775963:web:280e9312aae4476843ee3e",
    measurementId: "G-9SF17SSL9C"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
