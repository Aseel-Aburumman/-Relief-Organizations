@extends('layout.master')
@section('content')

<style>
    .login {
        text-align: center;
    }
    a {
        color: #3CC78F;
    }
    .single_donate {
        width: 200px;
    }
</style>

<div class="popular_causes_area pt-120 cause_details">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success text-center mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center mb-4">
            {{ session('error') }}
        </div>
    @endif

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
                                        {{ number_format($progress, 0) }}%
                                    </span>

                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span style="font-size: 35px;">
                                <strong>{{ __('Raised') }}:</strong> {{ $need->donated_quantity }} {{ $need->item_name }}
                            </span>
                            <span style="font-size: 35px; text-decoration: underline; text-decoration-color: #3CC78F; text-decoration-thickness: 4px;">
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
                                                <form id="donation-form" action="{{ route('donate.store') }}" method="POST" class="donation_form">
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
                                                        @if ($need->status === 'Fulfilled')
                                                            <button type="button" class="boxed-btn4" style="background-color: #d3d3d3; cursor: not-allowed;" disabled>
                                                                {{ __('Donation Completed') }}
                                                            </button><br><br>
                                                            <div class="login">
                                                                {{ __('The required quantity has been fulfilled. Stay tuned for a post documenting the donation!') }}
                                                            </div>
                                                        @else
                                                            <button type="button" id="donate-button" class="boxed-btn4">
                                                                {{ __('Donate Now') }}
                                                            </button>
                                                        @endif
                                                    </div>

                                                    <br>
                                                    <div class="login"
                                                        @if(auth()->check() || $need->status === 'Fulfilled')
                                                            style="display: none;"
                                                        @endif>
                                                        {{ __('You have to login first!') }} <a href="{{ route('login') }}">{{ __('Login') }}</a>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const donateButton = document.getElementById('donate-button');
        const donationForm = document.getElementById('donation-form');
        if (donateButton && donationForm) {
            donateButton.addEventListener('click', function (event) {
                const donationAmount = document.getElementById('donation_amount').value;
                Swal.fire({
                    title: `{{ __('Are you sure?') }}`,
                    text: `{{ __('You are about to donate') }} ${donationAmount} {{ $need->item_name }}.`,
                    iconHtml: '👍',
                    customClass: {
                        icon: 'no-border'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3CC78F',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('Yes, donate!') }}',
                    cancelButtonText: '{{ __('Cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        donationForm.submit();
                    }
                });
            });
        }
    });
</script>

@endsection
