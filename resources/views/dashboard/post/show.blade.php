@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.PostDetails') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.PostControlCenter') }} </li>
                <li class="breadcrumb-item active">{{ __('messages.PostDetails') }} </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.PostInformation') }}</h5>

                    <p><strong>{{ __('messages.Title') }}:</strong> {{ $post->title }}</p>
                    <p><strong>{{ __('messages.Content') }}:</strong> {{ $post->content }}</p>
                    <p><strong>{{ __('messages.Language') }}:</strong> {{ $post->language->name ?? 'N/A' }}</p>

                    <a href="{{ route('posts.manage') }}" class="btn btn-secondary">{{ __('messages.BackAllPosts') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
