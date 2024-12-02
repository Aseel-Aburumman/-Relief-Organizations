@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.OrganizationControlCenter') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.OrganizationControlCenter') }}</li>
                <li class="breadcrumb-item active">{{ __('messages.ListOrganizations') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">{{ __('messages.ListOrganizations') }}</h5>
                        <div>
                            <a href="{{ route('organization.create_organization') }}" class="btn btn-success mb-3">
                                <i class="fa-solid fa-user-plus"></i> {{ __('messages.AddNewOrganization') }}
                            </a>
                            <button class="btn btn-primary mb-3" onclick="printOrganizations()">
                                <i class="fa-solid fa-print"></i> {{ __('messages.Print') }}
                            </button>
                        </div>
                    </div>

                    <table class="table table-hover" id="organizations-table">
                        <thead>
                            <tr>
                                <th class="tableHide" scope="col">#</th>
                                <th scope="col">{{ __('messages.OrganizationNameA') }}</th>
                                <th scope="col">{{ __('messages.ContactInformation') }}</th>
                                <th scope="col">{{ __('messages.Image') }}</th>
                                <th scope="col">{{ __('messages.Description') }}</th>
                                <th scope="col">{{ __('messages.AddressA') }}</th>
                                <th class="tableHide" scope="col">{{ __('messages.DateCreated') }}</th>
                                <th scope="col" class="actions">{{ __('messages.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organizations as $organization)
                                <tr>
                                    <th class="tableHide" scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $organization->userDetail->first()->name ?? 'N/A' }}</td>
                                    <td>{{ $organization->contact_info ?? 'N/A' }}</td>
                                    <td>
                                        @if ($organization->image)
                                            <img src="{{ asset('storage/organization_images/' . $organization->image->first()->image) }}"
                                                alt="{{ $organization->userDetail->first()->name }}"
                                                style="width: 50px; height: 50px; border-radius: 5px;">
                                        @else
                                            <span>{{ __('messages.NoImage') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($organization->userDetail->first()->description ?? 'N/A', 30) }}
                                    </td>
                                    <td>{{ $organization->userDetail->first()->address ?? 'N/A' }}</td>
                                    <td class="tableHide">{{ $organization->created_at->format('Y-m-d') }}</td>
                                    <td class="actions">
                                        <a href="{{ route('organization.profile.one', ['id' => $organization->id]) }}"
                                            class="btn btn-info btn-sm">{{ __('messages.View') }}</a>
                                        <a href="{{ route('organization.edit_organization', ['id' => $organization->id]) }}"
                                            class="btn btn-warning btn-sm">{{ __('messages.Edit') }}</a>
                                        <form
                                            action="{{ route('organization.delete_organization', ['id' => $organization->id]) }}"
                                            method="POST" style="display:inline;"
                                            onsubmit="return confirm('{{ __('messages.suredeleteorganization') }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                {{ __('messages.Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        function printOrganizations() {
                            const tableContent = document.getElementById('organizations-table').outerHTML;
                            const printWindow = window.open('', '_blank', 'height=600,width=800');

                            printWindow.document.write(`
                                <!DOCTYPE html>
                                <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Print</title>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            margin: 20px;
                                            background-color: white;
                                        }
                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                        }
                                        table, th, td {
                                            border: 1px solid black;
                                        }
                                        th, td {
                                            padding: 10px;
                                            text-align: left;
                                        }
                                        img {
                                            display: block !important;
                                            max-width: 50px;
                                            height: auto;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h1>{{ __('messages.ListOrganizations') }}</h1>
                                    ${tableContent}
                                </body>
                                </html>
                            `);

                            printWindow.document.close();

                            printWindow.onload = () => {
                                printWindow.focus();
                                printWindow.print();
                                printWindow.close();
                            };
                        }
                    </script>
@endsection
