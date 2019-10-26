@extends("frontend.layouts.app")

@section('content')
    <!-- Login Start -->
    <section id="login">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <form action="{{ url('/password/rest') }}" method="post">
                @csrf
                <input class="username" type="text" placeholder="Enter phone or email" required name="user">
                <div class="reg-group">
                    <button style="background-color: darkred;" type="submit">Send Rest Link</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Login End -->
@endsection
