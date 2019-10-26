@extends('admin.layouts.index')

@section('content')
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    @endpush

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-info" href="{{ admin_url('categories/create') }}">إضافة تصنيف</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        {{ $dataTable->table([
                            'class' => 'table table-bordered table-striped dataTable'
                        ]) }}
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

    @push('js')
        <!-- DataTables -->
        <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/js/dataTables.bootstrap4.min.js') }}"></script>
        {!! $dataTable->scripts() !!}
    @endpush


@endsection
