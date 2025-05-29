<div class="table-responsive">
    <table class="table mb-0">
        <tr>
            <th style="border: 0; width: 120px; padding-left: 0;">Nama Artist</th>
            <td style="border: 0; width: 1px;">:</td>
            <td style="border: 0;">{{ $data->name }}</td>
        </tr>
        <tr>
            <th style="border: 0; padding-left: 0;">Slug</th>
            <td style="border: 0;">:</td>
            <td style="border: 0;">{{ $data->slug }}</td>
        </tr>
        <tr>
            <th style="border: 0; padding-left: 0;">Bio</th>
            <td style="border: 0;">:</td>
            <td style="border: 0;">{{ $data->bio ?? '-' }}</td>
        </tr>
        <tr>
            <th style="border: 0; padding-left: 0;">Photo</th>
            <td style="border: 0;">:</td>
            <td style="border: 0;">
                @if ($data->photo)
                    <img src="{{ asset('storage/photo_artist/' . $data->photo) }}" alt="Artist Photo"
                        style="max-height: 150px;">
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th style="border: 0; padding-left: 0;">Created At</th>
            <td style="border: 0;">:</td>
            <td style="border: 0;">{{ $data->created_at }}</td>
        </tr>
    </table>
</div>
