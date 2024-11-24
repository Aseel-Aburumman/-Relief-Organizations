@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Create New Post</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item">Post Control Center</li>
                <li class="breadcrumb-item active">Create Post</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Post Information</h5>

                    @if($errors->any())
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
                            <label for="language" class="form-label">Select Language</label>
                            <select id="language-selector" name="lang_id" class="form-control">
                                <option value="">Select a language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" {{ old('lang_id') == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                        </div>

                        <div class="col-md-12">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" class="form-control" id="content">{{ old('content') }}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create Post</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
