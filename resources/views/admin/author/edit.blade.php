<form id="form" class="mt-3" enctype="multipart/form-data">
    @csrf
    @include('layouts.partial.validate')
    @include('admin.author.form')
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary me-2" onclick="update({{ $data->id }})">Update</button>
    </div>
</form>

<script>
    function update(id) {
        let form = $('#form')[0];
        let formData = new FormData(form);
        $.ajax({
            url: '{{ route("dashboard.manajemen-komik.author.update", ":id") }}'.replace(':id', id),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
                    let message = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showError(message);
                }
            }
        });
    }
</script>
