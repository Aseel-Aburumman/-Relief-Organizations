@extends('layout.admin_master')

@section('content')
    <style>
        .single_sidebar_widget {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .single_sidebar_widget h3.widget_title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-transform: capitalize;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
        }

        .media.post_item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .media.post_item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }

        .media-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .media-body a {
            text-decoration: none;
            color: #333;
        }

        .media-body a h3 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px;
        }

        .media-body p {
            font-size: 12px;
            color: #999;
            margin: 0;
        }

        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 20px 0;
        }

        .view-all-link {
            text-align: center;
            margin-top: 10px;
        }

        .view-all-link a {
            text-decoration: none;
            font-size: 14px;
            color: #007bff;
            transition: color 0.3s ease;
        }

        .view-all-link a:hover {
            color: #0056b3;
        }
    </style>
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('doner.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    {{--  <!-- End Page Title -->  --}}

    <section class="blog_area single-post-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">

                    <div class="navigation-top mt-5">
                        <div class="row">
                            <h3>Donatition causes to Gaza you might be inersted in:
                            </h3>
                            <br>
                            <div class="mt-5 col-lg-12">
                                <div class="causes_active owl-carousel"
                                    style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
                                    @foreach ($needs as $need)
                                        <div class=" single_sidebar_widget single_cause"
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

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">

                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
                            @foreach ($posts as $post)
                                <div class="media post_item">
                                    @if ($post->images && $post->images->isNotEmpty())
                                        <img src="{{ asset('storage/post_images/' . $post->images->first()->image) }}"
                                            alt="post">
                                    @else
                                        <img src="{{ asset('storage/post_images/post3.jpg') }}" alt="post">
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
                            {{--  <div class="view-all-link">
                                <a href="{{ route('organization.posts') }}">View all organization1 User posts</a>
                            </div>  --}}
                        </aside>



                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
