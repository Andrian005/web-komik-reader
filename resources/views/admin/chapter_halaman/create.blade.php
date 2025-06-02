@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">Judul : {{ $data->title }}</h3>
        </div>
        <div class="portlet-body">
            <form action="" method="POST" id="chapter-form" enctype="multipart/form-data">
                @csrf
                @include('layouts.partial.validate')
                @include('admin.chapter_halaman.form')
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('dashboard.manage-comics.comic-titles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success" onclick="store()">
                            <i class="fas fa-save me-1"></i> Simpan Chapter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let pond;

        const csrfToken = '{{ csrf_token() }}';
        const inputElement = document.querySelector('#chapter-pages');
        let fileCounter = 1;

        $(function () {
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize
            );

            const csrfToken = '{{ csrf_token() }}';

            const pondOptions = {
                allowMultiple: true,
                maxFiles: 20,
                maxFileSize: '5MB',
                labelIdle: `
                    <span><i class="fas fa-upload" style="margin-right: 8px;"></i>
                    Drag & Drop gambar di sini atau <span class="filepond--label-action">Browse</span></span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'],
                server: {
                    process: {
                        url: '{{ route("chapter_pages.upload") }}',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    },
                    revert: {
                        url: '{{ route("chapter_pages.delete") }}',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    }
                }
            };

            const $input = $('#chapter-pages');
            pond = FilePond.create($input[0], pondOptions);

            function toggleActiveBtn($btn) {
                $('#btn-folder').removeClass('btn-primary active').addClass('btn-outline-primary');
                $('#btn-multi').removeClass('btn-secondary active').addClass('btn-outline-secondary');

                if ($btn.is('#btn-folder')) {
                    $btn.removeClass('btn-outline-primary').addClass('btn-primary active');
                } else {
                    $btn.removeClass('btn-outline-secondary').addClass('btn-secondary active');
                }
            }

            function switchMode(mode) {
                pond.destroy();

                setTimeout(() => {
                    if (mode === 'folder') {
                        $input.removeAttr('multiple accept').prop('webkitdirectory', true);
                        toggleActiveBtn($('#btn-folder'));
                    } else {
                        $input.removeAttr('webkitdirectory').attr({ multiple: true, accept: 'image/*' });
                        toggleActiveBtn($('#btn-multi'));
                    }

                    pond = FilePond.create($input[0], pondOptions);
                }, 0);
            }

            $('#btn-folder').on('click', () => switchMode('folder'));
            $('#btn-multi').on('click', () => switchMode('multi'));

            toggleActiveBtn($('#btn-multi'));
        });

        function store() {
            let form = $('#chapter-form')[0];
            let formData = new FormData(form);
            let uploadedFiles = pond.getFiles().map(fileItem => fileItem.serverId);
            formData.append('uploaded_files', JSON.stringify(uploadedFiles));
            $.ajax({
                url: "{{ route('dashboard.manage-comics.comic-titles.chapter.store', ['comic_title_id' => $data->id]) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showSuccess(response.message);
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
