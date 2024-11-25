@extends('layout.master')
@section('content')
  <!-- slider_area_start -->
<div class="slider_area">
    <div class="single_slider d-flex align-items-center slider_bg_1 overlay2">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="slider_text">
                        <span>{{ __('messages.getStartedToday') }}</span>
                        <h3>{{ __('messages.bannerTitleA1') }}
                            <br>{{ __('messages.bannerTitleA2') }}
                            <br>{{ __('messages.bannerTitleA3') }}
                        </h3>
                        <p>{{ __('messages.bannerDescription') }}</p>
                        <a href="{{ route('need') }}" class="boxed-btn3">{{ __('messages.learnMore') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider_area_end -->


  <!-- reson_area_start  -->
<div class="reson_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center mb-55">
                    <h3><span>{{ __('messages.ourOrganizations') }}</span></h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($organizations as $organization)
                <div class="col-lg-4 col-md-6">
                    <div class="single_cause"
                        style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                        <!-- القسم العلوي للصورة -->
                        <div class="thumb" style="height: 250px; overflow: hidden; position: relative;">
                            @if ($organization->image->isNotEmpty())
                                <img src="{{ asset('storage/organization_images/' . $organization->image->first()->image) }}"
                                    alt="{{ __('messages.organizationImage') }}" class="organization-img"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                            @else
                                <img src="{{ asset('img/default.jpg') }}" alt="{{ __('messages.defaultImage') }}" class="organization-img"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                            @endif
                        </div>
                        <!-- القسم السفلي للنصوص -->
                        <div class="causes_content" style="padding: 20px; text-align: center; background-color: #fff;">
                            <h4 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                                {{ $organization->userDetail->first()->name ?? __('messages.noNameAvailable') }}</h4>
                            <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
                                {{ $organization->userDetail->first()->description ?? __('messages.noDescriptionAvailable') }}</p>
                            <a href="{{ route('organization.profile.one', ['id' => $organization->id]) }}"
                                class="read_more">{{ __('messages.learnMore') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- reson_area_end  -->

    <style>
        /* تأثير هوفر على الصور */
        .organization-img:hover {
            transform: scale(1.1);
            /* تكبير الصورة قليلاً */
        }
    </style>




    <!-- reson_area_end  -->

    <!-- latest_activites_area_start  -->
<div class="latest_activites_area">
    <div class="video_bg_1 video_activite d-flex align-items-center justify-content-center">
        <a class="popup-video" href="https://www.youtube.com/watch?v=MG3jGHnBVQs">
            <i class="flaticon-ui"></i>
        </a>
    </div>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-7">
                <div class="activites_info">
                    <div class="section_title">
                        <h3>
                            <span>{{ __('messages.watchLatest') }}</span><br>
                            {{ __('messages.activities') }}
                        </h3>
                    </div>
                    <p class="para_1">
                        {{ __('messages.latestActivitiesPara1') }}
                    </p>
                    <p class="para_2">
                        {{ __('messages.latestActivitiesPara2') }}
                    </p>
                    <a href="{{ route('need') }}" data-scroll-nav='1' class="boxed-btn4">
                        {{ __('messages.donateNow') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- latest_activites_area_end  -->

<!-- popular_causes_area_start -->
<div class="popular_causes_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center mb-55">
                    <h3><span>{{ __('messages.popularNeed') }}</span></h3><br><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="causes_active owl-carousel"
                    style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
                    @foreach ($needs as $need)
                        <div class="single_cause"
                            style="width: 300px; height: 420px; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                            <div class="thumb" style="height: 180px; overflow: hidden;">
                                @php
                                    $imagePath = $need->image->isNotEmpty()
                                        ? 'need_images/' . $need->image->first()->image
                                        : 'img/default-image.png';
                                @endphp
                                <img src="{{ asset('storage/' . $imagePath) }}"
                                    alt="{{ $need->needDetail->first()->item_name ?? __('messages.noName') }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                            <div class="causes_content"
                                style="padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div class="custom_progress_bar" style="margin-bottom: 10px;">
                                    <div class="progress">
                                        @php
                                            $progress =
                                                $need->quantity_needed > 0
                                                    ? ($need->donated_quantity / $need->quantity_needed) * 100
                                                    : 0;
                                        @endphp
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <span class="progres_count">
                                                {{ round($progress) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center"
                                    style="margin-bottom: 10px;">
                                    <span>{{ __('messages.donated') }}: {{ $need->donated_quantity }}</span>
                                    <span>{{ __('messages.needed') }}: {{ $need->quantity_needed }}</span>
                                </div>
                                <!-- عرض اسم الحاجة -->
                                <h4 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                                    {{ $need->needDetail->first()->item_name ?? __('messages.noName') }}
                                </h4>
                                <!-- عرض الوصف -->
                                <p
                                    style="font-size: 14px; color: #777; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                    {{ Str::limit($need->needDetail->first()->description ?? __('messages.noDescription'), 100) }}
                                </p>
                                <a href="{{ route('donation.show', ['id' => $need->id]) }}" class="boxed-btn3">
                                    {{ __('messages.learnMore') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- popular_causes_area_end -->
<!-- counter_area_start -->
<div class="counter_area">
    <div class="container">
        <div class="counter_bg overlay">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="flaticon-calendar"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter">120</h3>
                            <p>{{ __('messages.finishedEvent') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="flaticon-heart-beat"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter">120</h3>
                            <p>{{ __('messages.finishedEvent') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="flaticon-in-love"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter">120</h3>
                            <p>{{ __('messages.finishedEvent') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="flaticon-hug"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter">120</h3>
                            <p>{{ __('messages.finishedEvent') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- counter_area_end -->
    <br><br><br>
    <!-- news__area_start -->
<div class="news__area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center mb-55">
                    <h3><span>{{ __('messages.newsUpdates') }}</span></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="news_active owl-carousel">
                    @foreach ($posts as $post)
                        <div class="single__blog d-flex align-items-center">
                            <div class="thum" style="height: 180px; overflow: hidden;">
                                <!-- عرض الصورة الأولى من الصور المرتبطة -->
                                @if ($post->images->isNotEmpty())
                                    <img src="{{ asset('storage/post_images/' . $post->images->first()->image) }}"
                                        alt="{{ $post->title }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('img/default.jpg') }}" alt="{{ __('messages.defaultImageAlt') }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>

                            <div class="newsinfo">
                                <span>{{ $post->created_at->translatedFormat('F d, Y') }}</span>
                                <a href="#">
                                    <h3>{{ $post->title }}</h3>
                                </a>
                                <p>{{ Str::limit($post->content, 100) }}</p>
                                <a class="read_more" href="#">{{ __('messages.readMore') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<!-- news__area_end -->

    {{-- <div data-scroll-index='1' class="make_donation_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>Make a Donation</span></h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="#" class="donation_form">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="single_amount">
                                    <div class="input_field">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text" id="basic-addon1">$</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="40,200" aria-label="Username" aria-describedby="basic-addon1">
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single_amount">
                                   <div class="fixed_donat d-flex align-items-center justify-content-between">
                                       <div class="select_prise">
                                           <h4>Select Amount:</h4>
                                       </div>
                                        <div class="single_doonate">
                                            <input type="radio" id="blns_1" name="radio-group" checked>
                                            <label for="blns_1">10</label>
                                        </div>
                                        <div class="single_doonate">
                                            <input type="radio" id="blns_2" name="radio-group" checked>
                                            <label for="blns_2">30</label>
                                        </div>
                                        <div class="single_doonate">
                                            <input type="radio" id="Other" name="radio-group" checked>
                                            <label for="Other">Other</label>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="donate_now_btn text-center">
                        <a href="#" class="boxed-btn4">Donate Now</a>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}
@endsection
