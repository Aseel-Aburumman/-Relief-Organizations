@extends('layouts.admin_master')

@section('content')

<div class="pagetitle">
    <h1>Create New Customer</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item ">User Control Center</li>
            <li class="breadcrumb-item active">Create Customer</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">New Customer Information</h5>

                <form class="row g-3" method="POST" action="{{ route('admin.store_customer') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="inputName" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name') }}">
                    </div>
                    <div class="col-md-12">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPasswordConfirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation">
                    </div>


                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Customer</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
