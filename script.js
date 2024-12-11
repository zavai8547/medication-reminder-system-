function checkReminders() {
    const now = new Date();
    const currentTime = now.toTimeString().substring(0, 5);

    reminders.forEach((reminderTime, index) => {
        if (reminderTime === currentTime) {
            displayNotification(`It's time for your reminder set at ${reminderTime}`);
            reminders.splice(index, 1);
        }
    });
}

function displayNotification(message) {
    const notificationContainer = document.getElementById('notifications') || document.createElement('div');
    notificationContainer.id = 'notifications';
    document.body.appendChild(notificationContainer);

    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerText = message;
    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

setInterval(checkReminders, 60000);
