@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        {!! Form::open(['route' => ['permissions.update',$role->id], 'method'=>'put']) !!}
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">عنوان الصحلاحية</label>

                        <input class="form-control" name="name" value="{{ old('name') ? old('name') : ucfirst($role->name) }}" placeholder="عنوان الصحلاحية" id="name">
                    </div>
                    <div class="form-group">
                        <label for="permission">الصلاحيات</label>
                        @foreach($role->permissions as $permission)
                            <label class="per-check-name"><input type="checkbox" checked value="{{ $permission->id }}" name="permissions[]" >{{ trim($permission->name , ' ') }}</label>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> حفظ</button>
                    </div>
                    <a href="{{ admin_url('permissions') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        {!! Form::close() !!}
    </div>
    <!-- /.col -->

@endsection
