$(document).ready(function () {
  $('#logout-btn').on('click', function () {
    localStorage.removeItem('session_token');
    window.location.href = 'login.html';
  });
});
