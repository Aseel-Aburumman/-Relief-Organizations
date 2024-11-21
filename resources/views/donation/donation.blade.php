@extends('layout.master')
@section('content')
<style>
    /* إخفاء الصفحة أثناء التحميل */
    body.loading {
        visibility: hidden;
        opacity: 0;
    }

    body.loaded {
        visibility: visible;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* تحسين عرض الصور */
    .thumb img {
        width: 100%;
        height: auto;
        object-fit: contain;
        max-width: 100%;
        display: block;
    }

    /* شاشة تحميل (اختياري) */
    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        visibility: visible;
        opacity: 1;
        transition: opacity 0.5s ease;
    }

    #loading-screen.hidden {
        visibility: hidden;
        opacity: 0;
    }
</style>

<!-- شاشة تحميل -->
<div id="loading-screen">
    <p>Loading...</p>
</div>

@if(session('success'))
    <div class="alert alert-success text-center mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="popular_causes_area pt-120 cause_details">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="single_cause">
                    <div class="thumb">
                        @php
                            $imagePath = $need->image->isNotEmpty() ? 'need_images/' . $need->image->first()->image : 'img/default-image.png';
                        @endphp
                        <img src="{{ asset('storage/' . $imagePath) }}"
                             alt="{{ $need->needDetail->first()->item_name ?? 'No Name' }}">
                    </div>

                    <div class="causes_content">
                        <div class="custom_progress_bar mb-4">
                            <div class="progress">
                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ $progress }}%;"
                                    aria-valuenow="{{ $progress }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    <span class="progres_count">
                                        {{ $progress }}%
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span style="font-size: 18px;">
                                <strong>{{ __('Raised') }}:</strong> {{ $need->donated_quantity }} {{ $need->item_name }}
                            </span>
                            <span style="font-size: 18px; text-decoration: underline; text-decoration-color: #3CC78F; text-decoration-thickness: 4px;">
                                <strong>{{ __('Goal') }}:</strong> {{ $need->quantity_needed }} {{ $need->item_name }}
                            </span>
                        </div>

                        <div class="causes_content d-flex justify-content-between align-items-start flex-wrap" style="gap: 20px;">
                            <div style="width: 48%; font-size: 16px;">
                                <h4>{{ $need->needDetail->first()->item_name }}</h4>
                                <p>{{ $need->needDetail->first()->description ?? __('No description available') }}</p>
                                <p><b style="color: #3CC78F">{{ __('Urgency') }}:</b> {{ $need->urgency }}</p>
                                <p><b style="color: #3CC78F">{{ __('Status') }}:</b> {{ $need->status }}</p>
                            </div>
                            <div style="width: 48%; align-self: flex-start; margin-top: -120px;">
                                <div class="make_donation_area section_padding">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="section_title text-center mb-4">
                                                    <h3><span>{{ __('Make a Donation') }}</span></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center" style="height: auto;">
                                            <div class="col-lg-12">
                                                <form action="{{ route('donate.store') }}" method="POST" class="donation_form">
                                                    @csrf
                                                    <input type="hidden" name="need_id" value="{{ $need->id }}">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <div class="single_amount">
                                                                <div class="input_field">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">{{ __('Max') }}</span>
                                                                        </div>
                                                                        <input
                                                                            type="text"
                                                                            class="form-control"
                                                                            placeholder="{{ $maxDonation }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="single_amount">
                                                                <div class="fixed_donat d-flex align-items-center justify-content-between">
                                                                    <div class="select_prise">
                                                                        <h4>{{ __('Amount') }}:</h4>
                                                                    </div>
                                                                    <div class="single_donate">
                                                                        <input
                                                                            type="number"
                                                                            id="donation_amount"
                                                                            name="donation_amount"
                                                                            placeholder="{{ __('Enter your amount') }}"
                                                                            class="form-control"
                                                                            min="1"
                                                                            max="{{ $maxDonation }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="donate_now_btn text-center mt-4">
                                                        <button type="submit" class="boxed-btn4">{{ __('Donate Now') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- popular_causes_area_end -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            loadingScreen.style.display = 'none';
        }

        document.body.classList.remove('loading');
        document.body.classList.add('loaded');
    });
</script>

