@extends('layout.master')

@section('content')
    <style>
        body {
            background-color: #f7f7f7;
        }

        .signin-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signin-card {
            width: 800px;
            height: auto;
            display: flex;
            background-color: #ffffff;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .signin-card .form-section {
            flex: 1;
            padding: 2rem;
        }

        .signin-card .image-section {
            flex: 1;
            background: url('/img/auth/signup.jpg') no-repeat center center;
            background-size: cover;
        }

        .signin-title {
            font-size: 1.8rem;
            color: #3CC78F;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
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

        .text-center a {
            color: #3CC78F;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="signin-container">
        <div class="signin-card">
            <div class="form-section">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h2 class="signin-title">{{ __('messages.SignInA') }}
                </h2>

                <!-- Sign-In Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.EmailA') }}
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('messages.PasswordA') }}
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('messages.SignInA') }}
                    </button>
                </form>
                <div class="text-center mt-3">
                    <p>{{ __('messages.DonaccountA') }}
                        <a href="{{ route('register.view') }}">{{ __('messages.SignUpA') }}
                        </a>
                    </p>
                </div>
            </div>
            <div class="image-section"></div>
        </div>
    </div>
@endsection
