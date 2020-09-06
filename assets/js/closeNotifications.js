  // DISMISS NOTIFICATION MESSAGES
  const closeNotification = document.getElementById('closeNotification');
  closeNotification.addEventListener('click', function () 
  {
    const div = document.getElementById('msg')
    div.style.display = "none";
  });