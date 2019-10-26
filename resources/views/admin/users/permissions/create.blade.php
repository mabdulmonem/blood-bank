@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ route('permissions.store') }}" method="post">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">عنوان الصحلاحية</label>
                        <input class="form-control" name="name" value="{{ old('name') }}" placeholder="عنوان الصحلاحية" id="name">
                    </div>
                    <div class="form-group">
                        <label for="permission"> [ إفصل بين الصلاحيات ب فاصلة , ]الصلاحيات</label>
                        <ul class="permissions-list">
                        </ul>
                        <input class="form-control" name="permission" value="{{ old('permission') }}" placeholder="الصلاحيات" id="permission">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary submit"> إنشاء</button>
                    </div>
                    <a href="{{ admin_url('permissions') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </form>
    </div>
    <!-- /.col -->
@push('js')
    <script>
        // $('form').submit(function (event) {
        //     event.preventDefault()
        // });
        // $('#permission').on('keyup',function (event) {
        //     event.preventDefault();
        //     const key = event.keyCode || event.which;
        //     if (key === 13 ){
        //         $('.permissions-list').append('<li>' + $(this).val().slice(0,-1) + '</li>');
        //         $(this).val("")
        //     }
        // });
        // $('.submit').click(function (event) {
        //     event.preventDefault();
        //     for(var i = 0; i <= $('i').length; i ++){
        //         console.log($('i').val())
        //     }
        // })
    </script>
@endpush
@endsection
