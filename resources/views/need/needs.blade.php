@extends('layout.master')
@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Needs</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end -->

    <!-- Filter Section (Using Livewire) -->
    <div class="container my-4">
        @livewire('need-filter') <!-- Include Livewire component -->
    </div>

    <!-- popular_causes_area_start -->
    <div class="popular_causes_area pt-120">
        <div class="container">
            <div class="row g-4">
                {{-- @forelse ($needs as $need)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_cause">

                            <!-- Image -->
                            <a href="{{ route('donation.show', $need->id) }}">
                                <div class="thumb" style="height: 200px; overflow: hidden;">
                                    @if ($need->image->isNotEmpty())
                                        <img src="{{ asset('storage/need_images/' . $need->image->first()->image) }}"
                                             alt="{{ $need->needDetail->first()->item_name ?? 'No Name' }}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/default-image.png') }}" alt="No Image"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                </div>
                            </a>

                            <!-- Content -->
                            <div class="causes_content">
                                <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ round(($need->donated_quantity / max($need->quantity_needed, 1)) * 100, 1) }}%;"
                                             aria-valuenow="{{ $need->donated_quantity }}"
                                             aria-valuemin="0"
                                             aria-valuemax="{{ $need->quantity_needed }}">
                                            <span class="progres_count">
                                                {{ round(($need->donated_quantity / max($need->quantity_needed, 1)) * 100, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center">
                                    <span>Raised: ${{ $need->donated_quantity }}</span>
                                    <span>Goal: ${{ $need->quantity_needed }}</span>
                                </div>
                                <a href="{{ route('donation.show', $need->id) }}">
                                    <h4>{{ $need->needDetail->first()->item_name ?? 'No Name' }}</h4>
                                </a>
                                <p>{{ Str::limit($need->needDetail->first()->description ?? 'No Description', 100) }}</p>

                                <a class="read_more" href="{{ route('donation.show', $need->id) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No needs found. Please adjust your filters.</p>
                @endforelse
            </div> --}}
            {{-- <div class="pagination">
                {{ $needs->links() }}
            </div> --}}
        </div>
    </div>
    <!-- popular_causes_area_end -->

    <style>
        .single_cause {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 450px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .single_cause:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .single_cause .thumb {
            width: 100%;
            height: 300px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .single_cause .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .causes_content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            background-color: #fff;
            text-align: center;
        }

        .causes_content h4 {
            font-size: 18px;
            font-weight: 600;
            margin: 10px 0;
        }

        .causes_content p {
            flex-grow: 1;
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        .balance {
            font-size: 14px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .read_more {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .read_more:hover {
            color: #0056b3;
        }
    </style>
@endsection
