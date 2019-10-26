@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" name="name" value="{{ old('name') }}" placeholder="اسم التصنيف">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> إنشاء</button>
                    </div>
                    <a href="{{ admin_url('categories') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </form>
    </div>
    <!-- /.col -->

@endsection
