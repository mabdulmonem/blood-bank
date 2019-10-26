@extends('admin.layouts.index')

@section('content')
    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
    @endpush
    <div class="col-md-12">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ count(\App\Http\Models\DonationRequest::all()) }}</h3>

                        <p> طلبات التبرع</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <a href="{{ admin_url('donation-requests') }}" class="small-box-footer">مزيد من المعلومات <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ count(\App\Http\Models\Post::all()) }}</h3>

                        <p>إجمالى المقالات</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-copy"></i>
                    </div>
                    <a href="{{ admin_url("posts") }}" class="small-box-footer">مزيد من المعلومات <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ count(\App\User::where('email_verified_at','!=',null)->get()) }}</h3>

                        <p>إجمالى العملاء</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ admin_url('clients') }}" class="small-box-footer">مزيد من المعلومات <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ count(\App\Http\Models\Report::all()) }}</h3>

                        <p>إجمالى الشكاوى</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bug"></i>
                    </div>
                    <a href="{{ admin_url('reports') }}" class="small-box-footer">مزيد من المعلومات <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- ./col -->
@endsection
