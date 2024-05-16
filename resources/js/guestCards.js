window.onload = function() {
    var container = document.getElementById('info');
    var cardWidth = document.querySelector('.card').offsetWidth;
    if (window.matchMedia('(max-width: 575px)').matches) {
        container.scrollLeft = cardWidth * 1.75;
    } else {
        container.scrollLeft = cardWidth * 1.25;
    }
};
