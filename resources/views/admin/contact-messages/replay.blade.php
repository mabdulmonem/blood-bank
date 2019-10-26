@extends('admin.layouts.index')

@section('content')
    @push('css')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('admin/css/summernote-bs4.css') }}">
    @endpush

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ admin_url("replay/mail") }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <input type="hidden" value="{{ $mail->id }}" name="receiver">
                    <div class="form-group">
                        <label for="subejct">عنوان الموضوع</label>
                        <input class="form-control" name="subject" value="{{ old('subject') }}" placeholder="عنوان الموضوع الرد" id="subejct">
                    </div>

                    <div class="form-group">
                        <label for="message">محتوى الموضوع</label>
                        <textarea id="message" name="message" placeholder="محتوى الرد"
                                  class="form-control" style="min-height: 600px!important;">{{ old('message') }}</textarea>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary">إرسال</button>
                    </div>
                    <a href="{{ admin_url("contact-messages/$mail->id") }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
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
        <!-- Page Script -->
        <script>
            $(function () {
                //Add text editor
                $('#message').summernote()
            })
        </script>
    @endpush
@endsection
