<form id="form" class="mt-3">
    @csrf
    @include('layouts.partial.validate')
    @include('admin.genre.form')
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary me-2" onclick="update({{ $data->id }})">Edit</button>
    </div>
</form>

<script>
    function update(id) {
        let formData = $('#form').serialize();
        $.ajax({
            url: '{{ route("dashboard.manajemen-komik.genre.update", ":id") }}'.replace(':id', id),
            type: "POST",
            data: formData,
            success: function (response) {
                $('#modal').modal('hide');
                showSuccess(response.message);
                blockUI('#datatable');
                dataTable.ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    $('.error-message').html(validation(xhr.responseJSON));
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showError(message);
                }
            }
        });
    }
</script>
