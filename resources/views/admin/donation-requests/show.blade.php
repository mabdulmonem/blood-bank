@extends('admin.layouts.index')

@section('content')

    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">

            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body p-1">
                <div class="col-md-6 float-lg-right">
                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->name }}  <strong class="donation-title"> : اسم المريض</strong></h5>
                    </div>

                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->patient_age }}  <strong class="donation-title"> : عمر المريض</strong></h5>
                    </div>

                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->hospital_name }}  <strong class="donation-title "> : المستشفى</strong></h5>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->bloodType->name }}  <strong class="donation-title"> : فصيلة الدم</strong></h5>
                    </div>
                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->blood_bags_count }}  <strong class="donation-title"> : عدد حقائب الدم</strong></h5>
                    </div>
                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->phone }}  <strong class="donation-title"> : رقم الهاتف</strong></h5>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mailbox-read-info text-right">
                        <h5 >{{ $donation->hospital_address }}  <strong class="donation-title hospital_address"> : عنوان المستشفى</strong></h5>
                    </div>
                </div>
                <div class="col-md-12 donation-details">
                    {{ $donation->details }}
                </div>
                <div class="col-md-12">
                    <div class="map" id="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13648.620397637154!2d29.9420796!3d31.2164321!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8476f62bb5008c82!2sAndalusia%20Smouha%20Hospital!5e0!3m2!1sen!2seg!4v1567936654125!5m2!1sen!2seg"
                            width="1000" height="550" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                {{ Form::open(['route' => ['donation-requests.update',$donation->id], 'method'=>'delete']) }}
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> حذف </button>
                {{ Form::close() }}
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
@endsection
