<div class="table-responsive">
    <table class="table table-borderless align-middle">
        <tbody>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-book text-primary me-3"></i> Judul Komik
                </td>
                <td>:</td>
                <td>{{ $data->title ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-link text-secondary me-3"></i> Slug
                </td>
                <td>:</td>
                <td>{{ $data->slug ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-tag text-info me-3"></i> Type
                </td>
                <td>:</td>
                <td>{{ $data->type ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap align-top">
                    <i class="fas fa-align-left text-muted me-3"></i> Synopsis
                </td>
                <td class="align-top">:</td>
                <td>{{ $data->synopsis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-pen-nib text-warning me-3"></i> Author
                </td>
                <td>:</td>
                <td>{{ $data->authors->pluck('name')->join(', ') ?: '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-paint-brush text-danger me-3"></i> Artist
                </td>
                <td>:</td>
                <td>{{ $data->artists->pluck('name')->join(', ') ?: '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-th-large text-success me-3"></i> Genre
                </td>
                <td>:</td>
                <td>{{ $data->genres->pluck('name')->join(', ') ?: '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-calendar-alt text-primary me-3"></i> Tahun Rilis
                </td>
                <td>:</td>
                <td>{{ $data->released_year ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-flag text-info me-3"></i> Negara Pembuat
                </td>
                <td>:</td>
                <td>{{ $data->country ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-eye text-secondary me-3"></i> Views
                </td>
                <td>:</td>
                <td>{{ $data->views ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-star text-warning me-3"></i> Rating
                </td>
                <td>:</td>
                <td>{{ $data->rating ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-info-circle text-success me-3"></i> Status
                </td>
                <td>:</td>
                <td>
                    @php
                        $status = $data->status;
                        $statusLabel = '-';
                        $statusClass = 'text-muted';

                        if ($status === 'ongoing') {
                            $statusLabel = 'Ongoing';
                            $statusClass = 'badge bg-success';
                        } elseif ($status === 'hiatus') {
                            $statusLabel = 'Hiatus';
                            $statusClass = 'badge bg-warning text-dark';
                        } elseif ($status === 'completed') {
                            $statusLabel = 'Completed';
                            $statusClass = 'badge bg-primary';
                        }
                    @endphp
                    <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-semibold text-nowrap">
                    <i class="fas fa-clock text-muted me-3"></i> Created At
                </td>
                <td>:</td>
                <td>{{ $data->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
