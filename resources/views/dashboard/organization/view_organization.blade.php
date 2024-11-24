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

            <div class="col-lg-12">
                <div class="card w-100">
                    <div class="card-body profile-card pt-4">

                        <div class="row w-100">
                            <!-- Profile Image Column -->
                            <div class="col-lg-4 d-flex justify-content-center align-items-center">
                                <img src="{{ $organization->image ? url('/storage/orgnization_images/' . $organization->image) : url('assets/img/default-image.png') }}"
                                    alt="Profile" class="rounded-circle" width="150">
                            </div>

                            <!-- Profile Information Column -->
                            <div class="col-lg-8">
                                <h2>{{ $organization->userDetail->first()->name ?? 'No Name Available' }}</h2>

                                <div class="tab-content pt-2">
                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <h5 class="card-title">Organization Details</h5>

                                        <div class="row mb-2">
                                            <div class="col-lg-4 col-md-4 label">Organization Name</div>
                                            <div class="col-lg-8 col-md-8">{{ $organization->userDetail->first()->name ?? 'Not provided' }}</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-lg-4 col-md-4 label">Contact Info</div>
                                            <div class="col-lg-8 col-md-8">{{ $organization->contact_info ?? 'Not provided' }}</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-lg-4 col-md-4 label">Description</div>
                                            <div class="col-lg-8 col-md-8">{{ $organization->userDetail->first()->description ?? 'Not provided' }}</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-lg-4 col-md-4 label">Location</div>
                                            <div class="col-lg-8 col-md-8">{{ $organization->userDetail->first()->location ?? 'Not provided' }}</div>
                                        </div>

                                        <!-- Stylish Button for Chat Center, Edit, and Delete -->
                                        <div class="row mt-4">
                                            <div class="col-lg-12 text-center">
                                                <!-- Go to Chat Center Button -->
                                                <a href="{{ route('chatadmin2', ['receiverId' => $organization->id]) }}"
                                                    class="btn btn-primary btn-lg">
                                                    <i class="bi bi-chat-dots"></i> Go to Chat Center
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.edit_organization', ['id' => $organization->id]) }}"
                                                    class="btn btn-primary btn-lg">
                                                    <i class="fa-solid fa-pencil"></i> Edit
                                                </a>

                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('admin.delete_organization', ['id' => $organization->id]) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- End Stylish Button -->


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-6">
                <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                        <h5 class="card-title">Donation History <span>| Recent</span></h5>

                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Value</th>
                                    <th scope="col">Donation Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($organization->donations as $donation)
                                    <tr>
                                        <th scope="row"><a href="#">#{{ $loop->iteration }}</a></th>
                                        <td><a href="#" class="text-primary">{{ $donation->item->name }}</a></td>
                                        <td>{{ $donation->quantity }}</td>
                                        <td>${{ $donation->total_value }}</td>
                                        <td>{{ \Carbon\Carbon::parse($donation->donation_date)->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
            <div class="col-6">
                <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                        <h5 class="card-title">Activities <span>| Recent</span></h5>

                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($organization->activities as $activity)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $activity->title }}</td>
                                        <td>{{ $activity->location }}</td>
                                        <td>{{ $activity->duration }} hours</td>
                                        <td>{{ $activity->status->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>

    </section>
@endsection
