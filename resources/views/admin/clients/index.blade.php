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
                        <th>اسم العميل</th>
                        <th>الريد الالكترونى</th>
                        <th>البلد</th>
                        <th>الحالة</th>
                        <th>الحدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{ $i = 1 }}
                    @forelse($clients as $client)
                        <tr>
                            <th>{{ $i++ }}</th>
                            <td>{{ $client->name }}</td>
                            <th>{{ $client->email }}</th>
                            <td>{{ $client->city->governorate->name . ' - ' . $client->city->name }}</td>
                            <th>{{ $client->status == 'active' ? 'نشط' : 'محظور' }}</th>
                            <th>
                                <a href="{{ url("profile/$client->id") }}" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                                <form action="{{ admin_url("client/status") }}" method="POST" class="form-delete">
                                    @csrf
                                    <input type="hidden" value="{{ $client->id }}" name="id">
                                    <input type="hidden" value="{{ $client->status == 'active' ? 'deactivate' : 'active' }}" name="status">
                                    <button class="btn btn-{{ $client->status == 'active' ? 'danger' : 'success' }}"><i class="fa fa-ban"></i></button>
                                </form>
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="form-delete">
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
            $('.toastsDefaultDanger').click(function() {
                $(document).Toasts('create', {
                    title: 'رسالة تأكيد',
                    body: "هل انت متأكد من حذف هذا العميل" + $(this).data('title'),
                    autohide: true,
                    delay: 1500,
                    position: 'topLeft',
                })
            });
        </script>

    @endpush


@endsection
