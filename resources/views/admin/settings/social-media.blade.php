@extends('admin.layouts.index')

@section('content')
    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ admin_url('setting/social-media') }}" method="post">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="fb">رابط صفحة الفيس بوك</label>
                        <input class="form-control" name="fb" value="{{ old('fb') ? old('fb') : settings('fb') }}"
                               placeholder="رابط صفحة الفيس بوك" id="fb" type="url">
                    </div>
                    <div class="form-group">
                        <label for="in">رابط صفحة الانستغرام</label>
                        <input class="form-control" name="in" value="{{ old('in') ? old('in') : settings('in') }}"
                               placeholder="instgram" id="in" type="url">
                    </div>
                    <div class="form-group">
                        <label for="in">رابط صفحة التويتر</label>
                        <input class="form-control" name="tw" value="{{ old('tw') ? old('tw') : settings('tw') }}"
                               placeholder="صفحة التويتر" id="tw" type="url">
                    </div>
                    <div class="form-group">
                        <label for="in">رابط صفحة اليوتيوب</label>
                        <input class="form-control" name="youtube" value="{{ old('youtube') ? old('youtube') : settings('youtube') }}"
                               placeholder="صفحة اليوتيوب" id="youtube" type="url">
                    </div>
                    <div class="form-group">
                        <label for="in">رابط صفحة الواتس اب</label>
                        <input class="form-control" name="whats_app" value="{{ old('whats_app') ? old('whats_app') : settings('whats_app') }}"
                               placeholder="الواتس اب" id="whats_app">
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> حفظ</button>
                    </div>
                    <a href="{{ admin_url('') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </form>
    </div>
    <!-- /.col -->
@endsection
