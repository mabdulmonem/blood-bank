@extends("frontend.layouts.app")

@section('content')
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

            @forelse($donations as $donation)

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
                                <a href="{{ url("donation-request/$donation->id") }}" class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <hl>Sorry, Donations Requests Is Empty</hl>
            @endforelse


            <div class="page-num">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{ $donations->render() }}
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!-- Requests End -->
@endsection
