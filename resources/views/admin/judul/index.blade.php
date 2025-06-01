@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered d-flex justify-content-between align-items-center">
            <h3 class="portlet-title">{{ $title }}</h3>
            <a href="{{ route('dashboard.manajemen-komik.judul.create') }}" class="btn btn-primary">
                Create
            </a>
        </div>
        <div class="portlet-body">
            <table id="datatable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Tahun Rilis</th>
                        <th>Status</th>
                        <th>Lihat Chapter</th>
                        <th>Tambah Chapter</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const urlEdit = "{{ route('dashboard.manajemen-komik.judul.edit', ['id' => 'ID']) }}";
    const urlCreateChapter = "{{ route('dashboard.manajemen-komik.chapter.create', ['title_id' => 'ID']) }}";
    const urlViewChapter = "{{ route('dashboard.manajemen-komik.chapter.view-chapter', ['title_id' => 'ID']) }}";

    $(function () {
        $('#datatable').DataTable({
            responsive: true,
            serverSide: true,
            ajax: '{{ route('dashboard.manajemen-komik.judul.index') }}',
            columns: [
                { data: 'title', name: 'title' },
                { data: 'type', name: 'type' },
                { data: 'released_year', name: 'released_year' },
                { data: 'status', name: 'status' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        const link = urlViewChapter.replace('ID', row.id);
                        return `
                            <a href="${link}" class="btn btn-sm btn-primary d-inline-flex" title="Lihat Chapter" style="gap: 6px; padding: 0.375rem 0.75rem; min-width: 110px;">
                                <i class="fas fa-book-open" style="line-height: 1;"></i>
                                <span style="flex-grow: 1; text-align: left;">Lihat Chapter</span>
                            </a>
                        `;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        const link = urlCreateChapter.replace('ID', row.id);
                        return `
                            <a href="${link}" class="btn btn-sm btn-success d-inline-flex" title="Tambah Chapter" style="gap: 6px; padding: 0.375rem 0.75rem; min-width: 110px;">
                                <i class="fas fa-plus" style="line-height: 1;"></i>
                                <span style="flex-grow: 1; text-align: left;">Tambah Chapter</span>
                            </a>
                        `;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        const editLink = urlEdit.replace('ID', row.id);
                        return `
                            <button class="btn btn-sm btn-info" title="Lihat" onclick="view(${row.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="${editLink}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" title="Hapus" onclick="confirmDelete(() => remove(${row.id}))">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-primary btn-merge" title="Gabungkan" onclick="">
                                <i class="fas fa-compress-arrows-alt"></i>
                            </button>
                        `;
                    }
                }
            ]
        });
    });

    function view(id) {
        const url = '{{ route("dashboard.manajemen-komik.judul.view", ":id") }}'.replace(':id', id);
        Modal({
            title: 'View Judul',
            url: url
        });
    }

    function remove(id) {
        $.ajax({
            url: '{{ route("dashboard.manajemen-komik.judul.delete", ":id") }}'.replace(':id', id),
            type: "POST",
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
                showSuccess(res.message);
                blockUI('#datatable');
                $('#datatable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                let msg = 'Terjadi kesalahan.';
                if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                showError(msg);
            }
        });
    }
</script>
@endpush
