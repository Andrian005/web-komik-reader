<div class="error-message"></div>
<div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" class="form-control" name="nama" value="{{ $data->name ?? '' }}" id="nama">
</div>
<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" class="form-control" name="slug" value="{{ $data->slug ?? '' }}" id="slug">
</div>
