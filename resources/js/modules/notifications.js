import { useNotification } from "@kyvg/vue3-notification";

const notification = useNotification();

const NotificationHelper = {

    showSuccess(text) {
        notification.notify({
            type: 'success',
            title: "Успех!",
            text: text
        });
    },

    showError(text) {
        notification.notify({
            type: 'error',
            title: "Ошибка!",
            text: text
        });
    },

    showInfo(text) {
        notification.notify({
            title: 'Info',
            text: text
        });
    },
    show(status, text) {
        notification.notify({
            type: status,
            title: `${status.toString().toUpperCase()}!`,
            text: text
        });
    }

};

export default NotificationHelper;
