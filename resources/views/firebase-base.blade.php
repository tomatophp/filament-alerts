<div>

</div>
<script type="module">
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js'
    import {getMessaging, onMessage, getToken} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "{{ setting('fcm_apiKey') }}",
        authDomain: "{{ setting('fcm_authDomain') }}",
        databaseURL: "{{ setting('fcm_database_url') }}",
        projectId: "{{ setting('fcm_projectId') }}",
        storageBucket: "{{ setting('fcm_storageBucket') }}",
        messagingSenderId: "{{ setting('fcm_messagingSenderId') }}",
        appId: "{{ setting('fcm_appId') }}",
        measurementId: "{{ setting('fcm_measurementId') }}",
    };
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("Notification permission granted.");
            if ("serviceWorker" in navigator) {
                navigator.serviceWorker
                    .register("/firebase-messaging-sw.js")
                    .then(function (registration) {
                        console.log(
                            "Registration successful, scope is:",
                            registration.scope
                        );
                    })
                    .catch(function (err) {
                        console.log(
                            "Service worker registration failed, error:",
                            err
                        );
                    });
            }
            navigator.serviceWorker.getRegistration().then(async (reg) => {
                let token = await getToken(messaging, {vapidKey: "{{ setting('fcm_vapid') }}"});
                console.log(token);
                Livewire.dispatch('fcm-token', { token: token });


                onMessage(messaging, (payload) => {
                    console.log("message: ", payload);
                    var audio = new Audio('https://devsuez.emalleg.net/storage/sound/notifications.mp3');
                    audio.play();

                    console.log(payload);
                    Livewire.dispatch('fcm-notification', {data: payload})
                    // push notification can send event.data.json() as well
                    const options = {
                        body: payload.data.body,
                        icon: payload.data.image,
                        tag: "alert",
                    };
                    let notification = reg.showNotification(
                        payload.data.title,
                        options
                    );
                    // link to page on clicking the notification
                    notification.onclick = (payload) => {
                        window.open(payload.data.url);
                    };
                });
            });
        }

    });

</script>
