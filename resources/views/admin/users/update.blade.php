@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        {!! Form::open(['route' => ['users.update',$user->id], 'method'=>'put', "enctype"=>"multipart/form-data"]) !!}
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">إسم العمل</label>
                        <input class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" placeholder="إسم العمل" id="name">
                    </div>
                    <div class="form-group">
                        <label for="username">إسم المستخدم</label>
                        <input class="form-control" name="username" value="{{ old('username') ? old('username') : $user->username  }}" placeholder="إسم المستخدم" id="username">
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الهاتف المحمول</label>
                        <input class="form-control" name="phone" value="{{ old('phone') ? old('phone') : $user->phone }}" placeholder="رقم الهاتف المحمول" type="tel" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الالكترونى</label>
                        <input class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" placeholder="البريد الالكترونى" type="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="pass">كلمة المرور</label>
                        <input class="form-control" name="password" value="{{ old('password') }}" placeholder="كلمة المرور" type="password" id="pass">
                    </div>
                    <div class="form-group">
                        <label for="re-pass">إعادة إدخال كلمة المرور</label>
                        <input class="form-control" name="password_confirmation" value="{{ old('password') }}" placeholder="إعادة إدخال كلمة المرور" type="password" id="re-pass">
                    </div>
                    <div class="form-group">
                        <label for="blood">إختار فصيلة الدم</label>
                        <select class="form-control" name="blood_type_id" id="blood">
                            @if($user->blood_type_id)
                                <option value="{{ $user->blood_type_id }}" selected>{{$user->bloodType->name  }}</option>
                            @endif
                            @foreach($blood_types as $blood_type)
                                <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gover">إختر المحافظة</label>
                        <select class="form-control governorate" name="governorate_id" id="gover">
                            @if($user->city_id)
                                <option selected disabled>{{$user->city->governorate->name  }}</option>
                            @endif
                            @foreach($governorates as $governorate)
                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group cities">
                        <label for="city">إختار المدينة</label>
                        <select class="form-control" name="city_id" id="city">
                            @if($user->city_id)
                                <option value="{{ $user->city_id }}" selected>{{$user->city->name  }}</option>
                            @endif
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                   @role('admins')
                    <div class="form-group">
                        <label for="role_name">إختار دور المشرف</label>
                        <select class="form-control role_name" name="role_name" id="role_name">
                            <option value="" selected disabled>{{ ucfirst(get_role_name($user)) }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" >{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    @endrole
                    <div class="form-group">
                        <img class="preview-img img" id="user-img" src="{{ $user->picture ? image($user->picture,true) : null }}"  {!! $user->picture ? 'style="display: block"' : null !!}  alt=""/>
                        <div class="btn btn-default btn-file"> اختر صورة شخصية
                            <i class="fas fa-paperclip"></i>
                            <input type="file" value="{{ old('picture') }}" class="upload" name="picture">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> حفظ</button>
                    </div>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        {!! Form::close() !!}
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
            });
            $('.governorate').change(function () {
                $.ajax({
                    url:"{{ admin_url('governorate/cities') }}",
                    type: 'post',
                    data: {_token:"{{ csrf_token() }}", _method:'post',id:$(this).val()},
                    dataType:'json',
                    success:function (result) {
                        console.log(result.data)
                        if(result.status === 1){
                            for (var i =0; i <= result.data.length;i++)
                                $('.cities select')
                                    .append("<option value='" + result.data[i].id + "'>" + result.data[i].name + " </option>")
                                    .parent().show()
                        }
                    },
                    error:function (result,xhr) {

                    }

                })
            })
        </script>
    @endpush

@endsection
