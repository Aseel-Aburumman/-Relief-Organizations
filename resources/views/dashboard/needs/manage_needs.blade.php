@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orgnization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Needs Control Center</li>
                <li class="breadcrumb-item active">List of Needs</li>
            </ol>
        </nav>
    </div>
    {{--  <!-- End Page Title -->  --}}

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">List Of Needs</h5>
                        <a href="{{ route('orgnization.create_Need') }}" class="btn btn-success mb-3">
                            <i class="fa-solid fa-user-plus"></i> Add New Need
                        </a>
                    </div>

                    <form action="{{ route('orgnization.manage_Needs') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                        <a href="{{ route('orgnization.manage_Needs') }}" class="btn btn-secondary ms-2">Reset</a>
                    </form>
                    <!-- Table with hoverable rows -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="tableHide" scope="col">#</th>
                                <th scope="col">Need Name</th>
                                <th class="tableHide2" scope="col">Category</th>
                                <th scope="col">Quantity Needed</th>
                                <th scope="col">Donated Needed</th>

                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th class="tableHide" scope="col">Date Created</th>
                                <th scope="col" class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($needs as $need)
                                <tr>
                                    <th class="tableHide" scope="row">{{ $loop->iteration }}</th>
                                    <td> {{ $need->needDetail->first()?->item_name ?? 'N/A' }}
                                    </td>
                                    <td class="tableHide2">{{ $need->category->name ?? 'N/A' }}</td>
                                    <td>{{ $need->quantity_needed }}</td>
                                    <td>{{ $need->donated_quantity }}</td>

                                    <td> {{ $need->needDetail->first()?->description ?? 'N/A' }}
                                    </td>
                                    <td>{{ $need->status }}</td>
                                    <td class="tableHide">{{ $need->created_at->format('Y-m-d') }}</td>
                                    <td class="actions">
                                        <a href="{{ route('donation.show', ['id' => $need->id]) }}"
                                            class="fa-solid fa-eye"></a>
                                        @role('orgnization')
                                            <a href="{{ route('organization.edit_need', ['id' => $need->id]) }}"
                                                class="fa-solid fa-pencil"></a>
                                            <form action="{{ route('organization.delete_need', ['id' => $need->id]) }}"
                                                method="POST" style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this need?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:none; border:none; color:#007bff; cursor:pointer;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endrole

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
