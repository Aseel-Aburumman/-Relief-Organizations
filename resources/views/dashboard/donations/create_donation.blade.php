@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.CreateNewDonation') }} </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.DonationCenter') }}</li>
                <li class="breadcrumb-item active">{{ __('messages.CreateDonation') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.NewDonation') }}</h5>

                    <form class="row g-3" method="POST" action="{{ route('donations.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="donor_id" class="form-label">{{ __('messages.Donor') }}</label>
                            <select name="donor_id" class="form-control" id="donor_id">
                                <option value="">{{ __('messages.Selectdonor') }}</option>
                                @foreach ($donors as $donor)
                                    @foreach ($donor->userDetail as $detail)
                                        <option value="{{ $donor->id }}">
                                            {{ $detail->name ?? ($donor->email ?? 'Anonymous') }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="need_id" class="form-label">{{ __('messages.Need') }}</label>
                            <select name="need_id" class="form-control" id="need_id">
                                <option value="">{{ __('messages.Selectneed') }} </option>
                                @foreach ($needs as $need)
                                    <option value="{{ $need->id }}">
                                        {{ $need->needDetail->first()?->item_name ?? 'Unnamed Need' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label">{{ __('messages.Quantity') }}</label>
                            <input type="number" name="quantity" class="form-control" id="quantity"
                                value="{{ old('quantity') }}">
                        </div>



                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.CreateDonation') }} </button>
                            <button type="reset" class="btn btn-secondary">{{ __('messages.Reset') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
