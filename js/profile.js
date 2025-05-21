$(document).ready(function () {
  const token = localStorage.getItem('session_token');

  if (!token) {
    alert('No session found. Please log in.');
    window.location.href = 'login.html';
    return;
  }

  $.ajax({
    url: 'php/profile.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ token, action: 'get' }),
    success: function (res) {
      if (res.success) {
        $('#username').text(res.profile.username);
        $('#age').val(res.profile.age);
        $('#dob').val(res.profile.dob);
        $('#contact').val(res.profile.contact);
      } else {
        alert(res.message);
        window.location.href = 'login.html';
      }
    },
    error: function () {
      alert('Error loading profile.');
    },
  });

  $('#update-btn').on('click', function () {
    const updatedData = {
      token,
      action: 'update',
      age: $('#age').val(),
      dob: $('#dob').val(),
      contact: $('#contact').val(),
    };

    $.ajax({
      url: 'php/profile.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(updatedData),
      success: function (res) {
        alert(res.message);
      },
      error: function () {
        alert('Error updating profile.');
      },
    });
  });
});
