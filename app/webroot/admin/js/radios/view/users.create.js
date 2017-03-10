$(function()
{
    $('#btnGenPassword').on('click', function(e)
    {
        var randomPassword = admin.utils.genRandomPassword();

        $('#UserPassword').val(randomPassword);
        $('#UserConfirmPassword').val(randomPassword);

        admin.utils.notification.flash('info', 'Senha aleatória gerada com sucesso!');
    });

    $('#btnShowPassword').on('click', function(e)
    {
        var eyeIcon      = '<i class="glyphicon glyphicon-eye-open"></i>',
            closeEyeIcon = '<i class="glyphicon glyphicon-eye-close"></i>';

        if ($(this).hasClass('hide-password')) {
            // Show the password in both fields and change the button icon
            $(this).html(eyeIcon);
            $(this).removeClass('hide-password').addClass('show-password');

            $('#UserPassword').attr('type', 'text');
            $('#UserConfirmPassword').attr('type', 'text');
        } else {
            // Hide the password in both fields and change the button icon
            $(this).html(closeEyeIcon);
            $(this).removeClass('show-password').addClass('hide-password');

            $('#UserPassword').attr('type', 'password');
            $('#UserConfirmPassword').attr('type', 'password');
        }
    });
});
