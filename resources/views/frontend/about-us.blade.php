@extends('frontend.layouts.app')

@section('content')


    <!-- Who Start -->
    <section id="who">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <p>
                {{ settings('description') }}
            </p>
        </div>
    </section>
    <!-- Who End -->

@endsection
