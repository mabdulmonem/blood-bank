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
                        <th>اسم مقدم الشكوى</th>
                        <th>اسم المتبرع</th>
                        <th>الشكوى</th>
                        <th width="82px" style="width: 82px !important;">الحدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{ $i = 1 }}
                    @forelse($reports as $report)
                        <tr>
                            <th>{{ $i++ }}</th>
                            <td>{{ $report->client->name }}</td>
                            <td>{{ $report->donationRequest->name }}</td>
                            <th><strong>{{ $report->title }}</strong> - {{ \Illuminate\Support\Str::limit($report->details,40) }}</th>
                            <th>
                                <a href="{{ admin_url("reports/$report->id") }}" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>                            </th>
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
