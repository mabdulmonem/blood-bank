@extends("frontend.layouts.app")

@section('content')
    <!-- Sign Up Start -->
    <section id="sign-up">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <form action="{{ url('register') }}" method="post">
                @csrf
                <input type="text" placeholder="Name" required name="name">
                <input type="email" placeholder="Email" required name="email">
                <input type="date" name="date_of_birth" placeholder="Birth date" id="date_of_birth">
                <select name="blood_type_id" id="type" required="">
                    <option value="Blood Type" disabled>Blood Type</option>

                    @foreach($blood_types as $blood_type)
                        <option value="{{ $blood_type->id }}">{{ ucfirst($blood_type->name) }}</option>
                    @endforeach
                </select>
                <select name="" id="Gov" required="">
                    <option value="Governorate" disabled>Governorates</option>
                    @foreach($governorates as $governorate)
                        <option value="{{ $governorate->id }}">{{ ucfirst($governorate->name) }}</option>
                    @endforeach
                </select>
                <select name="city_id" id="Gov" required="">
                    <option value="Governorate" disabled>Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ ucfirst($city->name) }}</option>
                    @endforeach
                </select>
                <input type="tel" placeholder="Phone Number" required="" name="phone">
                <input type="date" name="last_donation_date" id="last_donation">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="password_confirmation" placeholder="Repeat Password">
                <div class="reg-group">
                    <input class="check" type="checkbox" name="terms" required="" style="height: auto; display:inline; margin: 0 auto;">Agree on terms and conditions<br>
                    <button class="submit" type="submit" style="background-color: rgb(51, 58, 65);">Sing Up</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Sign Up End -->
@endsection
