@extends('admin.layouts.index')

@section('content')
    @push('css')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('admin/css/summernote-bs4.css') }}">
    @endpush

    <!-- /.col -->
    <div class="col-md-12">
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" name="title" value="{{ old('title') }}" placeholder="عنوان المقال">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="category_id">
                            <option value=""> اختار تصنيف المقال </option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" >
                        <select name="status" class="form-control">
                            {!! list_options([
                                'default' => 'اختار حالة المقال',
                                'publish' => 'نشر',
                                'draft' => 'انتظار المراجعة'
                              ],old('status'),true) !!}
                        </select>
                    </div>
                    <div class="form-group">
                    <textarea id="post-content" name="content"
                              placeholder="محتوى المقال"   class="form-control" style="min-height: 600px!important;">{{ old('content') }}</textarea>
                    </div>
                    <div class="form-group">
                        <img class="preview-img img" id="post-img" alt=""/>
                        <div class="btn btn-default btn-file">الصورة المصغرة للمقال
                             <i class="fas fa-paperclip"></i>
                            <input type="file" value="{{ old('img') }}" class="upload" name="img">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> إنشاء</button>
                    </div>
                    <a href="{{ admin_url('posts') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
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
                $('#post-content').summernote()
            })
        </script>
    @endpush
@endsection
