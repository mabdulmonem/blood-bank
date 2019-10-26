@extends('frontend.layouts.app')

@section('content')
    <!-- Sub Header Start -->
    <section id="sub-header">
        <div class="container">
            <h3>A SINGLE PINT CAN SAVE THREE LIVES, A SINGLE GESTURE CAN CREATE A MILLION SMILES.</h3>
        </div>
    </section>
    <!-- Sub Header End -->

    <!-- Header Start -->
    <section id="header">
        <div class="container">
            <!-- <h1>We are seeking for a better community health.</h1>
            <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora repellat inventore nemo repudiandae
                ipsum quos.</h4>
            <button class="btn more" onclick= "window.location.href = 'About-us.html';">More</button> -->
        </div>
    </section>
    <!-- Header End -->

    <!-- Articles Start -->
    <section id="articles">
        <div class="container">
            <h2 style="display: inline-block;">Articles</h2>
            <div class="swiper-container">
                <div class="button-area" style="display: inline-block; margin-left: 850px;">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="swiper-wrapper">
                    @foreach($posts as $post)
                        <div class="swiper-slide">
                            <div class="card">
                                <div class="card-img-top" style="position: relative;">
                                    <img src="{{ $post->img ? image($post->img,true) : asset('front-end/imgs/p5.jpg') }}" alt="Card image">
                                    <button class="like {{ ($post->clients->first() !== null && $post->clients->first()->id === client()->id())  ? 'post-like' : null }} " data-id="{{ $post->id }}" ><i class="fas fa-heart icon-large" ></i></button>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">{{ $post->title }}</h4>
                                    <p class="card-text">{!! \Illuminate\Support\Str::limit($post->content,150) !!}</p>
                                    <div class="btn-cont">
                                        <a class="card-btn" href="{{ url("article/$post->id") }}">Details</a>
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

    <!-- Requests Start -->
    <section id="requests">
        <div class="title">
            <h2>Donations</h2>
            <hr class="line">
        </div>
        <div class="container">
            <form action="{{ url('donations-requests/sort') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-5">
                        <select name="bloodType_id" id="">
                            <option value="" disabled selected >Select Blood Type</option>
                            @foreach($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}">{{ ucfirst($bloodType->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5">
                        <select name="city_id" id="">
                            <option value="" disabled selected >Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->governorate->id }}">{{ ucfirst($city->governorate->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search">
                        <button type="submit"><i class="col-lg-2 fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            @foreach($donations as $donation)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="type">
                                    <h2>{{ $donation->bloodType->name }}</h2>
                                </div>
                            </div>
                            <div class="data col-lg-6">
                                <h4>Name: {{ $donation->name }}</h4>
                                <h4>Hospital: {{ $donation->hospital_name }}</h4>
                                <h4>City: {{ $donation->city->name }}</h4>
                            </div>
                            <div class="col-lg-3">
                                <a href="{{ url("donation-request/$donation->id") }}" style="display: block">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="more-req">
                <a href="{{ url('donation-requests') }}" style="position: relative;margin-top: 35px;display: inline-block">More</a>
                @if(client()->check() || auth()->check())
                    <a href="{{ url('donation-requests/create') }}" style="position: relative;margin-top: 35px;display: inline-block" class="btn btn-success" >Create Donation Requests</a>
                @endif
            </div>
        </div>
    </section>
    <!-- Requests End -->

    <!-- Call us Start -->
    <section id="call-us">
        <div class="layer">
            <div class="container">
                <h1>Call Us</h1>
                <h4>You can call us for your inquiries about any information.</h4>
                <div class="whats">
                    <img src="{{ asset('front-end/imgs/whats.png') }}" alt="">
                    <h3><a href="telto:{{ settings('whats_app') }}">{{ settings('what_app') ?explode('phone=',settings('whats_app'))[1] : '01008245686' }}</a> </h3>
                </div>
            </div>
        </div>
    </section>
    <!-- Call us End -->

    <!-- App Start -->
    <section id="app">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="info">
                        <h1>Blood Bank Application</h1>
                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae earum officiis et eligendi nam
                            harum corporis saepe deserunt.</h3>
                        <h4>Available On</h4>
                        {!! settings('ios_app_link') ? '<a href="' . settings('ios_app_link') . '"><img src="' . asset('front-end/imgs/ios.png') .'" alt=""></a>' : null !!}
                        {!! settings('android_app_link') ? '<a href="' . settings('android_app_link') . '"><img src="' . asset('front-end/imgs/google.png') .'" alt=""></a>' : null !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="app-screen" src="{{ asset('front-end/imgs/App.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- App End -->
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
