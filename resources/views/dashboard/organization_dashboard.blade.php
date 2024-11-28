@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Dashboard') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.Dashboard') }} </li>
            </ol>
        </nav>
    </div>

    {{--  <!-- End Page Title -->  --}}

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.NeedsA') }} <span>|
                                        {{ __('messages.Total') }}</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $needs->count() }}</h6>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    {{--  <!-- End needs Card -->  --}}

                    {{--  <!-- Donation Card -->  --}}
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">


                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.Contributors') }} <span>|
                                        {{ __('messages.Total') }}</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalDonatedQuantity }}</h6>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    {{--  <!-- End Donation Card -->  --}}

                    {{--  <!-- doners Card -->  --}}
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">



                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.Doners') }} <span>|
                                        {{ __('messages.Total') }}</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalDonations }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    {{--  <!-- End doners Card -->  --}}





                </div>
            </div><!-- End Left side columns -->



        </div>
    </section>
@endsection
