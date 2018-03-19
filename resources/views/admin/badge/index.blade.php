@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-bordered" id="badges-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Number</th>
                <th></th>
            </tr>
            </thead>
        </table>

    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#badges-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/admin/badges/data',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'number', name: 'number' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
