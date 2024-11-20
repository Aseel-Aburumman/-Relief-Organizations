
@extends('layout.master')
@section('content')
    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider  d-flex align-items-center slider_bg_1 overlay2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="slider_text ">
                            <span>Get Started Today.</span>
                            <h3> Help the children
                                When They Need</h3>
                            <p>With so much to consume and such little time, coming up <br>
                                with relevant title ideas is essential</p>
                            <a href="About.html" class="boxed-btn3">Learn More
                            </a>
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
                        <h3><span>Our Organizations</span></h3><br><br><br><br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($organizations as $organization)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_reson">
                            <div class="thum">
                                <div class="thum_1">
                                    <!-- عرض الصورة الأولى إذا كانت موجودة -->
                                    @if($organization->image->first())
                                        <img src="{{ asset($organization->image->first()->image) }}" alt="Organization Image">
                                    @else
                                        <img src="{{ asset('img/default.jpg') }}" alt="Default Image">
                                    @endif
                                </div>
                            </div>
                            <div class="help_content">
                                <h4>{{ $organization->userDetail->first()->name ?? 'No Name Available' }}</h4>
                                <p>{{ $organization->userDetail->first()->description ?? 'No Description Available' }}</p>
                                <a href="#" class="read_more">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- reson_area_end  -->

    <!-- latest_activites_area_start  -->
    <div class="latest_activites_area">
        <div class=" video_bg_1 video_activite  d-flex align-items-center justify-content-center">
            <a class="popup-video" href="https://www.youtube.com/watch?v=MG3jGHnBVQs">
                <i class="flaticon-ui"></i>
            </a>
        </div>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="activites_info">
                        <div class="section_title">
                            <h3> <span>Watch Our Latest  </span><br>
                                Activities</h3>
                        </div>
                        <p class="para_1">Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do
                            eiusmod tempor incididunt  ut labore dolore magna aliqua.
                            enim minim veniam, quis nostrud exercitation.</p class="para_1">
                        <p class="para_2">Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do
                            eiusmod tempor incididunt  ut labore dolore magna aliqua.
                            enim minim veniam, quis nostrud exercitation. tempor
                            incididunt  ut labore dolore magna aliqua. enim minim
                            veniam, quis nostrud exercitation.</p>
                        <a href="#" data-scroll-nav='1' class="boxed-btn4">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest_activites_area_end  -->

    <!-- popular_causes_area_start  -->
    <div class="popular_causes_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>Popular Need</span></h3><br><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="causes_active owl-carousel">
                        @foreach($needs as $need)
                            <div class="single_cause">
                                <div class="thumb">
                                    <!-- عرض صورة العنصر -->
                                    <img src="{{ asset('img/causes/' . ($need->image ?? 'default.png')) }}" alt="{{ $need->item_name }}">
                                </div>
                                <div class="causes_content">
                                    <div class="custom_progress_bar">
                                        <div class="progress">
                                            <!-- حساب النسبة المئوية -->
                                            @php
                                                $progress = $need->quantity_needed > 0 ? ($need->donated_quantity / $need->quantity_needed) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                <span class="progres_count">
                                                    {{ round($progress) }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="balance d-flex justify-content-between align-items-center">
                                        <span>Donated: {{ $need->donated_quantity }}</span>
                                        <span>Needed: {{ $need->quantity_needed }}</span>
                                    </div>
                                    <h4>{{ $need->item_name }}</h4>
                                    <p>{{ $need->description }}</p>
                                    <a class="read_more" href="#">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popular_causes_area_end  -->

    <!-- counter_area_start  -->
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
                                <p>Finished Event</p>
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
                                <p>Finished Event</p>
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
                                <p>Finished Event</p>
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
                                <p>Finished Event</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter_area_end  -->
<br><br><br>
    <!-- news__area_start  -->
    <div class="news__area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>News & Updates</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="news_active owl-carousel">
                        @foreach($posts as $post)
                            <div class="single__blog d-flex align-items-center">
                                <div class="thum">
                                    <!-- عرض الصورة الأولى من الصور المرتبطة -->
                                    @if($post->images->first())
                                        <img src="{{ asset('storage/' . $post->images->first()->image) }}" alt="{{ $post->title }}">
                                    @else
                                        <img src="{{ asset('img/default.jpg') }}" alt="Default Image">
                                    @endif
                                </div>
                                <div class="newsinfo">
                                    <span>{{ $post->created_at->format('F d, Y') }}</span>
                                    <a href="#">
                                        <h3>{{ $post->title }}</h3>
                                    </a>
                                    <p>{{ $post->content }}</p>
                                    <a class="read_more" href="#">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
<br><br><br>
    <!-- news__area_end  -->

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


