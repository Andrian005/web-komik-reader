@extends('layouts.main')

@section('content')
    <div class="portlet">
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">{{ $title }}</h3>
            <button class="btn btn-primary" onclick="create()">
                Create
            </button>
        </div>
        <div class="portlet-body">
            <table id="datatable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Genre</th>
                        <th>slug</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            dataTable = $("#datatable").DataTable({
                responsive: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('dashboard.manajemen-komik.genre.index') }}',
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `
                                <button class="btn btn-sm btn-info" title="Lihat" onclick="view(${row.id})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Edit" onclick="edit(${row.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" title="Hapus" onclick="confirmDelete(() => remove(${row.id}))">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });
        });

        function create() {
            Modal({
                title: 'Create Genre',
                url: '{{ route('dashboard.manajemen-komik.genre.create') }}'
            });
        }

        function view(id) {
            const url = '{{ route("dashboard.manajemen-komik.genre.view", ":id") }}'.replace(':id', id);
            Modal({
                title: 'View Genre',
                url: url
            });
        }

        function edit(id) {
            const url = '{{ route("dashboard.manajemen-komik.genre.edit", ":id") }}'.replace(':id', id);
            Modal({
                title: 'Edit Genre',
                url: url
            });
        }

        function remove(id) {
            $.ajax({
                url: '{{ route("dashboard.manajemen-komik.genre.delete", ":id") }}'.replace(':id', id),
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    showSuccess(response.message);
                    blockUI('#datatable');
                    dataTable.ajax.reload();
                },
                error: function (xhr) {
                    let message = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showError(message);
                }
            });
        }
    </script>
@endpush
