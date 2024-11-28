@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.EditPost') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.PostControlCenter') }} </li>
                <li class="breadcrumb-item active">{{ __('messages.EditPost') }} </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.EditPostInformation') }}</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3" method="POST" action="{{ route('posts.update', $post->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="title" class="form-label">{{ __('messages.Title') }}</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title', $post->title) }}" required>
                        </div>

                        <div class="col-md-12">
                            <label for="content" class="form-label">{{ __('messages.Content') }}</label>
                            <textarea name="content" class="form-control" id="content" required>{{ old('content', $post->content) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="language" class="form-label">{{ __('messages.SelectLanguage') }}</label>
                            <select name="lang_id" id="language" class="form-control" required>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" @if (old('lang_id', $post->lang_id) == $language->id) selected @endif>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">{{ __('messages.UpdatePost') }}</button>
                            <a href="{{ route('posts.manage') }}"
                                class="btn btn-secondary">{{ __('messages.Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
