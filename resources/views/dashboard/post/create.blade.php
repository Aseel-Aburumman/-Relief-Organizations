@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.CreateNewPost') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.Home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.PostControlCenter') }}</li>
                <li class="breadcrumb-item active">{{ __('messages.CreateNewPost') }} </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.NewPostInformation') }}</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6">
                            <label for="language" class="form-label">{{ __('messages.SelectLanguage') }}</label>
                            <select id="language-selector" name="lang_id" class="form-control">
                                <option value="">{{ __('messages.SelectLanguage') }} </option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}"
                                        {{ old('lang_id') == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="title" class="form-label">{{ __('messages.PostTitle') }}</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title') }}">
                        </div>

                        <div class="col-md-12">
                            <label for="content" class="form-label">{{ __('messages.Content') }}</label>
                            <textarea name="content" class="form-control" id="content">{{ old('content') }}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.Create') }}
                                Post</button>
                            <button type="reset" class="btn btn-secondary">{{ __('messages.Reset') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
