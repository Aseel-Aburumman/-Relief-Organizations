<!-- resources/views/organization/pending.blade.php -->

@extends('layout.admin_master')

@section('content')
    <div class="container">
        <h1>{{ __('messages.PendingOrganizations') }}</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('messages.NameA') }}</th>
                    <th>{{ __('messages.Status') }}</th>
                    <th>{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($organizations as $organization)
                    <tr>
                        <td> {{ $organization->userDetail->first()->name ?? 'n' }}
                        </td>
                        <td>{{ $organization->status }}</td>
                        <td>
                            <form action="{{ route('organization.updateStatus', $organization->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="status" value="approved"
                                    class="btn btn-success">{{ __('messages.Approve') }}</button>
                                <button type="submit" name="status" value="rejected"
                                    class="btn btn-danger">{{ __('messages.Reject') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
