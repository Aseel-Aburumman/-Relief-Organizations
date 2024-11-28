@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.AllPosts') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.PostControlCenter') }} </li>
                <li class="breadcrumb-item active">{{ __('messages.AllPosts') }} </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.PostList') }}</h5>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('posts.create') }}"
                        class="btn btn-primary mb-3">{{ __('messages.CreateNewPost') }}</a>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('messages.Title') }}</th>
                                <th>{{ __('messages.Content') }}</th>
                                <th>{{ __('messages.Language') }}</th>
                                <th>{{ __('messages.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ Str::limit($post->content, 50) }}</td>
                                    <td>{{ $post->language->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('posts.show', $post->id) }}"
                                            class="btn btn-info btn-sm">{{ __('messages.View') }}</a>
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="btn btn-warning btn-sm">{{ __('messages.Edit') }}</a>
                                        <form action="{{ route('posts.delete', $post->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-danger btn-sm">{{ __('messages.Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('messages.Nopostsfound') }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
