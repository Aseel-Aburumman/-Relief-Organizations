@extends('layout.admin_master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="pagetitle">
        <h1>Create New Organization</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Home') }} </a></li>
                <li class="breadcrumb-item">{{ __('messages.OrganizationControlCenter') }}</li>
                <li class="breadcrumb-item active">{{ __('messages.CreateOrganization') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.NewOrganizationInformation') }}</h5>

                    <form method="POST" action="{{ route('organization.store_organization') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Row 1: Email and Password -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">{{ __('messages.EmailA') }}</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">{{ __('messages.PasswordA') }}</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                        </div>

                        <!-- Row 2: Organization Names -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name_en" class="form-label">{{ __('messages.OrganizationNameA') }} (English)</label>
                                <input type="text" name="name_en" class="form-control" id="name_en" required>
                            </div>
                            <div class="col-md-6">
                                <label for="name_ar" class="form-label">{{ __('messages.OrganizationNameA') }} (Arabic)</label>
                                <input type="text" name="name_ar" class="form-control" id="name_ar" required>
                            </div>
                        </div>

                        <!-- Row 3: Descriptions -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description_en" class="form-label">{{ __('messages.Description') }} (English)</label>
                                <textarea name="description_en" class="form-control" id="description_en"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="description_ar" class="form-label">{{ __('messages.Description') }} (Arabic)</label>
                                <textarea name="description_ar" class="form-control" id="description_ar"></textarea>
                            </div>
                        </div>

                        <!-- Row 4: Contact Information and Address -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contact_info" class="form-label">{{ __('messages.ContactInformation') }}</label>
                                <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">{{ __('messages.AddressA') }}</label>
                                <select class="form-select" id="address" name="address" required>
                                    <option value="" disabled selected>{{ __('messages.Selectcountry') }}</option>
                                    @foreach ($countries as $code => $country)
                                        <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 5: Proof Document and Organization Image -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="proof_image" class="form-label">{{ __('messages.ProofDocument') }}</label>
                                <input type="file" name="proof_image" class="form-control" id="proof_image">
                            </div>
                            <div class="col-md-6">
                                <label for="organization_image" class="form-label">{{ __('messages.OrganizationImage') }}</label>
                                <input type="file" name="organization_image" class="form-control" id="organization_image">
                            </div>
                        </div>
<br><br>
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.CreateOrganization') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
