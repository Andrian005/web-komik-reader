<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-book-open mr-2"></i>
    <div>
        Total Chapter : <strong class="ml-1">{{ $data->chapters->count() }}</strong>
    </div>
</div>

@if ($chapters->count() > 0)
    @foreach ($chapters as $chapter)
        <div class="border rounded shadow-sm p-3 mb-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center mb-2">
                <div>
                    <h5 class="mb-1 text-primary">
                        <i class="fas fa-book-open mr-1"></i>
                        Chapter {{ rtrim(rtrim(number_format($chapter->chapter_number, 2, '.', ''), '0'), '.') }}
                        @if($chapter->chapter_title)
                            - {{ $chapter->chapter_title }}
                        @endif
                    </h5>
                    <small class="text-muted">Rilis: {{ $chapter->release_date }}</small>
                </div>
                <div class="d-flex align-items-center mt-2 mt-md-0">
                    <div class="btn-group btn-sm">
                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Opsi
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('dashboard.manage-comics.comic-titles.chapter.edit', $chapter->id) }}">
                                <i class="fas fa-edit mr-2"></i> Edit Chapter
                            </a>
                            <button type="button" onclick="confirmDelete(() => remove({{ $chapter->id }}))"
                                class="dropdown-item text-danger d-flex align-items-center">
                                <i class="fas fa-trash-alt mr-2"></i> Hapus Chapter
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center mr-3 toggle-pages"
                        data-id="{{ $chapter->id }}" onclick="togglePages(this)" aria-expanded="false"
                        aria-controls="pages-{{ $chapter->id }}">
                        <i class="fas fa-eye mr-2"></i> Lihat Pages
                    </button>
                </div>
            </div>

            <div class="chapter-pages d-none mt-3" id="pages-{{ $chapter->id }}">
                @if ($chapter->chapterPages->isEmpty())
                    <div class="alert alert-warning p-2 mb-0">Belum ada halaman.</div>
                @else
                    <div class="row">
                        @foreach ($chapter->chapterPages->sortBy('page_number') as $page)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3 text-center">
                                <div class="border rounded p-3 h-100 d-flex flex-column justify-content-between">
                                    @php
                                        $imagePath = 'storage/chapter-pages/' . $page->image_path;
                                        $imageExists = file_exists(public_path($imagePath));
                                    @endphp

                                    <img src="{{ $imageExists ? asset($imagePath) : asset('assets/image/image-not-found.png') }}"
                                        alt="Page {{ $page->page_number }}" class="img-fluid rounded mb-3"
                                        style="max-height: 150px; object-fit: cover;">
                                    <div class="small text-muted mb-3">Hal. {{ $page->page_number }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-end mt-3">
        <ul class="pagination">
            <li class="page-item {{ $chapters->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="javascript:void(0)"
                    onclick="loadPage({{ $chapters->currentPage() - 1 }})">Previous</a>
            </li>

            @for ($i = 1; $i <= $chapters->lastPage(); $i++)
                <li class="page-item {{ $chapters->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="javascript:void(0)" onclick="loadPage({{ $i }})">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item {{ !$chapters->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="javascript:void(0)"
                    onclick="loadPage({{ $chapters->currentPage() + 1 }})">Next</a>
            </li>
        </ul>
    </div>
@else
    <div class="alert alert-secondary">Belum ada chapter yang tersedia.</div>
@endif
