@extends("frontend.layouts.app")

@section('content')
    <!-- Login Start -->
    <section id="login">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <form action="{{ url('login') }}" method="post">
                @csrf
                <input class="username" type="tel" placeholder="Phone" required name="phone">
                <input class="password" type="Password" placeholder="Password" required name="password">
                <input class="check" type="checkbox" name="remember">Remember me
                <a href="{{ url('password/rest') }}" style="color: inherit">Forget Password ?</a><br>
                <div class="reg-group">
                    <button style="background-color: darkred;" type="submit">Login</button>
                    <a style="background-color: rgb(51, 58, 65);    padding: 20px 50px;" href="{{ url('register') }}">Make new account</a>
                </div>
            </form>
        </div>
    </section>
    <!-- Login End -->
@endsection
