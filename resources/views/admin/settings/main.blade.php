@extends('admin.layouts.index')

@section('content')
    @push('css')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('admin/css/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-tagsinput.css') }}">
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
    @endpush

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ admin_url('settings') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <label for="site_name">اسم الموقع</label>
                        <input class="form-control" name="site_name" value="{{ old('site_name') ? old('site_name') : settings('site_name') }}"
                               placeholder="اسم الموقع" id="site_name">
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الموقع</label>
                        <input class="form-control" name="email" value="{{ old('email') ? old('email') : settings('email') }}"
                               placeholder="البريد الموقع" id="email" type="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الجوال</label>
                        <input class="form-control" name="phone" value="{{ old('phone') ? old('phone') : settings('phone') }}"
                               placeholder="رقم الجوال" id="phone" type="tel" minlength="11" >
                    </div>
                    <div class="form-group">
                        <label for="ios_app_link">رابط تطبيق ios</label>
                        <input class="form-control" name="ios_app_link" value="{{ old('ios_app_link') ? old('ios_app_link') : settings('ios_app_link') }}"
                               placeholder="رابط تطبيق ios" id="ios_app_link" type="text" minlength="11" >
                    </div>
                    <div class="form-group">
                        <label for="android_app_link">رابط تطبيق Android</label>
                        <input class="form-control" name="android_app_link" value="{{ old('android_app_link') ? old('android_app_link') : settings('android_app_link') }}"
                               placeholder="رابط تطبيق Android" id="android_app_link" type="text" minlength="11" >
                    </div>
                    <div class="form-group">
                        <label for="paginate">عدد السجلات فى الفحة الواحدة</label>
                        <input class="form-control" name="paginate" value="{{ old('paginate') ? old('paginate') : settings('paginate') }}"
                               placeholder="عدد السجلات فى الفحة الواحدة" id="paginate" type="number">
                    </div>
                    <div class="form-group">
                        <label for="notification_settings_text">نص الإشعار</label>
                        <input class="form-control" name="notification_settings_text"
                               value="{{ old('notification_settings_text') ? old('notification_settings_text') : settings('notification_settings_text') }}"
                               placeholder="نص الإشعار" id="notification_settings_text" >
                    </div>
                    <div class="form-group">
                        <label for="description">وصف الموقع</label>
                        <textarea class="form-control" name="description" placeholder="وصف الموقع"
                                  id="description">{{ old('description') ? old('description') : settings('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="keywords">الكلمات الدلالية</label>
                        <input class="form-control" name="keywords" value="{{ old('keywords') ? old('keywords') : settings('keywords') }}"
                               placeholder="الكلمات الدلالية" id="keywords" data-role="tagsinput">
                    </div>
                    <div class="col-md-12" style="display: flex; flex-wrap: wrap">
                        <div class="col-md-6">
                            <div class="form-group">
                                <img src="{{ image(settings('logo'),true) }}" class="preview-img img" alt="" id="logo" {{ settings('logo') ? 'style=display:block' : null }} />
                                <div class="btn btn-default btn-file">شعار الموقع
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" value="{{ old('content') }}" class="upload" name="logo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <img src="{{ image(settings('icon'),true) }}" class="preview-img img" alt="" id="icon" {{ settings('icon') ? 'style=display:block' : null }} />
                                <div class="btn btn-default btn-file">رمز الموقع
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" value="{{ old('content') }}" class="upload" name="icon">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">حالة الموقع</label>
                        <input class="form-control" name="status" id="status" type="checkbox"
                               {{ settings('status') == 'open' ? "checked value=open " : "unchecked value=close" }}
                               data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                               data-on="الموقع مفتوح" data-off="الموقع مغلق">
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

    @push('js')
        <!-- Summernote -->
        <script src="{{ asset('admin/js/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('admin/js/bootstrap-tagsinput.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
        <!-- Page Script -->
        <script>
            $(function () {
                //Add text editor
                $('#post-content').summernote()
            })
        </script>
    @endpush
@endsection
