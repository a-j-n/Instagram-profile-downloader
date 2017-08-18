$('.send').click(function () {
    var username = $('.username').val().trim();
    window.location = "{{url('user/')}}"+"/"+username;
});
