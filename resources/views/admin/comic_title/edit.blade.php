@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-body">
            <form action="" method="POST" id="form" enctype="multipart/form-data">
                @csrf
                @include('layouts.partial.validate')
                @include('layouts.partial.success')
                @include('admin.comic_title.form')
                <div class="mt-3">
                    <button type="button" class="btn btn-success" onclick="update({{ $data->id }})">Submit</button>
                    <a href="{{ route('dashboard.manage-comics.comic-titles.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function update(id) {
            var form = $('#form')[0];
            var formData = new FormData(form);
            $.ajax({
                url: '{{ route("dashboard.manage-comics.comic-titles.update", ":id") }}'.replace(':id', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    success(response.message);
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
@endpush
