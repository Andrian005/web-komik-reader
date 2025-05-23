<script>
    function validation(errors) {
        var validations = '<div class="alert alert-danger position-relative">';
        validations += '<button type="button" class="btn btn-text-light btn-icon alert-dismiss bg-danger text-light position-absolute" style="right: 10px;" data-dismiss="alert">';
        validations += '<i class="fa fa-times"></i>';
        validations += '</button>';
        validations += '<ul style="margin-left: -20px; margin-top: 10px;">';
        $.each(errors.errors, function (i, error) {
            validations += '<li>' + error[0].charAt(0).toUpperCase() + error[0].slice(1) + '</li>';
        });
        validations += '</ul>';
        validations += '</div>';
        return validations;
    }
</script>
