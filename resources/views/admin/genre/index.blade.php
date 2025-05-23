@extends('layouts.main')

@section('content')
    <div class="portlet">
        @include('admin.genre.create')
        <div class="portlet-header portlet-header-bordered">
            <h3 class="portlet-title">{{ $title }}</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form-create">
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
                    url: '{{ route('dashboard.master.genre.index') }}',
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
