@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">{{ $title }} : {{ $data->title }}</h3>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard.manajemen-komik.judul.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-book-open mr-2"></i>
                <div>
                    Total Chapter : <strong class="ms-1">{{ $data->chapters->count() }}</strong>
                </div>
            </div>

            @forelse ($data->chapters->sortBy('chapter_number') as $chapter)
                <div class="border rounded shadow-sm p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h5 class="mb-1 text-primary">
                                <i class="fas fa-book-open me-1"></i>
                                Chapter {{ rtrim(rtrim(number_format($chapter->chapter_number, 2, '.', ''), '0'), '.') }}
                                @if($chapter->chapter_title)
                                    - {{ $chapter->chapter_title }}
                                @endif
                            </h5>
                            <small class="text-muted">Rilis: {{ $chapter->release_date }}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-primary toggle-pages" data-id="{{ $chapter->id }}">
                            <i class="fas fa-eye me-1"></i> Lihat Pages
                        </button>
                    </div>

                    <div class="chapter-pages d-none mt-3" id="pages-{{ $chapter->id }}">
                        @if ($chapter->chapterPages->isEmpty())
                            <div class="alert alert-warning p-2 mb-0">Belum ada halaman.</div>
                        @else
                            <div class="row">
                                @foreach ($chapter->chapterPages->sortBy('page_number') as $page)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3 text-center">
                                        <div class="border rounded p-2 h-100">
                                            <img src="{{ asset('storage/chapter-pages/' . $page->image_path) }}"
                                                alt="Page {{ $page->page_number }}" class="img-fluid rounded mb-1">
                                            <div class="small text-muted">Hal. {{ $page->page_number }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-secondary">Belum ada chapter yang tersedia.</div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.toggle-pages', function () {
            const chapterId = $(this).data('id');
            const $target = $('#pages-' + chapterId);
            const $button = $(this);

            if ($target.is(':visible')) {
                $target.slideUp();
                $button.removeClass('btn-primary active').addClass('btn-outline-primary');
            } else {
                $target.hide().removeClass('d-none').slideDown();
                $button.removeClass('btn-outline-primary').addClass('btn-primary active');
            }
        });
    </script>
@endpush
