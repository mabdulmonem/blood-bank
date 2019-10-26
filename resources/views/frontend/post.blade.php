@extends("frontend.layouts.app")

@section('content')
    <!-- article Start -->
    <section id="article">
        <div class="container">
            <img class="head-img" src="{{ $post->img ? image($post->img,true) : asset('front-end/imgs/p4.jpg') }}" alt="">
            <div class="details-container">
                <div class="title">{{ $post->title }}</div>
                <p>{!! $post->content !!}
                </p>
                <strong><a>Share this article:</a></strong>
                <div class="icons">
                    <i class="fab fa-facebook-square fa-3x"></i>
                    <i class="fab fa-google-plus-square fa-3x"></i>
                    <i class="fab fa-twitter-square fa-3x"></i>
                </div>

            </div>
            <!-- Articles Start -->
            <section id="articles">
                <div class="container">
                    <h2 style="display: inline-block;">Articles</h2>
                    <div class="swiper-container">
                        <div class="button-area" style="display: inline-block; margin-left: 850px;">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            </button>
                        </div>
                        <div class="swiper-wrapper">
                            @foreach($posts as $post)
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="card-img-top" style="position: relative;">
                                            <img src="{{ $post->img ? image($post->img,true) : asset('front-end/imgs/p3.jpg') }}" alt="Card image">
                                            <button class="like"><i class="fas fa-heart icon-large"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title">Blood Types</h4>
                                            <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content,150) }}</p>
                                            <div class="btn-cont">
                                                <a href="{{ url("article/$post->id") }}">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <!-- Articles End -->

        </div>
    </section>
    <!-- Article End -->
    @push('js')
        <script>
            $(".like").click(function () {
                $.ajax({
                    url: "{{ url('/save-post') }}",
                    method: 'post',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        post_id: $(this).data('id')
                    },
                    success: function (result) {
                        console.log(result);
                        if(result.status === 1)
                            $(this).addClass('post-like');
                        else if (result.status === 0)
                            alert(result.msg);
                        else if(result.status === 5000)
                            alert(result.msg)
                    },
                    error: function (error) {
                        console.log(error)
                    }
                })
            })
        </script>
    @endpush
@endsection
