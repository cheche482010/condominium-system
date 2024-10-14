$(document).ready(function() {
    $('.toggle-password').click(function(e) {
        e.preventDefault();
        var passwordField = document.getElementById("password-field");
        if (passwordField.type === "password") {
            $(".password").attr("type", "text");
            $(this).find('span').removeClass('fa-eye-slash').addClass('fa-eye');
            $(".password").focus();
        } else {
            $(".password").attr("type", "password");
            $(this).find('span').removeClass('fa-eye').addClass('fa-eye-slash');
            $(".password").focus();
        }
    });
});