@extends('admin.layouts.index')

@section('content')
    <!-- /.col -->
    <div class="col-md-12">
        {!! Form::open(['route' => ['cities.update',$city->id], 'method'=>'put']) !!}

            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="city">اسم المدينة</label>
                        <input class="form-control" value="{{ old('name') ? old('name') : $city->name  }}"
                               name="name" placeholder="اسم المينة" id="city">
                    </div>
                    <div class="form-group">
                        <label for="governorate">المحافظة</label>
                        <select class="form-control" id="governorate" name="governorate_id">
                            @foreach($governorates as $governorate)
                                @if($governorate->id == old('governorate_id'))
                                    <option value="{{ $governorate->id }}" selected>{{ $governorate->name }}</option>
                                @endif
                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                    <a href="{{ admin_url('cities') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        {!! Form::close() !!}
    </div>
    <!-- /.col -->
@endsection
