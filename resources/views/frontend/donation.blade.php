@extends("frontend.layouts.app")

@section('content')
    <!-- donator Start -->
    <section id="donator">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $donation->name }}</td>
                        </tr>
                        <tr>
                            <th>Age:</th>
                            <td>{{ $donation->patient_age }}</td>
                        </tr>
                        <tr>
                            <th>Hospital:</th>
                            <td>{{ $donation->hospital_name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Blood Type:</th>
                            <td>{{ $donation->bloodType->name }}</td>
                        </tr>
                        <tr>
                            <th>Number of Required Blood Bags:</th>
                            <td>{{ $donation->blood_bags_count }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td><a href="telto:{{ $donation->phone }}">{{ $donation->phone }}</a> </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>Hospital Address:</th>
                            <td>{{ $donation->hospital_address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="details-container">
                <p>{{ $donation->details }}
                </p>
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13648.620397637154!2d29.9420796!3d31.2164321!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8476f62bb5008c82!2sAndalusia%20Smouha%20Hospital!5e0!3m2!1sen!2seg!4v1567936654125!5m2!1sen!2seg"
                width="1000" height="550" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
        </div>
    </section>
    <!-- Who End -->
@endsection
