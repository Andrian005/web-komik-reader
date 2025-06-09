@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">Chapter : {{ $data->chapter }}</h3>
        </div>
        <div class="portlet-body">
            <form id="chapter-form" enctype="multipart/form-data" method="POST">
                @csrf
                @include('layouts.partial.validate')
                @include('admin.chapter.form')
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('dashboard.manage-comics.comic-titles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="button" class="btn btn-success" onclick="store()">
                        <i class="fas fa-save me-1"></i> Simpan Chapter
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @include('admin.chapter.script')
    <script>
        const isEditPage = false;

        pond = FilePond.create($input[0], pondOptions);

        function store() {
            if (pond.getFiles().some(file => file.status !== 5)) {
                showError('Mohon tunggu hingga semua gambar selesai diunggah.');
                return;
            }

            let formData = new FormData($('#chapter-form')[0]);
            let chapterPages = pond.getFiles().map(file => file.serverId);
            formData.append('chapter_pages', JSON.stringify(chapterPages));

            $.ajax({
                url: "{{ route('dashboard.manage-comics.comic-titles.chapter.store', ['comic_title_id' => $data->id]) }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showSuccess(response.message);
                    $('#chapter-form')[0].reset();
                    pond.removeFiles();

                    const currentVal = parseFloat($chapterNumberInput.val());
                    if (!isNaN(currentVal)) {
                        $chapterNumberInput.val(currentVal + 1);
                    }
                },
                error: function (xhr) {
                    let message = 'Terjadi kesalahan.';
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showError(message);
                }
            });
        }
    </script>
@endpush
