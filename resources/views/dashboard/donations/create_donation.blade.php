@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Create New Donation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orgnization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Donation Control Center</li>
                <li class="breadcrumb-item active">Create Donation</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Donation Information</h5>

                    <form class="row g-3" method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="donor_id" class="form-label">Donor</label>
                            <select name="donor_id" class="form-control" id="donor_id">
                                <option value="">Select a donor</option>
                                @foreach ($donors as $donor)
                                    @foreach ($donor->userDetail as $detail)
                                        <option value="{{ $donor->id }}">
                                            {{ $detail->name ?? $donor->email ?? 'Anonymous' }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="need_id" class="form-label">Need</label>
                            <select name="need_id" class="form-control" id="need_id">
                                <option value="">Select a need</option>
                                @foreach ($needs as $need)
                                    <option value="{{ $need->id }}">{{ $need->needDetail->first()?->item_name ?? 'Unnamed Need' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="quantity"
                                value="{{ old('quantity') }}">
                        </div>

                       

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create Donation</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
