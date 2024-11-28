@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.AdminDashboard') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.Dashboard') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">


            <div class="col-xxl-4 col-md-6">
                <div class="card info-card users-card">

                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.Users') }} <span>| {{ __('messages.Total') }}</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalUsers }}</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Users Card -->

            <!-- Organizations Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card organizations-card">

                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.Organizations') }} <span>| {{ __('messages.Total') }}</span>
                        </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalOrganizations }}</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Organizations Card -->

            <!-- Posts Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card posts-card">

                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.PostsA') }} <span>| {{ __('messages.Total') }} </span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalPosts }}</h6>
                            </div>
                        </div>


                    </div>

                </div>

            </div>
            <!-- End Posts Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card posts-card">

                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.FullyDonatedNeeds') }} <span>| {{ __('messages.Total') }}
                            </span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $fullyDonatedNeedsCount }}</h6>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
    </section>
@endsection