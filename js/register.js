$(document).ready(function () {
  $('#register-btn').on('click', function () {
    const username = $('#username').val().trim();
    const password = $('#password').val().trim();
    const contact = $('#contact').val().trim();

    if (username === '' && password === '') {
      $('.user-error').text('! Required');
      $('.pass-error').text('! Required');
      return;
    }
    if (username === '') {
      $('.user-error').text('! Required');
      $('.user-error').text('');
      return;
    }
    if (password === '') {
      $('.user-error').text('! Required');
      $('.user-error').text('');

      return;
    }

    if (username && password) {
      $('.user-error').text('');
      $('.pass-error').text('');
    }
    const userData = {
      username,
      password,
      contact,
    };

    $.ajax({
      url: 'php/register.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(userData),
      success: function (res) {
        alert(res.message);
        if (res.success) {
          window.location.href = 'login.html';
        }
      },
      error: function () {
        alert('Error while registering.');
      },
    });
  });
});
