@extends('layout.master')

@section('content')
    <style>
        body {
            background-color: #f7f7f7;
        }

        .signup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-card {
            width: 800px;
            height: auto;
            display: flex;
            background-color: #ffffff;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .signup-card .form-section {
            flex: 1;
            padding: 2rem;
        }

        .signup-card .image-section {
            flex: 1;
            background: url('/img/auth/signup.jpg') no-repeat center center;
            background-size: cover;
        }

        .signup-title {
            font-size: 1.8rem;
            color: #3CC78F;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-select {
            padding: 5px 20px;
            border-radius: 50px;
            border-color: #dedede;
        }

        .signInBtn {
            border-radius: 50px;

        }

        .social-icons a:hover {
            background-color: #ff4d4f;
            color: #ffffff;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 50px;
            padding: 10px 20px;
        }

        .btn-primary {
            background-color: #3CC78F;
            border-color: #3CC78F;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #ff6666;
            border-color: #ff6666;
        }

        .terms {
            font-size: 0.9rem;
            color: #666;
        }

        .terms a {
            color: #3CC78F;
        }
    </style>




    <div class="mt-5 signup-container">
        <div class="signup-card">
            <div class="form-section">
                <h2 class="signup-title">{{ __('messages.CreateAccountA') }}</h2>

                <p class="text-center mb-3">
                    <a href="{{ route('register.view.Organization') }}"
                        style="color: #3CC78F;">{{ __('messages.SignOrganizayionA') }}</a>
                </p>

                @if (isset($success))
                    <div class="alert alert-success">
                        {{ $success }}
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

                <!-- Sign-Up Form -->
                <form action="{{ route('register.donor') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('messages.NameA') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.EmailA') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="emailA" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('messages.PasswordA') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('messages.AddressA') }}</label>
                        <select class="form-select @error('address') is-invalid @enderror" id="address" name="address"
                            required>
                            <option value="" disabled selected>{{ __('messages.Selectcountry') }}</option>
                            @foreach ($countries as $code => $country)
                                <option value="{{ $country['name'] }}"
                                    {{ old('address') == $country['name'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">{{ __('messages.SignUpA') }}</button>
                    <p class="text-center">
                        {{ __('messages.AlreadyaccountA') }}
                        <a href="{{ route('login.view') }}" style="color: #3CC78F;">{{ __('messages.SignInA') }}</a>
                    </p>
                </form>
            </div>
            <div class="image-section"></div>
        </div>
    </div>

@endsection
