$(document).ready(function() {
    $('#adminLogin').submit(function(event) {
        event.preventDefault();

        var email = $('#admin_email');
        var password = $('#admin_password');
        var emailError = $('#email-error');
        var passwordError = $('#password-error');
        var fallbackError = $('#fallback-error');
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        email.css('border', '');
        email.css('border-bottom', '1px solid #9e9e9e');
        password.css('border', '');
        password.css('border-bottom', '1px solid #9e9e9e');
        emailError.html('');
        passwordError.html('Never share your password with anyone!');
        fallbackError.html('');
        if (passwordError.hasClass('red-text')) {
            passwordError.toggleClass('red-text');
        }


        if ((email.val() == '' || email.val() == null) && (password.val() == '' || password.val() == null)) {
            email.css('border', '1px solid red');
            emailError.html('E-mail cannot be empty!');
            password.css('border', '1px solid red');
            passwordError.html('Password cannot be empty!');
            passwordError.toggleClass('red-text');
        } else if (email.val() == '' || email.val() == null) {
            email.css('border', '1px solid red');
            emailError.html('E-mail cannot be empty!');
        } else if (password.val() == '' || password.val() == null) {
            password.css('border', '1px solid red');
            passwordError.html('Password cannot be empty!');
            passwordError.toggleClass('red-text');
        } else if (!emailReg.test(email.val())) {
            email.css('border', '1px solid red');
            emailError.html('Please enter a valid email!');
        } else {
            $('#adminLogin').hide();
            $('#login_loader').show();
            $.ajax({
                url: 'ajax/handlers/check_admin.ajax.php',
                type: 'POST',
                data: {admin_email: email.val()},
                cache: false,
                success: function(data) {
                    if (data == 1) {
                        $.ajax({
                            url: 'ajax/login-handler/verify_admin.ajax.php',
                            type: 'POST',
                            data: {
                                admin_email: email.val(),
                                admin_password: password.val(),
                                login_button: true
                            },
                            cache: false,
                            success: function(data) {
                                if (data == 0) {
                                    $('#adminLogin').show();
                                    $('#login_loader').hide();
                                    password.css('border', '1px solid red');
                                    passwordError.html('Incorrect password');
                                } else if (data == 1) {
                                    location = 'dashboard.php';
                                }
                            }
                        });
                    } else {
                        $('#adminLogin').show();
                        $('#login_loader').hide();
                        email.css('border', '1px solid red');
                        emailError.html('Oops, you do not have the authority!');
                    }
                }
            });
        }
    });
});