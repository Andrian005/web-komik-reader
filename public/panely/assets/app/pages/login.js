"use strict";
$(function () {
    $("#login-form").validate({
        rules: {
            // email: { required: true, email: true },
            username: { required: true },
            password: { required: true, minlength: 6 },
        },
        messages: {
            // email: {
            //     required: "Please enter your email",
            //     email: "Your email is not valid",
            // },
            username: {
                required: "Silakan Masukkan Username Anda",
            },
            password: {
                required: "Silakan berikan Password Anda",
                minlength: $.validator.format(
                    "Harap masukkan setidaknya {0} karakter"
                ),
            },
        },
        submitHandler: function submitHandler(form) {
            form.submit();
        },
    });
});
