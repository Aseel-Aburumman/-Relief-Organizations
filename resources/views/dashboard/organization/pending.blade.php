<!-- resources/views/organization/pending.blade.php -->

@extends('layout.admin_master')

@section('content')
<div class="container">
    <h1>Pending Organizations</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organizations as $organization)
            <tr>
                <td>        {{ $organization->userDetail->first()->name ?? "n" }}
                </td>
                <td>{{ $organization->status }}</td>
                <td>
                    <form action="{{ route('organization.updateStatus', $organization->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="status" value="approved" class="btn btn-success">Approve</button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
