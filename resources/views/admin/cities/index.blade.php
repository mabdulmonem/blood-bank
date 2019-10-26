@extends('admin.layouts.index')

@section('content')
    @push('css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('admin/css/dataTables.bootstrap4.min.css') }}">
    @endpush

    <div class="col-12">
        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المينة</th>
                        <th>اسم المحافظة</th>
                        <th>الحدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{ $i = 1 }}
                    @forelse($cities as $city)
                        <tr>
                            <th>{{ $i++ }}</th>
                            <td>{{ $city->name }}</td>
                            <th>{{ $city->governorate->name }}</th>
                            <th>
                                <a href="{{ admin_url("cities/$city->id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </th>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    @push('js')
        <!-- DataTables -->
        <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/js/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            $("#example1").DataTable();
        </script>

    @endpush


@endsection
