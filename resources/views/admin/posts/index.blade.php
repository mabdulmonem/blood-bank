@extends('admin.layouts.index')

@section('content')
    @push('css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('admin/css/dataTables.bootstrap4.min.css') }}">
    @endpush

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-info" href="{{ admin_url('posts/create') }}">إضافة مقال</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة المصغرة</th>
                        <th>عنوان المقال</th>
                        <th>كاتب المقال</th>
                        <th>التصنيف</th>
                        <th>الحالة</th>
                        <th>الحدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{ $i = 1 }}
                    @forelse($posts as $post)
                        <tr>
                            <th>{{ $i++ }}</th>
                            <th><img src="{{ image($post->img,true) }}" class="image-rounded" alt="{{ $post->title }}"></th>
                            <td>{{ $post->title }}</td>
                            <th>{{ $post->user->name }}</th>
                            <td>{{ $post->category->name }}</td>
                            <th>{{ $post->status == 'publish' ? 'منشور' : 'محفوظ' }}</th>
                            <th>
                                <a href="{{ url("article/$post->id") }}" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                                <a href="{{ admin_url("posts/$post->id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="form-delete">
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
                    body: "هل انت متأكد من حذف هذا المنشور" + $(this).data('title'),
                    autohide: true,
                    delay: 1500,
                    position: 'topLeft',
                })
            });
        </script>

    @endpush


@endsection
