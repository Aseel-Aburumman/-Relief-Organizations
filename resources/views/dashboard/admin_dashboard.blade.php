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
        <!-- Cards -->
        <div class="col-lg-3 col-md-6">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.Users') }}</h5>
                    <h6>{{ $totalUsers }}</h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.Organizations') }}</h5>
                    <h6>{{ $totalOrganizations }}</h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.Posts') }}</h5>
                    <h6>{{ $totalPosts }}</h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.FullyDonatedNeeds') }}</h5>
                    <h6>{{ $fullyDonatedNeedsCount }}</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Layout -->
    <div class="row">
        <!-- Large Chart -->
        <div class="col-lg-6">
            <div class="card" style="height: 350px;">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.WeeklyUsers') }}</h5>
                    <canvas id="weeklyUsersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Two Small Charts -->
        <div class="col-lg-3">
            <div class="card" style="height: 350px;">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.NeedsStatus') }}</h5>
                    <canvas id="needsStatusChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card" style="height: 350px;">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.OrganizationsStatus') }}</h5>
                    <canvas id="organizationsStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Weekly Users Chart (Large)
    const weeklyUsersCtx = document.getElementById('weeklyUsersChart').getContext('2d');
    new Chart(weeklyUsersCtx, {
        type: 'line',
        data: {
            labels: @json($weeklyUsers->pluck('week')),
            datasets: [{
                label: '{{ __("messages.UsersPerWeek") }}',
                data: @json($weeklyUsers->pluck('count')),
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        }
    });

    // Needs Status Chart (Small)
    const needsStatusCtx = document.getElementById('needsStatusChart').getContext('2d');
    new Chart(needsStatusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($needsStatus->pluck('status')),
            datasets: [{
                data: @json($needsStatus->pluck('count')),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        }
    });

    // Organizations Status Chart (Small)
    const organizationsStatusCtx = document.getElementById('organizationsStatusChart').getContext('2d');
    new Chart(organizationsStatusCtx, {
        type: 'pie',
        data: {
            labels: @json($organizationsStatus->pluck('status')),
            datasets: [{
                data: @json($organizationsStatus->pluck('count')),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        }
    });
</script>
@endsection
