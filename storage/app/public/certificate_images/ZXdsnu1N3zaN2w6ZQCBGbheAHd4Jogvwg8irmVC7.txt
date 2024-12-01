@extends('layout.master')
@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>{{ __('messages.Contact') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <!-- ================ contact section start ================= -->

    <section class="contact-section">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">{{ __('messages.GetInTouch') }}</h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="{{ route('contact.store') }}" method="POST" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                        placeholder="{{ __('messages.EnterMessage') }}"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="name" id="name" type="text"
                                        placeholder="{{ __('messages.EnterYourName') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email"
                                        placeholder="{{ __('messages.Email') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text"
                                        placeholder="{{ __('messages.EnterSubject') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">{{ __('messages.Send') }}</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>{{ __('messages.Address') }}</h3>
                            <p>{{ __('messages.AddressDetails') }}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>{{ __('messages.PhoneNumber') }}</h3>
                            <p>{{ __('messages.WorkingHours') }}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>{{ __('messages.SupportEmail') }}</h3>
                            <p>{{ __('messages.QueryInfo') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-none d-sm-block mb-5 pb-4">
            <iframe style="width:100%; height:350px"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1692.4598450578603!2d35.91044596116633!3d31.96307536906288!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca1014048fa25%3A0x9f4515881213fb7a!2sAl%20Fares%20Luxury%20furnished%20Apartment-Damac%20Tower!5e0!3m2!1sar!2sjo!4v1731101485148!5m2!1sar!2sjo"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>
    <!-- ================ contact section end ================= -->
@endsection
