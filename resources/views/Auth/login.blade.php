@extends('layout.master')
@section('content')
    <style>
        body {
            background-color: #eafaf1;
        }

        .header_signin {
            background-color: #3CC78F;
        }

        .btn-primary {
            background-color: #3CC78F;
            border-color: #3CC78F;
        }

        .btn-primary:hover {
            background-color: #3CC78F;
            border-color: #3CC78F;
        }
    </style>

    <div class="container" style="margin-top:135px">
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
        <div class="card mt-5">
            <div class="header_signin card-header text-center text-white">
                <h2>Sign In</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('register.view') }}" style="color: #3CC78F;">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
