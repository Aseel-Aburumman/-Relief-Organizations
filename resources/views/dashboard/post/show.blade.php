@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Post Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item">Post Control Center</li>
                <li class="breadcrumb-item active">Post Details</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Post Information</h5>

                    <p><strong>Title:</strong> {{ $post->title }}</p>
                    <p><strong>Content:</strong> {{ $post->content }}</p>
                    <p><strong>Language:</strong> {{ $post->language->name ?? 'N/A' }}</p>

                    <a href="{{ route('posts.manage') }}" class="btn btn-secondary">Back to All Posts</a>
                </div>
            </div>
        </div>
    </section>
@endsection
