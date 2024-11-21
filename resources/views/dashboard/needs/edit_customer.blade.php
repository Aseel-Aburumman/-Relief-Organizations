@extends('layouts.admin_master')

@section('content')


    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item ">User Control Center</li>
          <li class="breadcrumb-item ">List of Customers</li>
          <li class="breadcrumb-item active">Customer info edit</li>
        </ol>
      </nav>
    </div>

    {{--  <!-- End Page Title -->  --}}

    <section class="section dashboard">
      <div class="row">


<div class="card">
    <div class="card-body">
        <h5 class="card-title">Update Customer Information</h5>

        <!-- Update Customer Information Form -->
        <form class="row g-3" method="POST" action="{{ route('admin.update_customer', $customer->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-md-12">
                <label for="inputName" class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name', $customer->name) }}">
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail" value="{{ old('email', $customer->email) }}">
            </div>
            <div class="col-md-6">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Leave blank to keep current password">
            </div>

                        <div class="col-md-12">
                <label for="inputImage" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="inputImage" name="image">
                @if($customer->image)
                    <img src="{{ url('/user_images/' . $customer->image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="150">
                @endif
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" name="location" class="form-control" id="inputAddress" value="{{ old('location', $deliveryInfo->location ?? '') }}" placeholder="1234 Main St">
            </div>
            <div class="col-12">
                <label for="inputBuilding" class="form-label">Building No</label>
                <input type="text" name="building_no" class="form-control" id="inputBuilding" value="{{ old('building_no', $deliveryInfo->building_no ?? '') }}" placeholder="Apartment, studio, or floor">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" name="city" class="form-control" id="inputCity" value="{{ old('city', $deliveryInfo->city ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" id="inputPhone" value="{{ old('phone', $deliveryInfo->phone ?? '') }}">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Update Customer Information Form -->
    </div>
</div>


      </div>
    </section>



  @endsection
