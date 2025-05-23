<div class="modal fade" id="form-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Genre</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form id="form">
                @csrf
                @include('admin.genre.form')
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mr-2" onclick="store()">Create</button>
                    <button class="btn btn-outline-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function store() {
        let formData = $('#form').serialize();
        $.ajax({
            url: "{{ route('dashboard.master.genre.store') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                $('#form-create').modal('hide');
                $('#form')[0].reset();
                showSuccess(response.message);
                blockUI('#datatable');
                dataTable.ajax.reload();
            },
            error: function (xhr) {
                $('.error-message').html(validation(xhr.responseJSON));
            }
        });
    }
</script>
