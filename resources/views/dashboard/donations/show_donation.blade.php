@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.DonationDetails') }}
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}
                    </a></li>
                <li class="breadcrumb-item"><a href="{{ route('donations.index') }}">{{ __('messages.Donations') }}
                    </a></li>
                <li class="breadcrumb-item active">{{ __('messages.DonationDetails') }}
                </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.DonationDetails') }} </h5>

                    <table class="table">
                        <tr>
                            <th>{{ __('messages.NeedName') }}
                            </th>
                            <td>{{ $donation->need->needDetail->first()?->item_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.Description') }}
                            </th>
                            <td>{{ $donation->need->needDetail->first()?->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.QuantityNeeded') }}
                            </th>
                            <td>{{ $donation->need->first()?->quantity_needed ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.UrgencyLevel') }}
                            </th>
                            <td>{{ $donation->need->first()?->urgency ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.Status') }}
                            </th>
                            <td>{{ $donation->need->first()?->status ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.DonorName') }}
                            </th>
                            <td>{{ $donation->user->userDetail->first()?->name ?? 'Anonymous' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.Quantity') }}
                            </th>
                            <td>{{ $donation->quantity }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.DateDonated') }}
                            </th>
                            <td>{{ $donation->created_at ? $donation->created_at->format('Y-m-d') : 'N/A' }}</td>
                        </tr>

                    </table>

                    <a href="{{ route('donations.index') }}" class="btn btn-secondary mt-3">{{ __('messages.BackList') }}
                        Back to List</a>
                </div>
            </div>
        </div>
    </section>
@endsection
