@extends("frontend.layouts.app")

@section('content')
    <!-- Sign Up Start -->
    <section id="sign-up">
        <div class="container">
            <img src="{{ image(settings('logo'),true) }}" alt="">
            <form action="{{ url('/donation-requests/create') }}" method="post">
                @csrf
                <input type="text" placeholder="Name" required name="name" value="{{ old('name') }}">
                <input type="text" placeholder="Hospital Name" required name="hospital_name" value="{{ old('hospital_name') }}">
                <input type="text" placeholder="Hospital Address" required name="hospital_address" value="{{ old('hospital_address') }}">
                <input type="number" name="patient_age" placeholder="Patient Age" id="patient_age" value="{{ old('patient_age') }}">
                <select name="blood_type_id" id="type" required="">
                    <option value="Blood Type" disabled>Blood Type</option>
                    {{ old('blood_type_id') ? '<option value="' . old('blood_type_id') . '" disabled selected>' . \App\Http\Models\BloodType::find(old('blood_type_id'))->name . '</option>' : null}}
                    @foreach($blood_types as $blood_type)
                        <option value="{{ $blood_type->id }}">{{ ucfirst($blood_type->name) }}</option>
                    @endforeach
                </select>
                <select name="governorate_id" id="Gov" required="">
                    <option value="Governorate" disabled>Governorate</option>
                    {{ old('governorate_id') ? '<option value="' . old('governorate_id') . '" disabled selected>' . \App\Http\Models\Governorate::find(old('governorate_id'))->name . '</option>' : null}}
                    @foreach($cities as $governorate)
                        <option value="{{ $governorate->id }}">{{ ucfirst($governorate->governorate->name) }}</option>
                    @endforeach
                </select>
                <select name="city_id" id="Gov" required="">
                    <option value="Governorate" disabled>Governorate</option>
                    {{ old('city_id') ? '<option value="' . old('city_id') . '" disabled selected>' . \App\Http\Models\Governorate::find(old('city_id'))->name . '</option>' : null}}
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ ucfirst($city->name) }}</option>
                    @endforeach
                </select>
                <input type="tel" placeholder="Phone Number" required="" name="phone" value="{{ old('phone') }}">
                <input type="number" name="blood_bags_count" id="blood_bags_count" placeholder="Blood Bags Count" value="{{ old('blood_bags_count') }}">
                <textarea name="details" class="form-control" placeholder="Details" style="min-height: 200px">{{old('details')}}</textarea>
                <div class="reg-group">
                    <button class="submit" type="submit" style="background-color: rgb(51, 58, 65);">Create</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Sign Up End -->
@endsection
