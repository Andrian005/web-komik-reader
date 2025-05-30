<script>
    function success(message) {
        var alert = `
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                <div>${message}</div>
            </div>
        `;
        $('.success-message').html(alert);
    }
</script>
