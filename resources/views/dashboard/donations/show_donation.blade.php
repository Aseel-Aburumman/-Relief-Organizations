@extends('layout.admin_master')

@section('content')
<div class="pagetitle">
    <h1>Donation Details</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orgnization.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('donations.index') }}">Donations</a></li>
            <li class="breadcrumb-item active">Donation Details</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Donation Details</h5>

                <table class="table">
                    <tr>
                        <th>Need Name</th>
                        <td>{{ $donation->need->needDetail->first()?->item_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Donor Name</th>
                        <td>{{ $donation->user->userDetail->first()?->name ?? 'Anonymous' }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $donation->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Date Donated</th>
                        <td>{{ $donation->created_at ? $donation->created_at->format('Y-m-d') : 'N/A' }}</td>
                    </tr>
                  
                </table>

                <a href="{{ route('donations.index') }}" class="btn btn-secondary mt-3">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
