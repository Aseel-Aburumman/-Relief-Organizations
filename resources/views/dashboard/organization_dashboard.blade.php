@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Dashboard') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.Dashboard') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-12">
                <div class="row">

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.NeedsA') }} <span>| {{ __('messages.Total') }}</span></h5>
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

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.Contributors') }} <span>| {{ __('messages.Total') }}</span></h5>
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

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.Doners') }} <span>| {{ __('messages.Total') }}</span></h5>
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

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.NeedsVsDonated') }}</h5>
                        <canvas id="needsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.DonationTrends') }}</h5>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.UnfulfilledNeeds') }}</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.NeedID') }}</th>
                                    <th>{{ __('messages.Category') }}</th>
                                    <th>{{ __('messages.QuantityNeeded') }}</th>
                                    <th>{{ __('messages.DonatedQuantity') }}</th>
                                    <th>{{ __('messages.Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($needs as $need)
                                    @if($need->status == 'Available')
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $need->id }}</td>
                                            <td>{{ $need->category->name }}</td>
                                            <td>{{ $need->quantity_needed }}</td>
                                            <td>{{ $need->donated_quantity }}</td>
                                            <td>{{ $need->status }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <script>
                const ctx = document.getElementById('needsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($needNames),
                        datasets: [
                            {
                                label: "{{ __('messages.QuantityNeeded') }}", // ترجمة "Quantity Needed"
                                data: @json($needsData),
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: "{{ __('messages.DonatedQuantity') }}", // ترجمة "Donated Quantity"
                                data: @json($donatedData),
                                backgroundColor: 'rgba(60, 199, 143, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
        // //Trends in Donations
        // const lineCtx = document.getElementById('lineChart').getContext('2d');
        // new Chart(lineCtx, {
        //     type: 'line',
        //     data: {
        //         labels: ['January', 'February', 'March', 'April'],
        //         datasets: [{
        //             label: 'Total Donations',
        //             data: [100, 200, 150, 300],
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             backgroundColor: 'rgba(60, 199, 143, 0.2)',
        //             fill: true,
        //             tension: 0.4
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         scales: {
        //             x: {
        //                 beginAtZero: true
        //             },
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
        const dates = @json($dates);
    const donationsByDate = @json($donationsByDate);

    // Trends in Donations (Line Chart)
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: "{{ __('messages.TotalDonations') }}", // ترجمة "Total Donations"
                data: donationsByDate,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(60, 199, 143, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: "{{ __('messages.TrendsInDonations') }}" // ترجمة "Trends in Donations Over Time"
                }
            },
            scales: {
                x: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: "{{ __('messages.Dates') }}" // ترجمة "Dates"
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "{{ __('messages.Donations') }}" // ترجمة "Donations"
                    }
                }
            }
        }
    });
    </script>
@endsection
