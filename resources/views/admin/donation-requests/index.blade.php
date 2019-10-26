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
                        <th>اسم المريض</th>
                        <th>رقم الهاتف</th>
                        <th>اسم المستشفى</th>
                        <th>عدد حقائب الدم</th>
                        <th>فصيلة الدم</th>
                        <th>البلد</th>
                        <th width="82px" style="width: 82px !important;">الحدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{ $i = 1 }}
                    @forelse($donations as $donation)
                        <tr>
                            <th>{{ $i++ }}</th>
                            <td>{{ $donation->name }}</td>
                            <td>{{ $donation->phone }}</td>
                            <th>{{ $donation->hospital_name }}</th>
                            <th>{{ $donation->blood_bags_count }}</th>
                            <th>{{ ucwords($donation->bloodType->name) }}</th>
                            <th>{{ $donation->city->governorate->name . ' - ' . $donation->city->name }}</th>
                            <th>
                                <a href="{{ admin_url("donation-requests/$donation->id") }}" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                                <form action="{{ route('donation-requests.destroy', $donation->id) }}" method="POST" class="form-delete">
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
