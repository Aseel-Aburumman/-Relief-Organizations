@extends('layout.master')
@section('content')
    <style>
        body {
            background-color: #eafaf1;
        }

        .header_signup {
            background-color: #3CC78F;

        }

        .btn-primary {
            background-color: #3CC78F;
            /* Theme green */
            border-color: #3CC78F;
        }

        .btn-primary:hover {
            background-color: #3CC78F;
            border-color: #3CC78F;
        }

        .nav-tabs .nav-link.active {
            background-color: #3CC78F;
            color: #fff;
        }
    </style>

    <div class="container " style="margin-top:135px">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card mt-5">
            <div class="header_signup card-header text-center text-white ">
                <h2>Sign Up</h2>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="signupTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('register.view') }}" class="nav-link btn">
                            Sign Up as Doner
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="organization-tab" data-bs-toggle="tab"
                            data-bs-target="#organization" type="button" role="tab" aria-controls="organization"
                            aria-selected="false">
                            Sign Up as Organization
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="signupTabsContent">
                    <!-- Donor Signup Form -->
                    {{--  <div class="tab-pane fade show active" id="donor" role="tabpanel" aria-labelledby="donor-tab">
                        <form action="{{ route('register.donor') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <div class="mb-3">
                                <label for="name_en" class="form-label">Name (English)</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" required>
                            </div>
                            <div class="mb-3">
                                <label for="name_ar" class="form-label">Name (Arabic)</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                            </div>
                            <div class="mb-3">
                                <label for="location_en" class="form-label">Location (English)</label>
                                <input type="text" class="form-control" id="location_en" name="location_en" required>
                            </div>
                            <div class="mb-3">
                                <label for="location_ar" class="form-label">Location (Arabic)</label>
                                <input type="text" class="form-control" id="location_ar" name="location_ar" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </form>
                    </div>  --}}

                    <!-- Organization Signup Form -->
                    <div class="tab-pane fade show active" id="organization" role="tabpanel"
                        aria-labelledby="organization-tab">
                        <form action="{{ route('register.organization') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <div class="mb-3">
                                <label for="name_en" class="form-label">Organization Name (English)</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" required>
                            </div>
                            <div class="mb-3">
                                <label for="name_ar" class="form-label">Organization Name (Arabic)</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                            </div>
                            <div class="mb-3">
                                <label for="location_en" class="form-label">Location (English)</label>
                                <input type="text" class="form-control" id="location_en" name="location_en" required>
                            </div>
                            <div class="mb-3">
                                <label for="location_ar" class="form-label">Location (Arabic)</label>
                                <input type="text" class="form-control" id="location_ar" name="location_ar" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact_info" class="form-label">Contact Information</label>
                                <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                            </div>
                            <div class="mb-3">
                                <label for="description_en" class="form-label">Description (English)</label>
                                <textarea class="form-control" id="description_en" name="description_en" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="description_ar" class="form-label">Description (Arabic)</label>
                                <textarea class="form-control" id="description_ar" name="description_ar" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="{{ route('login.view') }}" style="color: #3CC78F;">Sign
                                    In</a></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
