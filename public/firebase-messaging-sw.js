/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyBC_a9vd6FsDZ9ilgq4NwnLOsLB9M-3xOk",
    authDomain: "slikreader.firebaseapp.com",
    databaseURL: "https://slikreader-default-rtdb.firebaseio.com",
    projectId: "slikreader",
    storageBucket: "slikreader.appspot.com",
    messagingSenderId: "326056442281",
    appId: "1:326056442281:web:95a9057a0fe01fb3a76cb8",
};

firebase.initializeApp(firebaseConfig);

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
var messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("[firebase-messaging-sw.js] Received background message ", payload);
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "images/icons/icon-72x72.png",
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});
