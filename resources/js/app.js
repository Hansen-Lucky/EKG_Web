import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo.channel('patient-monitor')
    .listen('.HeartRateUpdated', (event) => {
        console.log("Received broadcast:", event);
        window.dispatchEvent(new CustomEvent("HeartRateUpdated", { detail: event }));
    });

console.log("Echo listener registered");
console.log("App initialized");
