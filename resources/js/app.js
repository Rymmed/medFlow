/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const userIdMeta = document.querySelector('meta[name="user-id"]');

    if (userIdMeta) {
        const userId = userIdMeta.getAttribute('content');

        if (userId && window.Echo) {
            window.Echo.private(`consultation.${userId}`)
                .listen('ConsultationStarted', (e) => {
                    alert(`Consultation started! Room Name: ${e.roomName}`);
                    // Vous pouvez aussi mettre à jour l'UI ici pour montrer la notification
                });
        } else {
            if (!userId) {
                console.error("User ID is not defined");
            }
            if (!window.Echo) {
                console.error("Echo is not defined");
            }
        }
    } else {
        console.error("Meta tag with name 'user-id' is not found");
    }
});
