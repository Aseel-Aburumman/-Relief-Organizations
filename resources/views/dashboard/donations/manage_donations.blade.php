@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Dashboard') }}
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}
                    </a></li>
                <li class="breadcrumb-item">{{ __('messages.DonationCenter') }}
                </li>
                <li class="breadcrumb-item active">{{ __('messages.ListDonations') }}
                </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">{{ __('messages.ListDonations') }}
                        </h5>
                        <a href="{{ route('donations.create') }}" class="btn btn-success mb-3">
                            <i class="fa-solid fa-user-plus"></i> {{ __('messages.AddDonation') }}

                        </a>
                    </div>

                    <form action="{{ route('donations.index') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ __('messages.Searchbyname') }}..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">{{ __('messages.Search') }}</button>
                        <a href="{{ route('donations.index') }}"
                            class="btn btn-secondary ms-2">{{ __('messages.Reset') }}</a>
                        </a>
                    </form>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('messages.NeedName') }}
                                </th>
                                <th scope="col">{{ __('messages.Donor') }}
                                </th>
                                <th scope="col">{{ __('messages.Quantity') }}
                                </th>
                                <th scope="col">{{ __('messages.DateDonated') }}
                                </th>
                                <th scope="col" class="actions">{{ __('messages.Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donations as $donation)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $donation->need->needDetail->first()?->item_name ?? 'N/A' }}</td>
                                    <td>{{ $donation->user->userDetail->first()?->name ?? 'Anonymous' }}</td>
                                    <td>{{ $donation->quantity }}</td>
                                    <td>{{ $donation->created_at ? $donation->created_at->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="actions">
                                        <a href="{{ route('donations.show', $donation->id) }}"
                                            class="btn btn-info btn-sm">{{ __('messages.View') }}</a>
                                        <a href="{{ route('donations.edit', $donation->id) }}"
                                            class="btn btn-warning btn-sm">{{ __('messages.Edit') }}</a>
                                        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('{{ __('messages.suredeletedonation') }}
?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                {{ __('messages.Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
```
