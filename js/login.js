$('#login-btn').on('click', function () {
  const username = $('#username').val().trim();
  const password = $('#password').val().trim();

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

  const credentials = {
    username: username,
    password: password,
  };

  $.ajax({
    url: 'php/login.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(credentials),
    success: function (res) {
      if (res.success) {
        localStorage.setItem('session_token', res.token);
        window.location.href = 'profile.html';
      } else {
        alert(res.message);
      }
    },
    error: function () {
      alert('Error while logging in.');
    },
  });
});
