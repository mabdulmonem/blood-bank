@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ admin_url("permission/$per->id/edit") }}" method="post">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">عنوان الصحلاحية</label>

                        <input class="form-control" name="name" value="{{ old('name') ? old('name') : $per->name }}" placeholder="عنوان الصحلاحية" id="name">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> حفظ</button>
                    </div>
                    <a href="{{ admin_url('permissions') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> رجوع </a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </form>
    </div>
    <!-- /.col -->

@endsection
