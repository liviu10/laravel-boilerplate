let chat_with_us = document.getElementById('chat_with_us');

chat_with_us.onclick = function(event) {
  var phoneNumber = event.currentTarget.getAttribute('data-phone-number');
  var message = event.currentTarget.getAttribute('data-message');

  var url = `https://wa.me/${phoneNumber}`;
  if (message != null && message !== undefined) {
    url += `?text=${encodeURIComponent(message)}`;
  }
  window.location.href = url;
};