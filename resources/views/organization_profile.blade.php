@extends('layout.master')
@section('content')
    <style>
        .single_cause {
            width: 300px;
            height: 420px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .single_cause .thumb {
            height: 180px;
            overflow: hidden;
        }

        .single_cause .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .causes_content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .custom_progress_bar {
            margin-bottom: 10px;
        }

        .custom_progress_bar .progress {
            height: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .custom_progress_bar .progress-bar {
            height: 100%;
            background-color: #4caf50;
            /* Green progress bar */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #fff;
            transition: width 0.3s ease;
        }

        .custom_progress_bar .progres_count {
            position: absolute;
            top: -20px;
            font-size: 12px;
            color: #4caf50;
            /* Matches the progress bar color */
            font-weight: bold;
        }

        .balance {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #777;
        }

        h4 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 14px;
            color: #777;
            line-height: 1.5;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
    </style>
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>{{ $organization->userDetail->first()->name ?? 'Default Name' }} </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <!--================Blog Area =================-->
    <section class="blog_area single-post-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="feature-img">
                            <img class="img-fluid"
                                src="{{ asset('storage/organization_images/' . $OrganizationImages->image) }}"
                                alt="">
                        </div>
                        <div class="blog_details">
                            <h1>{{ $organization->userDetail->first()->name }}
                            </h1>
                            <ul class="blog-info-link mt-3 mb-4">
                                {{--  <li><a href="#"><i class="fa fa-user"></i> Travel, Lifestyle</a></li>  --}}
                                <li><a href="#"><i class="fa fa-money"></i> {{ $organization->need->count() }}
                                        {{ __('messages.NeedsA') }}
                                    </a></li>
                            </ul>
                            <p class="excert">
                                {{ $organization->userDetail->first()->description }}
                            </p>

                        </div>
                    </div>
                    <div class="navigation-top mt-5">
                        <div class="row">
                            <h3>{{ __('messages.DonatetoGazaA') }}
                                {{ $organization->userDetail->first()->name }} {{ __('messages.DonatetoGazaA2') }}

                            </h3>
                            <br>
                            <div class="mt-5 col-lg-12">
                                <div class="causes_active owl-carousel ml-0 mr-0"
                                    style="display: flex; flex-wrap: wrap; justify-content: center;  ">
                                    @foreach ($needs as $need)
                                        <div class="w-50 single_cause"
                                            style="width: 300px; height: 420px; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                                            <div class="thumb" style="height: 180px; overflow: hidden;">
                                                @php
                                                    $imagePath = $need->image->isNotEmpty()
                                                        ? 'need_images/' . $need->image->first()->image
                                                        : 'img/default-image.png';
                                                @endphp
                                                <img src="{{ asset('storage/' . $imagePath) }}"
                                                    alt="{{ $need->needDetail->first()->item_name ?? 'No Name' }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>

                                            <div class="causes_content"
                                                style="padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                                <div class="custom_progress_bar" style="margin-bottom: 10px;">
                                                    <div class="progress">
                                                        @php
                                                            $progress =
                                                                $need->quantity_needed > 0
                                                                    ? ($need->donated_quantity /
                                                                            $need->quantity_needed) *
                                                                        100
                                                                    : 0;
                                                        @endphp
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $progress }}%;"
                                                            aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            <span class="progres_count">
                                                                {{ round($progress) }}%
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="balance d-flex justify-content-between align-items-center"
                                                    style="margin-bottom: 10px;">
                                                    <span>{{ __('messages.DonatedA') }}
                                                        : {{ $need->donated_quantity }}</span>
                                                    <span>{{ __('messages.NeededA') }}
                                                        : {{ $need->quantity_needed }}</span>
                                                </div>
                                                <!-- عرض اسم الحاجة -->
                                                <h4 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                                                    {{ $need->needDetail->first()->item_name ?? 'No Name' }}
                                                </h4>
                                                <!-- عرض الوصف -->
                                                <p
                                                    style="font-size: 14px; color: #777; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                                    {{ Str::limit($need->needDetail->first()->description ?? 'No description available', 100) }}
                                                </p>
                                                <a href="{{ route('donation.show', ['id' => $need->id]) }}"
                                                    class="boxed-btn3">{{ __('messages.LearnMoreA') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Pagination Links -->
                                <nav class="blog-pagination justify-content-center d-flex">
                                    <ul class="pagination">
                                        <!-- Previous Page Link -->
                                        @if ($needs->onFirstPage())
                                            <li class="page-item disabled">
                                                <a class="page-link" aria-label="Previous">
                                                    <i class="ti-angle-left"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $needs->previousPageUrl() }}" class="page-link"
                                                    aria-label="Previous">
                                                    <i class="ti-angle-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        <!-- Pagination Links -->
                                        @foreach ($needs->links()->elements[0] as $page => $url)
                                            <li class="page-item {{ $page == $needs->currentPage() ? 'active' : '' }}">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Next Page Link -->
                                        @if ($needs->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $needs->nextPageUrl() }}" class="page-link" aria-label="Next">
                                                    <i class="ti-angle-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a class="page-link" aria-label="Next">
                                                    <i class="ti-angle-right"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
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
                            <h6><a href="{{ route('organization.post.all', ['organization_id' => $organization->id]) }}">
                                    {{ __('messages.ViewallA') }}
                                    {{ $organization->userDetail->first()->name }} {{ __('messages.PostsA') }}
                                </a>
                            </h6>
                        </aside>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ Blog Area end =================-->
@endsection
