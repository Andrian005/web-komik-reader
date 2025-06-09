@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">Judul : {{ $chapter->title->title }}</h3>
        </div>
        <div class="portlet-body">
            <form action="" method="POST" id="chapter-form" enctype="multipart/form-data">
                @csrf
                @include('layouts.partial.validate')
                @include('admin.chapter.form')
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('dashboard.manage-comics.comic-titles.chapter.view-chapter', $chapter->title->id) }}"
                        class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success" onclick="update()">
                            <i class="fas fa-save me-1"></i> Update Chapter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
@include('admin.chapter.script')
    <script>
        const isEditPage = true;

        function update() {
            if (pond.getFiles().some(f => f.status !== FilePond.FileStatus.PROCESSING_COMPLETE)) {
                return showError('Mohon tunggu hingga semua gambar selesai diunggah.');
            }

            const formData = new FormData($('#chapter-form')[0]);

            const orderedFiles = pond.getFiles().map(f => {
                return f.origin === FilePond.FileOrigin.LOCAL
                    ? f.getMetadata('serverFileName')
                    : f.serverId;
            });

            formData.append('ordered_files', JSON.stringify(orderedFiles));

            $.ajax({
                url: "{{ route('dashboard.manage-comics.comic-titles.chapter.update', ['chapter' => $chapter->id]) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showSuccess(response.message);
                    if (response.chapterPages) {
                        reloadFilePondFiles(response.chapterPages);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        $('.error-message').html(validation(xhr.responseJSON));
                    } else {
                        showError(xhr.responseJSON?.message || 'Terjadi kesalahan.');
                    }
                }
            });
        }

        initFilePond();
    </script>
@endpush
