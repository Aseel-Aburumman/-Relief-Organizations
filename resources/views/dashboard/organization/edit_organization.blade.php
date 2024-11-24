@extends('layouts.admin_master')

@section('content')


    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item ">Organization Control Center</li>
          <li class="breadcrumb-item ">List of Organizations</li>
          <li class="breadcrumb-item active">Organization Info Edit</li>
        </ol>
      </nav>
    </div>

    {{--  <!-- End Page Title -->  --}}

    <section class="section dashboard">
      <div class="row">


<div class="card">
    <div class="card-body">
        <h5 class="card-title">Update Organization Information</h5>

        <!-- Update Organization Information Form -->
        <form class="row g-3" method="POST" action="{{ route('orgnization.update_organization', $organization->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-md-12">
                <label for="inputName" class="form-label">Organization Name</label>
                <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name', $organization->userDetail->first()->name ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Contact Info</label>
                <input type="text" name="contact_info" class="form-control" id="inputEmail" value="{{ old('contact_info', $organization->contact_info) }}">
            </div>

            <div class="col-md-12">
                <label for="inputImage" class="form-label">Organization Image</label>
                <input type="file" class="form-control" id="inputImage" name="image">
                @if($organization->image->isNotEmpty())
                    <img src="{{ url('/storage/orgnization_images/' . $organization->image->first()->image) }}" alt="Organization Image" class="img-thumbnail mt-2" width="150">
                @endif
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" name="location" class="form-control" id="inputAddress" value="{{ old('location', $organization->userDetail->first()->location ?? '') }}" placeholder="1234 Main St">
            </div>
            <div class="col-md-12">
                <label for="inputDescription" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="inputDescription" rows="4" placeholder="Enter description">{{ old('description', $organization->userDetail->first()->description ?? '') }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Update Organization Information Form -->
    </div>
</div>


      </div>
    </section>



@endsection
