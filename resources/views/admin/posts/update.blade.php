@extends('admin.layouts.index')

@section('content')
    @push('css')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('admin/css/summernote-bs4.css') }}">
    @endpush

    <!-- /.col -->
    <div class="col-md-12">
        {!! Form::open(['route' => ['posts.update',$post->id], 'method'=>'put','enctype'=> 'multipart/form-data']) !!}

            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" value="{{ old('title') ? old('title') : $post->title  }}" name="title" placeholder="عنوان المقال">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="category_id">
                            <option value=""> اختار تصنيف المقال </option>
                            @foreach($categories as $category)
                                @if($category->id == $post->category_id)
                                    <option value="{{ $post->category_id }}" selected>{{ $post->category['name'] }}</option>
                                @endif
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
                            ],'publish',true) !!}
                        </select>
                    </div>
                    <div class="form-group">
                    <textarea id="post-content" name="content"
                              placeholder="محتوى المقال"  class="form-control" style="min-height: 600px!important;">{{ $post->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <img class="preview-img img" src="{{ get_img($post->img) }}" style="display: block" id="post-img"/>
                        <div class="btn btn-default btn-file">الصورة المصغرة للمقال
                            <i class="fas fa-paperclip"></i>
                            <input type="file" class="upload" name="img">
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary"> حفظ</button>
                    </div>
                    <a href="{{ admin_url('posts') }}" class="btn btn-default float-right"><i class="fas fa-times"></i> إالغاء</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        {!! Form::close() !!}
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
