<div class="row">
    <div class="col-md-4 mb-3">
        <label for="chapter_number" class="form-label fw-semibold">Chapter Number</label>
        <input type="text" name="chapter_number" id="chapter_number" class="form-control number" placeholder="e.g. 1"
            required>
    </div>

    <div class="col-md-8 mb-3">
        <label for="chapter_title" class="form-label fw-semibold">Chapter Title</label>
        <input type="text" name="chapter_title" id="chapter_title" class="form-control" placeholder="e.g. The Beginning"
            required>
    </div>
</div>

<div class="mb-4">
    <label for="release_date" class="form-label fw-semibold">Release Date</label>
    <div class="input-group">
        <input type="text" name="release_date" id="release_date" class="form-control datepicker2" required>
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fa fa-calendar-alt"></i>
            </span>
        </div>
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">Upload Chapter Pages</label>

    <!-- FilePond input -->
    <input type="file" id="chapter-pages" name="chapter_pages[]" multiple accept="image/*">

    <!-- Tombol pemicu -->
    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary me-4" id="btn-folder">
            <i class="fas fa-folder-open me-1"></i> Upload via Folder
        </button>
        <button type="button" class="btn btn-outline-secondary" id="btn-multi">
            <i class="fas fa-images me-1"></i> Upload Multi Gambar
        </button>
    </div>
</div>

