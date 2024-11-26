
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
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Organization Control Center</li>
                <li class="breadcrumb-item active">Create Organization</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Organization Information</h5>

                    <form method="POST" action="{{ route('organization.store_organization') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <!-- Organization Name in English -->
                        <div class="col-md-6">
                            <label for="name_en" class="form-label">Organization Name (English)</label>
                            <input type="text" name="name_en" class="form-control" id="name_en" required>
                        </div>

                        <!-- Organization Name in Arabic -->
                        <div class="col-md-6">
                            <label for="name_ar" class="form-label">Organization Name (Arabic)</label>
                            <input type="text" name="name_ar" class="form-control" id="name_ar" required>
                        </div>

                        <!-- Description in English -->
                        <div class="col-md-6">
                            <label for="description_en" class="form-label">Description (English)</label>
                            <textarea name="description_en" class="form-control" id="description_en"></textarea>
                        </div>

                        <!-- Description in Arabic -->
                        <div class="col-md-6">
                            <label for="description_ar" class="form-label">Description (Arabic)</label>
                            <textarea name="description_ar" class="form-control" id="description_ar"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact_info" class="form-label">Contact Information</label>
                            <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                        </div>
                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <select class="form-select" id="address" name="address" required>
                                <option value="" disabled selected>Select your country</option>
                                @foreach ($countries as $code => $country)
                                    <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Proof Image -->
                        <div class="col-md-6">
                            <label for="proof_image" class="form-label">Proof Image</label>
                            <input type="file" name="proof_image" class="form-control" id="proof_image">
                        </div>

                        <!-- Organization Image -->
                        <div class="col-md-6">
                            <label for="organization_image" class="form-label">Organization Image</label>
                            <input type="file" name="organization_image" class="form-control" id="organization_image">
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create Organization</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript لإضافة الحقول بناءً على اللغة -->

@endsection
