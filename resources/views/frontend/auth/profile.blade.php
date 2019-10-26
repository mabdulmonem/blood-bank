@extends("frontend.layouts.app")

@section('content')
    <!-- Sign Up Start -->
    <section id="sign-up">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <form action="{{ url('/profile/save/'.client()->id()) }}" method="post">
                @csrf
                <input type="text" placeholder="Name" required name="name" value="{{ old('name')?old('name') : client()->user()->name }}">
                <input type="email" placeholder="Email" required name="email" value="{{ old('email')?old('email') : client()->user()->email }}">
                <input type="date" name="date_of_birth" placeholder="Birth date" id="date_of_birth" value="{{ old('date_of_birth')?old('date_of_birth') : client()->user()->date_of_birth }}">
                <select name="blood_type_id" id="type" required="">
                    <option value="Blood Type" disabled>Blood Type</option>
                    <option value="{{ client()->user()->blood_type_id }}" selected>{{ \App\Http\Models\BloodType::find(client()->user()->blood_type_id)->name }}</option>
                    @foreach($blood_types as $blood_type)
                        <option value="{{ $blood_type->id }}">{{ ucfirst($blood_type->name) }}</option>
                    @endforeach
                </select>
                <select name="" id="Gov" required="">
                    <option value="Governorate" disabled>Governorate</option>
                    <option  selected>{{ \App\Http\Models\City::find(client()->user()->city_id)->governorate->name }}</option>
                    @foreach($cities as $governorate)
                        <option value="{{ $governorate->id }}">{{ ucfirst($governorate->governorate->name) }}</option>
                    @endforeach
                </select>
                <select name="city_id" id="Gov" required="">
                    <option value="Governorate" disabled>Governorate</option>
                    <option value="{{ client()->user()->city_id }}" selected>{{ \App\Http\Models\City::find(client()->user()->city_id)->name }}</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ ucfirst($city->name) }}</option>
                    @endforeach
                </select>
                <input type="tel" placeholder="Phone Number" required="" name="phone" value="{{ old('phone')?old('phone') : client()->user()->phone }}">
                <input type="date" name="last_donation_date" id="last_donation" value="{{ old('last_donation_date')?old('last_donation_date') : client()->user()->last_donation_date }}">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="password_confirmation" placeholder="Repeat Password">
                <div class="reg-group">
                    <button class="submit" type="submit" style="background-color: rgb(51, 58, 65);">Sing Up</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Sign Up End -->
@endsection
