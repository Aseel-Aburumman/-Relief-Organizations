@extends('layout.master')
@section('content')
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
                                src="{{ asset('storage/organization_images/' . $OrganizationImages->image) }}" alt="">
                        </div>
                        <div class="blog_details">
                            <h1>{{ $organization->userDetail->first()->name }}
                            </h1>
                            <ul class="blog-info-link mt-3 mb-4">
                                {{--  <li><a href="#"><i class="fa fa-user"></i> Travel, Lifestyle</a></li>  --}}
                                <li><a href="#"><i class="fa fa-money"></i> {{ $organization->need->count() }}
                                        Needs</a></li>
                            </ul>
                            <p class="excert">
                                {{ $organization->userDetail->first()->description }}
                            </p>

                        </div>
                    </div>
                    <div class="navigation-top mt-5">
                        <div class="row">
                            <h3>Donate to Gaza needs through the {{ $organization->userDetail->first()->name }} organization
                            </h3>
                            <br>
                            <div class="mt-5 col-lg-12">
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
                                                    <span>Donated: {{ $need->donated_quantity }}</span>
                                                    <span>Needed: {{ $need->quantity_needed }}</span>
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
                                                    class="boxed-btn3">Learn More</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Pagination Links -->
                                <div class="mt-3">
                                    {{ $needs->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">

                        {{--  <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            <ul class="list cat-list">
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Resaurant food</p>
                                        <p>(37)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Travel news</p>
                                        <p>(10)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Modern technology</p>
                                        <p>(03)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Product</p>
                                        <p>(11)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Inspiration</p>
                                        <p>(21)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Health Care</p>
                                        <p>(21)</p>
                                    </a>
                                </li>
                            </ul>
                        </aside>  --}}
                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
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
                            <h6><a
                                    href="{{ route('organization.post.all', ['organization_id' => $post->organization_id]) }}">
                                    View all {{ $organization->userDetail->first()->name }} posts </a>
                            </h6>
                        </aside>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ Blog Area end =================-->
@endsection
