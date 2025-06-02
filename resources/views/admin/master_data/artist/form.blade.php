<div class="error-message"></div>

<div class="form-group">
    <label for="name">Nama</label>
    <input type="text" class="form-control" name="name" slug-source value="{{ $data->name ?? '' }}" id="name">
</div>

<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" class="form-control" name="slug" slug-target value="{{ $data->slug ?? '' }}" id="slug"
        readonly="readonly">
</div>

<div class="form-group">
    <label for="bio">
        Bio <small class="text-muted">(Opsional)</small>
    </label>
    <textarea rows="4" class="form-control" name="bio" id="bio">{{ $data->bio ?? '' }}</textarea>
</div>

<div class="form-group">
    <label for="photo" class="form-label">
        Photo <small class="text-muted">(Opsional)</small>
    </label>
    <div class="d-flex align-items-center">
        <div class="custom-file flex-grow-1">
            <input type="file" class="custom-file-input" name="photo" id="photo"
                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                data-old-photo="{{ !empty($data->photo) ? asset('storage/photo_artist/' . $data->photo) : '' }}">
            <label class="custom-file-label" for="photo">
                {{ $data->photo ?? 'Choose file' }}
            </label>
        </div>
        <div class="pl-2">
            <button type="button" class="btn btn-primary" onclick="previewPhotoModal()">Preview</button>
        </div>
    </div>
</div>
