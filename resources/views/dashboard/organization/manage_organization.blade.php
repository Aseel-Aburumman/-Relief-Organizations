@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Organization Control Center</li>
                <li class="breadcrumb-item active">List of Organizations</li>
            </ol>
        </nav>
    </div>
    {{--  <!-- End Page Title -->  --}}

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">List Of Organizations</h5>
                        <a href="{{ route('organization.create_organization') }}" class="btn btn-success mb-3">
                            <i class="fa-solid fa-user-plus"></i> Add New Organization
                        </a>
                    </div>

                    {{-- <form action="{{ route('organization.manage_organizations') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                        <a href="{{ route('organization.manage_organizations') }}" class="btn btn-secondary ms-2">Reset</a>
                    </form> --}}
                    <!-- Table with hoverable rows -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="tableHide" scope="col">#</th>
                                <th scope="col">Organization Name</th>
                                <th scope="col">Contact Info</th>
                                <th scope="col">Description</th>
                                <th scope="col">Location</th>
                                <th class="tableHide" scope="col">Date Created</th>
                                <th scope="col" class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organizations as $organization)
                                <tr>
                                    <th class="tableHide" scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $organization->userDetail->first()->name ?? 'N/A' }}</td>
                                    <td>{{ $organization->contact_info ?? 'N/A' }}</td>
                                    <td>{{ $organization->userDetail->first()->description ?? 'N/A' }}</td>
                                    <td>{{ $organization->userDetail->first()->location ?? 'N/A' }}</td>
                                    <td class="tableHide">{{ $organization->created_at->format('Y-m-d') }}</td>
                                    <td class="actions">
                                        <a href="{{ route('organization.profile.one', ['id' => $organization->id]) }}"
                                            class="fa-solid fa-eye"></a>
                                        <a href="{{ route('organization.edit_organization', ['id' => $organization->id]) }}"
                                            class="fa-solid fa-pencil"></a>
                                            <form action="{{ route('organization.delete_organization', ['id' => $organization->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="background:none; border:none; color:#007bff; cursor:pointer;">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with hoverable rows -->
                </div>
            </div>
        </div>
    </section>
@endsection
