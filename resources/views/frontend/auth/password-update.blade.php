@extends("frontend.layouts.app")

@section('content')
    <!-- Login Start -->
    <section id="login">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <form action="{{ url('password/update') }}" method="post">
                @csrf
                <input class="username" type="email" value="{{ $client->email }}" placeholder="Email" required name="email">
                <input class="password" type="password" placeholder="Password" required name="password">
                <input class="password" type="password" placeholder="rePassword" required name="password_confirmation">
                <div class="reg-group">
                    <button style="background-color: darkred;" type="submit">Change Password</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Login End -->
@endsection
