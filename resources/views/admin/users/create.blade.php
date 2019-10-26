@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" name="name" value="{{ old('name') }}" placeholder="إسم العمل">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="username" value="{{ old('username')  }}" placeholder="إسم المستخدم">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="phone" value="{{ old('phone') }}" placeholder="رقم الهاتف المحمول" type="tel">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="email" value="{{ old('email') }}" placeholder="البريد الالكترونى" type="email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="password" value="{{ old('password') }}" placeholder="كلمة المرور" type="password">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="password_confirmation" value="{{ old('password') }}" placeholder="إعادة إدخال كلمة المرور" type="password">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="blood_type_id">
                            <option value="">إختار فصيلة الدم</option>
                            @foreach($blood_types as $blood_type)
                                <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="governorate_id">
                            <option value="">إختر المحافظة</option>
                            @foreach($governorates as $governorate)
                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="city_id">
                            <option value="">إختار المدينة</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @role('admins')
                    <div class="form-group">
                        <select class="form-control role_name" name="role_name">
                            <option value="" selected disabled>إختار دور المشرف</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" >{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endrole
                    <div class="form-group">
                        <img class="preview-img img" id="user-img"/>
                        <div class="btn btn-default btn-file">الصورة المصغرة للمقال
                            <i class="fas fa-paperclip"></i>
                            <input type="file" value="{{ old('picture') }}" class="upload" name="picture">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> إنشاء</button>
                    </div>
                    <a href="{{ admin_url('users') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </form>
    </div>
    <!-- /.col -->
@push('js')
    <script>
        $('.role_name').change(function () {
            $('.permissions .permissions_list .per-check-name').remove();
            $.ajax({
                url:"{{ admin_url('role/permissions') }}",
                type: 'post',
                data: {_token:"{{ csrf_token() }}", _method:'post',id:$(this).val()},
                dataType:'json',
                success:function (result) {
                    if(result.status === 1){
                        for (var i =0; i <= result.data.length;i++)
                            $('.permissions .permissions_list')
                                .append('<label class="per-check-name"><input type="checkbox" value="' + result.data[i].name + '" name="permissions[]" >' + result.data[i].name + '</label>')
                                .parent().show()
                    }else{
                        alert(result.msg)
                    }
                },
                error:function (result,xhr) {

                }

            })
        })
    </script>
@endpush
@endsection
