@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.EditDonation') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.DonationCenter') }} </li>
                <li class="breadcrumb-item active">{{ __('messages.EditDonation') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.EditDonationInformation') }} </h5>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3" method="POST" action="{{ route('donations.update', $donation->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <label for="donor_id" class="form-label">{{ __('messages.Donor') }}</label>
                            <select name="donor_id" class="form-control" id="donor_id">
                                <option value="">{{ __('messages.Selectdonor') }}</option>
                                @foreach ($donors as $donor)
                                    <option value="{{ $donor->id }}"
                                        {{ $donor->id == $donation->donor_id ? 'selected' : '' }}>
                                        {{ $donor->userDetail->first()?->name ?? ($donor->email ?? 'Anonymous') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="need_id" class="form-label">{{ __('messages.Need') }}</label>
                            <select name="need_id" class="form-control" id="need_id">
                                <option value="">{{ __('messages.Selectneed') }} </option>
                                @foreach ($needs as $need)
                                    <option value="{{ $need->id }}"
                                        {{ $need->id == $donation->need_id ? 'selected' : '' }}>
                                        {{ $need->needDetail->first()?->item_name ?? 'Unnamed Need' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label">{{ __('messages.Quantity') }}</label>
                            <input type="number" name="quantity" class="form-control" id="quantity"
                                value="{{ old('quantity', $donation->quantity) }}">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.UpdateDonation') }}</button>
                            <button type="reset" class="btn btn-secondary">{{ __('messages.Reset') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
