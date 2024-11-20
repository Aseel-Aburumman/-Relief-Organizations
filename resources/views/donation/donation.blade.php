@extends('layout.master')
@section('content')
    <!-- عرض رسالة النجاح -->
    @if(session('success'))
        <div class="alert alert-success text-center mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Help us to Send {{ $need->item_name }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end -->

    <!-- popular_causes_area_start -->
    <div class="popular_causes_area pt-120 cause_details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="single_cause">
                        <div class="thumb">
                            <img src="img/causes/large_img.png" alt="Need Image">
                        </div>
                        <div class="causes_content">
                            <div class="custom_progress_bar">
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

                            <div class="balance d-flex justify-content-between align-items-center">
                                <span>Raised: {{ $need->donated_quantity }} {{ $need->item_name }}</span>
                                <span>Goal: {{ $need->quantity_needed }} {{ $need->item_name }}</span>
                            </div>
                            <h4>{{ $need->item_name }}</h4>
                            <p>{{ $need->description }}</p>
                            <p><b>Urgency:</b> {{ $need->urgency }}</p>
                            <p><b>Status:</b> {{ $need->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popular_causes_area_end -->

    <!-- make_donation_area_start -->
    <div class="make_donation_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>Make a Donation</span></h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" style="height: 20%">
                <div class="col-lg-6">
                    <form action="{{ route('donate.store') }}" method="POST" class="donation_form">
                        @csrf
                        <input type="hidden" name="need_id" value="{{ $need->id }}">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="single_amount">
                                    <div class="input_field">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Max</span>
                                            </div>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="{{ $maxDonation }}"
                                                aria-label="MaxDonation"
                                                aria-describedby="basic-addon1"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single_amount">
                                    <div class="fixed_donat d-flex align-items-center justify-content-between">
                                        <div class="select_prise">
                                            <h4>Amount:</h4>
                                        </div>
                                        <div class="single_donate">
                                            <input
                                                type="number"
                                                id="donation_amount"
                                                name="donation_amount"
                                                placeholder="Enter your amount"
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
                            <button type="submit" class="boxed-btn4">Donate Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- make_donation_area_end -->
@endsection
