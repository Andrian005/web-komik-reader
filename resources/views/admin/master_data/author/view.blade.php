<div class="table-responsive">
    <table class="table table-borderless align-middle">
        <tbody>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-user text-primary me-3"></i> Nama Author
                </td>
                <td>:</td>
                <td>{{ $data->name }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-link text-secondary me-3"></i> Slug
                </td>
                <td>:</td>
                <td>{{ $data->slug }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap align-top">
                    <i class="fas fa-info-circle text-muted me-3"></i> Bio
                </td>
                <td class="align-top">:</td>
                <td>{{ $data->bio ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap align-top">
                    <i class="fas fa-image text-success me-3"></i> Photo
                </td>
                <td class="align-top">:</td>
                <td>
                    @if ($data->photo)
                        <img src="{{ asset('storage/photo_author/' . $data->photo) }}" alt="Author Photo"
                            class="img-thumbnail" style="max-height: 150px;">
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-calendar-alt text-info me-3"></i> Created At
                </td>
                <td>:</td>
                <td>{{ $data->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
