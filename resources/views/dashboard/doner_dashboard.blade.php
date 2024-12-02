@extends('layout.admin_master')

@section('content')
    <style>
        .dashboard-section {
            margin-bottom: 30px;
        }

        .dashboard-section h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .recent-post img,
        .need-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .recent-post-title,
        .need-card h5 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .recent-post-date,
        .need-card p {
            font-size: 14px;
            color: #555;
        }

        .recent-post {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 15px;
            border: 1px solid #f4f4f4;
            border-radius: 10px;
            transition: transform 0.3s ease;

        }

        .need-card {
            text-align: center;
            padding: 15px;
            border: 1px solid #f4f4f4;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

            border-radius: 10px;
            transition: transform 0.3s ease;
            background-color: #fff;
        }

        .need-card:hover {
            transform: translateY(-5px);
        }

        .btnColor {
            background-color: #3CC78F;
            color: white;
        }
    </style>

    <div class="pagetitle">
        <h1>{{ __('messages.DonorDashboard') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('doner.dashboard') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.Dashboard') }}</li>
            </ol>
        </nav>
    </div>

    <section class="dashboard-section">
        <h2>{{ __('messages.YourDonationHistory') }}</h2>
        <div class="dashboard-card">
            <form action="{{ route('doner.dashboard') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="search" class="form-control"
                    placeholder="{{ __('messages.SearchbyNeedName') }}" value="{{ request('search') }}">
                <input type="date" name="filter_date" class="form-control ms-2" placeholder="{{ __('messages.Date') }}"
                    value="{{ request('filter_date') }}">
                <button type="submit" class="btn btnColor ms-2">{{ __('messages.Filter') }}</button>
                <a href="{{ route('doner.dashboard') }}" class="btn btn-secondary ms-2">{{ __('messages.Reset') }}</a>
            </form>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.Organization') }}</th>
                            <th>{{ __('messages.Need') }}</th>
                            <th>{{ __('messages.Quantity') }}</th>
                            <th>{{ __('messages.Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donations as $donation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $donation->need->organization->userDetail->first()->name ?? 'N/A' }}</td>
                                <td>{{ $donation->need->needDetail->first()?->item_name ?? 'N/A' }}</td>
                                <td>{{ $donation->quantity }}</td>
                                <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('messages.NoDonationsFound') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $donations->links() }}
            </div>
        </div>
    </section>

    <section class="dashboard-section">
        <h2>{{ __('messages.RecommendedNeeds') }}</h2>
        <div class="row">
            @forelse ($needs as $need)
                <div class="col-md-4 mb-3">
                    <div class="need-card">
                        @if ($need->image && $need->image->isNotEmpty())
                            <img src="{{ asset('storage/need_images/' . $need->image->first()->image) }}" alt="Need Image">
                        @else
                            <img src="{{ asset('storage/post_images/post3.jpg') }}" alt="Need Image">
                        @endif

                        <h5>{{ $need->needDetail->first()?->item_name ?? 'N/A' }}</h5>
                        <p>{{ __('messages.QuantityNeeded') }}: {{ $need->quantity_needed }}</p>
                        <a href="{{ route('donation.show', $need->id) }}"
                            class="btn btnColor btn-sm">{{ __('messages.Donate') }}</a>
                    </div>
                </div>
            @empty
                <p class="text-center">{{ __('messages.NoNeedsFound') }}</p>
            @endforelse
        </div>
    </section>

    <section class="dashboard-section">
        <h2>{{ __('messages.LatestUpdates') }}</h2>
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4 mb-3">
                    <div class="recent-post">
                        @if ($post->images && $post->images->isNotEmpty())
                            <img src="{{ asset('storage/post_images/' . $post->images->first()->image) }}"
                                alt="{{ $post->title }}">
                        @else
                            <img src="{{ asset('storage/post_images/post3.jpg') }}" alt="{{ $post->title }}">
                        @endif

                        <h4 class="recent-post-title">{{ $post->title }}</h4>
                        <p class="recent-post-date">{{ $post->created_at->format('Y-m-d') }}</p>
                        <a href="{{ route('posts.show', $post->id) }}"
                            class="btn btnColor btn-sm">{{ __('messages.ReadMore') }}</a>
                    </div>
                </div>
            @empty
                <p class="text-center">{{ __('messages.NoPostsFound') }}</p>
            @endforelse
        </div>
    </section>
@endsection
