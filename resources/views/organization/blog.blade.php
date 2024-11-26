@extends('layout.master')
@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>{{ $organization->userDetail->first()->name }} {{ __('messages.PostsA') }}
                             </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->


    <!--================Blog Area =================-->
    <section class="blog_area section-padding">
        <div class="container">
            {{-- <div class="row"> --}}
                <div class="col-lg-12 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar ">
            <div class="row">

                        @foreach ($posts as $post)
                            <article class="mt-3 col col-sm-6  ">
                                <div class="blog_item_img">
                                    @if ($post->images && $post->images->isNotEmpty())
                                        <img class="card-img rounded-0"
                                            src="{{ asset('storage/post_images/' . $post->images->first()->image) }}"
                                            alt="" style="height:300px; object-fit:cover;">
                                    @else
                                        <img class="card-img rounded-0" src="{{ asset('storage/post_images/post3.jpg') }}"
                                            alt="" style="height:300px; object-fit:cover;">
                                    @endif

                                    <a href="{{ route('organization.post.one', ['id' => $post->id]) }}"
                                        class="blog_item_date">
                                        <h3>{{ $post->created_at->format('d') }}</h3>
                                        <p>{{ $post->created_at->format('M') }}</p>
                                    </a>
                                </div>

                                <div class="blog_details">
                                    <a class="d-inline-block"
                                        href="{{ route('organization.post.one', ['id' => $post->id]) }}">
                                        <h2>{{ $post->title }}</h2>
                                    </a>
                                    <p>{{ \Illuminate\Support\Str::words($post->content, 20, '...') }}</p>
                                    <ul class="blog-info-link">
                                        {{--  <li><a href="#"><i class="fa fa-user"></i> Travel, Lifestyle</a></li>  --}}
                                        <li><a href="{{ route('organization.post.one', ['id' => $post->id]) }}"><i
                                                    class="fa fa-comments"></i>{{ __('messages.ReadmoreA') }}
 </a></li>
                                    </ul>
                                </div>
                            </article>
                        @endforeach

                    </div>


                        <nav class="blog-pagination justify-content-center d-flex">
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if ($posts->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" aria-label="Previous">
                                            <i class="ti-angle-left"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a href="{{ $posts->previousPageUrl() }}" class="page-link" aria-label="Previous">
                                            <i class="ti-angle-left"></i>
                                        </a>
                                    </li>
                                @endif

                                <!-- Pagination Links -->
                                @foreach ($posts->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $page == $posts->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($posts->hasMorePages())
                                    <li class="page-item">
                                        <a href="{{ $posts->nextPageUrl() }}" class="page-link" aria-label="Next">
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
    </section>
    <!--================Blog Area =================-->
@endsection
