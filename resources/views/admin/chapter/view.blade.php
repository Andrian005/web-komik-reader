@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">{{ $title }} : {{ $data->title }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard.manage-comics.comic-titles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="portlet-body">
            <div id="chapter-list">
                @include('admin.partial.chapter-list', ['chapters' => $chapters, 'data' => $data])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function loadPage(page) {
            const comicId = {{ $data->id }};
            const url = "{{ route('dashboard.manage-comics.comic-titles.chapter.view-chapter', ':comicId') }}"
                .replace(':comicId', comicId) + '?page=' + page;

            $.ajax({
                url: url,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (html) {
                    $('#chapter-list').html(html);
                    $('html, body').animate({ scrollTop: 0 }, 'smooth');
                },
                error: function () {
                    alert('Gagal memuat halaman.');
                }
            });
        }

        function remove(id) {
            $.ajax({
                url: '{{ route("dashboard.manage-comics.comic-titles.chapter.delete", ":id") }}'.replace(':id', id),
                type: "POST",
                data: { _token: '{{ csrf_token() }}' },
                success: function (res) {
                    showSuccess(res.message);
                    blockUI('.portlet-body');
                    const currentPage = {{ $chapters->currentPage() }};
                    loadPage(currentPage);
                },
                error: function (xhr) {
                    let msg = 'Terjadi kesalahan.';
                    if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                    showError(msg);
                }
            });
        }

        function togglePages(button) {
            const $button = $(button);
            const chapterId = $button.data('id');
            const $target = $('#pages-' + chapterId);

            if ($target.is(':visible')) {
                $target.slideUp();
                $button.removeClass('btn-primary active').addClass('btn-outline-primary');
            } else {
                $target.hide().removeClass('d-none').slideDown();
                $button.removeClass('btn-outline-primary').addClass('btn-primary active');
            }
        }
    </script>
@endpush
