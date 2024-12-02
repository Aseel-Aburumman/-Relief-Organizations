{{-- @extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Dashboard') }}
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}
                    </a></li>
                <li class="breadcrumb-item">{{ __('messages.DonationCenter') }}
                </li>
                <li class="breadcrumb-item active">{{ __('messages.ListDonations') }}
                </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">{{ __('messages.ListDonations') }}
                        </h5>
                        <a href="{{ route('donations.create') }}" class="btn btn-success mb-3">
                            <i class="fa-solid fa-user-plus"></i> {{ __('messages.AddDonation') }}

                        </a>
                    </div>

                    <form action="{{ route('donations.index') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ __('messages.Searchbyname') }}..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">{{ __('messages.Search') }}</button>
                        <a href="{{ route('donations.index') }}"
                            class="btn btn-secondary ms-2">{{ __('messages.Reset') }}</a>
                        </a>
                    </form>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('messages.NeedName') }}
                                </th>
                                <th scope="col">{{ __('messages.Donor') }}
                                </th>
                                <th scope="col">{{ __('messages.Quantity') }}
                                </th>
                                <th scope="col">{{ __('messages.DateDonated') }}
                                </th>
                                <th scope="col" class="actions">{{ __('messages.Actions') }}
                                </th>
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
                                        <a href="{{ route('donations.show', $donation->id) }}"
                                            class="btn btn-info btn-sm">{{ __('messages.View') }}</a>
                                        <a href="{{ route('donations.edit', $donation->id) }}"
                                            class="btn btn-warning btn-sm">{{ __('messages.Edit') }}</a>
                                        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('{{ __('messages.suredeletedonation') }}
?');">
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
                </div>
            </div>
        </div>
    </section>
@endsection
``` --}}

@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Dashboard') }}
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}
                    </a></li>
                <li class="breadcrumb-item">{{ __('messages.DonationCenter') }}
                </li>
                <li class="breadcrumb-item active">{{ __('messages.ListDonations') }}
                </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">{{ __('messages.ListDonations') }}</h5>
                        <div>
                            <a href="{{ route('donations.create') }}" class="btn btn-success mb-3">
                                <i class="fa-solid fa-user-plus"></i> {{ __('messages.AddDonation') }}
                            </a>
                            <button class="btn btn-primary mb-3" onclick="printPage()">
                                <i class="fa-solid fa-print"></i> {{ __('messages.Print') }}
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('donations.index') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by donor name..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">{{ __('messages.Search') }}</button>
                        <a href="{{ route('donations.index') }}" class="btn btn-secondary ms-2">{{ __('messages.Reset') }}</a>
                    </form>

                    <table class="table table-hover" id="donations-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('messages.NeedName') }}</th>
                                <th scope="col">{{ __('messages.Donor') }}</th>
                                <th scope="col">{{ __('messages.Quantity') }}</th>
                                <th scope="col">{{ __('messages.DateDonated') }}</th>
                                <th scope="col" class="actions">{{ __('messages.Actions') }}</th>
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
                                        <a href="{{ route('donations.show', $donation->id) }}"
                                            class="btn btn-info btn-sm">{{ __('messages.View') }}</a>
                                        <a href="{{ route('donations.edit', $donation->id) }}"
                                            class="btn btn-warning btn-sm">{{ __('messages.Edit') }}</a>
                                        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('{{ __('messages.suredeletedonation') }}');">
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
                </div>
            </div>
        </div>
    </section>

    <script>
        function printPage() {
            const tableContent = document.getElementById('donations-table').outerHTML;
            const printWindow = window.open('', '_blank', 'height=600,width=800');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>{{ __('messages.Print') }}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
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
                    </style>
                </head>
                <body>
                    <h1>{{ __('messages.ListDonations') }}</h1>
                    ${tableContent}
                </body>
                </html>
            `);

            printWindow.document.close();

            printWindow.focus();
            printWindow.print();

            printWindow.close();
        }
    </script>

@endsection
