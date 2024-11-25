```php
@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Donations Control Center</li>
                <li class="breadcrumb-item active">List of Donations</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">List Of Donations</h5>
                        <a href="{{ route('donations.create') }}" class="btn btn-success mb-3">
                            <i class="fa-solid fa-user-plus"></i> Add New Donation
                        </a>
                    </div>

                    <form action="{{ route('donations.index') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by donor name..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                        <a href="{{ route('donations.index') }}" class="btn btn-secondary ms-2">Reset</a>
                    </form>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Need Name</th>
                                <th scope="col">Donor</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Date Donated</th>
                                <th scope="col" class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donations as $donation)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $donation->need->needDetail->first()?->item_name ?? 'N/A' }}</td>
                                    <td>{{ $donation->user->userDetail->first()?->name ?? 'Anonymous' }}</td>
                                    <td>{{ $donation->quantity }}</td>
                                    <td>{{ $donation->created_at ? $donation->created_at->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="actions">
                                        <a href="{{ route('donations.show', $donation->id) }}" class="fa-solid fa-eye"></a>
                                        <a href="{{ route('donations.edit', $donation->id) }}" class="fa-solid fa-pencil"></a>
                                        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this donation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:none; border:none; color:#007bff; cursor:pointer;">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
```
