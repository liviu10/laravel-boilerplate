import './bootstrap';

// Close the alert section after 5 seconds
var alert = document.getElementById('profile_alert');
if (alert) {
    var delay = 5000;
    setTimeout(function() {
        setTimeout(function() {
            alert.remove();
        }, 500);
    }, delay);
}
