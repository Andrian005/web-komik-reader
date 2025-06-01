@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-body">
            <form action="" method="POST" id="form" enctype="multipart/form-data">
                @csrf
                @include('layouts.partial.validate')
                @include('layouts.partial.success')
                @include('admin.judul.form')
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-success" onclick="store()">Submit</button>
                        <a href="{{ route('dashboard.manajemen-komik.judul.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>

                    <button id="btn-next-chapter" type="button" class="btn btn-primary d-none" onclick="goToChapter()">
                        Next: Buat Chapter
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let lastInsertedId = null;

        function store() {
            var form = $('#form')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('dashboard.manajemen-komik.judul.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    success(response.message);
                    lastInsertedId = response.data.id;
                    $('#btn-next-chapter').removeClass('d-none');
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
