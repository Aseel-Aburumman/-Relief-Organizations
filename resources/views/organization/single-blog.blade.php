@extends('layout.master')
@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>{{ $post->title }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <!--================Blog Area =================-->
    <section class="blog_area single-post-area section-padding">
       
        <div class="container">
             <nav>
            <ol class="breadcrumb" style="background-color: white">
                <li class="breadcrumb-item"><a href="{{ route('organization.profile.one', ['id' => $organization->id]) }}">{{ $organization->userDetail->first()->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('organization.post.all', ['organization_id' => $organization->id]) }}">{{ $organization->userDetail->first()->name }} {{ __('messages.PostsA') }}</a></li>
                <li class="breadcrumb-item active">{{ $post->title }}</li>
            </ol>
        </nav>
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="feature-img">
                            @if ($post->images && $post->images->isNotEmpty())
                                <img class="card-img rounded-0"
                                    src="{{ asset('storage/post_images/' . $post->images->first()->image) }}" alt=""
                                    style="height:300px; object-fit:cover;">
                            @else
                                <img class="card-img rounded-0" src="{{ asset('storage/post_images/post3.jpg') }}"
                                    alt="" style="height:300px; object-fit:cover;">
                            @endif
                        </div>
                        <div class="blog_details">
                            <h2>{{ $post->title }}
                            </h2>
                            <ul class="blog-info-link mt-3 mb-4">
                                <li><a href="#"><i class="fa fa-comments"></i> {{ $post->created_at }}</a></li>
                            </ul>
                            <p class="excert">
                                {{ $post->content }}
                            </p>

                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">




                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">{{ __('messages.RecentPostA') }}
                            </h3>
                            @foreach ($posts as $post)
                                <div class="media post_item">
                                    @if ($post->images && $post->images->isNotEmpty())
                                        <img src="{{ asset('storage/post_images/' . $post->images->first()->image) }}"
                                            alt="post" style="width:100px;">
                                    @else
                                        <img src="{{ asset('storage/post_images/post3.jpg') }}" alt="post"
                                            style="width:100px; height:100px; object-fit:cover">
                                    @endif

                                    <div class="media-body">
                                        <a href="{{ route('organization.post.one', ['id' => $post->id]) }}">
                                            <h3>{{ $post->title }}</h3>
                                        </a>
                                        <p>{{ $post->created_at }}</p>
                                    </div>
                                </div>
                            @endforeach
                            <hr>

                        </aside>

                        <aside class="single_sidebar_widget instagram_feeds">
                            <h4 class="widget_title">{{ __('messages.InstagramFeedsA') }}
                            </h4>
                            <ul class="instagram_row flex-wrap">
                                @foreach ($posts as $post)
                                    <li>
                                        <a href="#">
                                            @if ($post->images && $post->images->isNotEmpty())
                                                <img class="img-fluid"
                                                    src="{{ asset('storage/post_images/' . $post->images->first()->image) }}"
                                                    alt="" style="width:100px; height:100px; object-fit:cover;">
                                            @else
                                                <img class="img-fluid" src="{{ asset('storage/post_images/post3.jpg') }}"
                                                    alt="" style="width:100px; height:100px; object-fit:cover;">
                                            @endif
                                        </a>

                                    </li>
                                @endforeach


                            </ul>
                        </aside>



                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ Blog Area end =================-->
@endsection
