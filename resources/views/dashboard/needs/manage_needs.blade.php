@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Dashboard') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}</a>
                </li>
                <li class="breadcrumb-item">{{ __('messages.NeedControlCenter') }} </li>
                <li class="breadcrumb-item active">{{ __('messages.ListNeeds') }}</li>
            </ol>
        </nav>
    </div>
    {{--  <!-- End Page Title -->  --}}

    <section class="section dashboard">
        <div class="row w-100">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">{{ __('messages.ListNeeds') }} </h5>
                        <a href="{{ route('organization.create_Need') }}" class="btn btn-success mb-3">
                            <i class="fa-solid fa-user-plus"></i>{{ __('messages.AddNewNeed') }}
                        </a>
                    </div>

                    <form action="{{ route('organization.manage_Needs') }}" method="GET" class="d-flex mb-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ __('messages.Searchbyname') }}..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">{{ __('messages.Search') }}</button>
                        <a href="{{ route('organization.manage_Needs') }}"
                            class="btn btn-secondary ms-2">{{ __('messages.Reset') }}</a>
                    </form>
                    <!-- Table with hoverable rows -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="tableHide" scope="col">#</th>
                                <th scope="col">{{ __('messages.NeedName') }}</th>
                                <th class="tableHide2" scope="col">{{ __('messages.Category') }}</th>
                                <th scope="col">{{ __('messages.QuantityNeeded') }}</th>
                                <th scope="col">{{ __('messages.DonatedNeeded') }}</th>

                                {{--  <th scope="col">{{ __('messages.Description') }}</th>  --}}
                                <th scope="col">{{ __('messages.Status') }}</th>
                                <th class="tableHide" scope="col">{{ __('messages.DateCreated') }}</th>
                                <th scope="col" class="actions">{{ __('messages.Actions') }}</th>
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

                                    {{--  <td> {{ \Illuminate\Support\Str::limit($need->needDetail->first()?->description ?? 'N/A', 100) }}  --}}

                                    </td>
                                    <td>{{ $need->status }}</td>
                                    <td class="tableHide">{{ $need->created_at->format('Y-m-d') }}</td>
                                    <td class="actions">
                                        <a href="{{ route('donation.show', ['id' => $need->id]) }}"
                                            class="btn btn-info btn-sm">{{ __('messages.View') }}</a>
                                        {{--  @role('organization')  --}}
                                        <a href="{{ route('organization.edit_need', ['id' => $need->id]) }}"
                                            class="btn btn-warning btn-sm">{{ __('messages.Edit') }}</a>
                                        <form action="{{ route('organization.delete_need', ['id' => $need->id]) }}"
                                            method="POST" style="display:inline;"
                                            onsubmit="return confirm('{{ __('messages.suredeleteneed') }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm">{{ __('messages.Delete') }}
                                            </button>
                                        </form>
                                        {{--  @endrole  --}}

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
