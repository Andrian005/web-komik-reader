<div class="table-responsive">
    <table class="table table-borderless align-middle">
        <tbody>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-tags text-primary me-3"></i> Nama Genre
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
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-calendar-alt text-info me-3"></i> Created At
                </td>
                <td>:</td>
                <td>{{ $data->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
