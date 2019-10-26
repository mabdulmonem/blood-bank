<!DOCTYPE html>
<html lang="{{ client_lang() }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- Site icon -->
    <link rel="icon" href="{{ image(settings('icon'),true) }}" type="image/x-icon" />
    <!-- website font  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('front-end/css/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/animate.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/style.css') }}" />

    <title>{{ $title ? $title . ' | ' . settings('site_name'): settings('site_name') }}</title>
</head>

<body>

<!-- Navbar 1 Start -->
<section id="Nav1">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="telto:"> <i class="fas fa-phone-volume" style="border-right: 1px solid gray;"> {{ settings('phone') }}
                            &nbsp; &nbsp; </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="mailto:"><i class="far fa-envelope" style="padding-left: 15px;"> {{ settings('email')  }}</i></a>
                    </li>
                </ul>
            </div>
            <div class="mx-auto order-0 navbar-brand mx-auto">
                {!! settings('in') ? '<a href="' . settings('in') . '"><i class="fab fa-instagram github">&nbsp;&nbsp;</i></a>' : null !!}
                {!! settings('fb') ? '<a href="' . settings('fb') . '"><i class="fab fa-facebook-f facebook">&nbsp</i></a>': null !!}
                {!! settings('tw')? '<a href="' . settings('tw') .'"><i class="fab fa-twitter twitter">&nbsp;&nbsp;</i></a>' : null !!}
                {!! settings('whats_app') ? '<a href="' . settings('whats_app') . '"><i class="fab fa-whatsapp whats">&nbsp;&nbsp;</i></a>' : null !!}
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ client_lang('en') ? 'selected' : null }}" style="border-right: 1px solid gray;" href="{{ url('/lang/en') }}">EN &nbsp;</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ client_lang('ar') ? 'selected' : null }}" style="padding-left: 15px;" href="{{ url('/lang/ar') }}">AR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>
<!-- Navbar 1 End -->

<!-- Navbar 2 Start -->
<section id="Nav2">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img src="{{ image(settings('logo'),true) }}" width="18%"/>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ get_home_menu_class_active() }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ get_menu_class_active('about-us') }}" href="{{ url('about-us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ get_menu_class_active('articles') }}" href="{{ url('articles') }}">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ get_menu_class_active('donation-requests') }}" href="{{ url('donation-requests') }}">Donations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ get_menu_class_active('contact-us') }}" href="{{ url('contact-us') }}">Contact Us</a>
                </li>
            </ul>
            @if(auth()->check())
                <a href="{{ admin_url('') }}" title="Edit Profile" class="btn login" target="_blank"><i class="fas fa-tachometer-alt"></i>  Control Panel</a>
                <a href="{{ admin_url('users/' . auth()->id().'/edit') }}" title="Edit Profile" class="btn login" target="_blank"><i class="fas fa-user"></i> {{ auth()->user()->username }}</a>
                <button title="Logout" class="btn signup" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="fas fa-sign-out-alt"></i> Logout</button>
                <form action="{{ route('logout') }}" id="logout-form" method="post">
                    @csrf
                </form>
            @else
                @if(!client()->check())
                    <a class="btn signup" href="{{ url('/register') }}">New Account</a>
                    <a class="btn login" href="{{ url('/login') }}">Login</a>
                @else
                    <a href="{{ url('/profile/'.client()->id()) }}" title="Edit Profile" class="btn login"><i class="fas fa-user"></i> {{ client()->user()->name }}</a>
                    <button title="Logout" class="btn signup" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="fas fa-sign-out-alt"></i> Logout</button>

                    <form action="{{ route('logout') }}" id="logout-form" method="post">
                        @csrf
                    </form>
                @endif
            @endif


        </div>
    </nav>
</section>
<!-- Navbar 2 End -->

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! get_frontend_breadcrumb($title) !!}

    @yield('content')

<!-- Footer Start -->
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="foot-info">
                    <img src="{{ image(settings('logo'),true) }}" alt="">
                    <p>{{ \Illuminate\Support\Str::limit(settings('description'),192) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="menu">
                    <a href="{{ url('/') }}">
                        <li>Home</li>
                    </a>
                    <a href="{{ url('about-us') }}">
                        <li>About Us</li>
                    </a>
                    <a href="#articles">
                        <li>Articles</li>
                    </a>
                    <a href="{{ url('donation-requests') }}">
                        <li>Donations</li>
                    </a>
                    <a href="{{ url('contact-us') }}">
                        <li>Contact Us</li>
                    </a>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="options">
                    <li>
                        <h5>Available On</h5>
                    </li>
                    {!! settings('ios_app_link') ? '<li><a href=' . settings('ios_app_link') . '><img src="' . asset('front-end/imgs/ios1.png') . '" alt=""></a> </li>': null  !!}
                    {!! settings('android_app_link') ? '<li><a href=' . settings('android_app_link') . '><img src="' . asset('front-end/imgs/google1.png') . '" alt=""></a> </li>': null  !!}
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Footer End -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script type="text/javascript" src="{{ asset('front-end/js/swiper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front-end/js/wow.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@stack('js')
<script type="text/javascript" src="{{ asset('front-end/js/main.js') }}"></script>
</body>

</html>
