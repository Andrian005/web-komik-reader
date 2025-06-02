<div class="error-message"></div>
<div class="success-message"></div>

<div id="success-alert" class="alert alert-success d-none"></div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" slug-source class="form-control"
            value="{{ old('title', $data->title ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" name="slug" id="slug" slug-target class="form-control"
            value="{{ old('slug', $data->slug ?? '') }}" readonly="readonly">
    </div>

    <div class="col-md-6 mb-3">
        <label for="type" class="form-label">Type</label>
        <select name="type" id="type" class="form-select select2">
            <option value="novel" {{ (old('type') ?? $data->type ?? '') == 'novel' ? 'selected' : '' }}>Novel</option>
            <option value="manga" {{ (old('type') ?? $data->type ?? '') == 'manga' ? 'selected' : '' }}>Manga</option>
            <option value="manhua" {{ (old('type') ?? $data->type ?? '') == 'manhua' ? 'selected' : '' }}>Manhua</option>
            <option value="manhwa" {{ (old('type') ?? $data->type ?? '') == 'manhwa' ? 'selected' : '' }}>Manhwa</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select select2">
            <option value="ongoing" {{ (old('status') ?? $data->status ?? '') == 'ongoing' ? 'selected' : '' }}>Ongoing
            </option>
            <option value="completed" {{ (old('status') ?? $data->status ?? '') == 'completed' ? 'selected' : '' }}>
                Completed</option>
            <option value="hiatus" {{ (old('status') ?? $data->status ?? '') == 'hiatus' ? 'selected' : '' }}>Hiatus
            </option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="author_id" class="form-label">Author</label>
        <select name="author_id[]" id="author_id" class="form-select select2" multiple>
            @foreach ($data['authors'] as $author)
                <option value="{{ $author->id }}" @if (in_array($author->id, old('author_id', $data->author_id ?? [])))
                selected @endif>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="artist_id" class="form-label">Artist</label>
        <select name="artist_id[]" id="artist_id" class="form-select select2" multiple>
            @foreach ($data['artists'] as $artist)
                <option value="{{ $artist->id }}" @if (in_array($artist->id, old('artist_id', $data->artist_id ?? [])))
                selected @endif>
                    {{ $artist->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label for="synopsis" class="form-label">Synopsis</label>
        <textarea name="synopsis" id="synopsis" rows="4"
            class="form-control">{{ old('synopsis', $data->synopsis ?? '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label for="genre_id" class="form-label">Genres</label>
        <select name="genre_id[]" id="genre_id" class="form-select select2" multiple required>
            @foreach ($data['genres'] as $genre)
                <option value="{{ $genre->id }}" @if (in_array($genre->id, old('genre_id', $data->genre_id ?? []))) selected
                @endif>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="cover_image" class="form-label">Cover Image</label>
        <div class="d-flex align-items-center">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="cover_image" id="photo"
                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                    data-old-photo="{{ !empty($data->cover_image) ? asset('storage/covers/' . $data->cover_image) : '' }}">
                <label class="custom-file-label" for="cover_image">
                    {{ $data->cover_image ?? 'Choose file' }}
                </label>
            </div>
            <div class="pl-2">
                <button type="button" class="btn btn-primary" onclick="previewPhotoModal()">
                    Preview
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="released_year" class="form-label">Released Year</label>
        <input type="text" name="released_year" id="released_year" class="form-control datepicker"
            value="{{ old('released_year', $data->released_year ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label for="country" class="form-label">Country</label>
        <select name="country" id="country" class="form-select select2" required>
            <option value="">-- Select Country --</option>
            @php
                $countries = ['Indonesia', 'Japan', 'South Korea', 'China', 'USA', 'UK', 'France', 'Germany'];
                $selectedCountry = old('country', $data->country ?? '');
            @endphp
            @foreach ($countries as $country)
                <option value="{{ $country }}" {{ $selectedCountry == $country ? 'selected' : '' }}>
                    {{ $country }}
                </option>
            @endforeach
        </select>
    </div>
</div>
