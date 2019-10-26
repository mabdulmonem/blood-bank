@extends('frontend.layouts.app')

@section('content')
    <!-- login Start -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6 call">
                    <div class="title">Head</div>
                    <img src="{{ asset(settings('logo'),true) }}" alt="">
                    <hr>
                    <h3>Mobile: <a href="telto:{{ settings('phone') }}">{{ settings('phone') }}</a> </h3>
                    <h3>Fax: +2 455 6646</h3>
                    <h3>Email: <a href="mailto:{{settings('email')}}">{{ settings('email') }}</a> </h3>
                    <hr>
                    <h3>Find Us On</h3>
                    <div class="icons">
                        {!! settings('fb') ? '<a href='.settings('fb').'><i class="fab fa-facebook-square fa-3x"></i></a>' : null !!}
                        {!! settings('tw') ? '<a href='.settings('twitter').'><i class="fab fa-twitter-square fa-3x"></i></a>' : null !!}
                        {!! settings('whats_app') ? '<a href='.settings('whats_app').'><i class="fab fa-whatsapp-square fa-3x"></i></a>' : null !!}
                        {!! settings('youtube') ? '<a href='.settings('youtube').'><i class="fab fa-youtube-square fa-3x"></i></a>' : null !!}
                    </div>
                </div>
                <div class="col-md-6 info">
                    <div class="title">Head</div>
                    <form action="{{ url('contact-us') }}" method="post">
                        @csrf
                        <input type="text" name="name" id="" placeholder="Name" required="">
                        <input type="email" name="email" id="" placeholder="Email" required="">
                        <input type="tel" name="phone" id="" placeholder="Phone" required="" min="11">
                        <input type="text" name="subject" id="" placeholder="Title" required="">
                        <textarea name="message" id="" cols="10" rows="5" placeholder="Message"></textarea>
                        <div class="reg-group">
                            <button type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- login End -->
@endsection
