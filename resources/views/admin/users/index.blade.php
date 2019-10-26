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
                        <th>اسم المستخدم</th>
                        <th>الريد الالكترونى</th>
                        <th>فصيلة الدم</th>
                        <th>الصلاحيات</th>
                        <th width="82px" style="width: 82px !important;">الحدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    <span style="display: none">{{ $i = 1 }}</span>
                    @forelse($users as $user)
                        <tr>
                            <th>{{ $i++ }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <th>{{ $user->email }}</th>
                            <th>{!! $user->blood_type_id ? $user->bloodType->name : "<span class='text-center'>-</span>"  !!}</th>
                            <th>{{ ucfirst(get_role_name($user)) }}</th>
                            <th>
                                <a href="{{ admin_url("users/$user->id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="form-delete">
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
