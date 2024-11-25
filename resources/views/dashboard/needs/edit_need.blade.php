@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Edit Need</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Need Control Center</li>
                <li class="breadcrumb-item active">Edit Need</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Need Information</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3" method="POST" action="{{ route('organization.update_need', $need->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="organization_id" value="{{ $need->organization_id }}">

                        <div class="col-md-6">
                            <label for="language" class="form-label">Select Language</label>
                            <select id="language-selector" class="form-control">
                                <option value="">Select a language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->key }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="language-fields-container">
                            @foreach ($needDetails as $detail)
                                <div class="col-md-12" id="fields-{{ $detail->language->key }}">
                                    <label for="item_name_{{ $detail->language->key }}" class="form-label">
                                        Need Name ({{ strtoupper($detail->language->key) }})
                                    </label>
                                    <input type="text" name="item_name[{{ $detail->language->key }}]"
                                        class="form-control" id="item_name_{{ $detail->language->key }}"
                                        value="{{ $detail->item_name }}">

                                    <label for="description_{{ $detail->language->key }}" class="form-label">
                                        Description ({{ strtoupper($detail->language->key) }})
                                    </label>
                                    <textarea name="description[{{ $detail->language->key }}]" class="form-control"
                                        id="description_{{ $detail->language->key }}">{{ $detail->description }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            <label for="inputQuantity" class="form-label">Quantity Needed</label>
                            <input type="number" name="quantity_needed" class="form-control" id="inputQuantity"
                                value="{{ $need->quantity_needed }}">
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $need->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputUrgency" class="form-label">Urgency Level</label>
                            <select name="urgency" class="form-control" id="inputUrgency">
                                <option value="Low Priority" {{ $need->urgency == 'Low Priority' ? 'selected' : '' }}>Low
                                    Priority</option>
                                <option value="Medium Priority"
                                    {{ $need->urgency == 'Medium Priority' ? 'selected' : '' }}>Medium Priority</option>
                                <option value="High Priority" {{ $need->urgency == 'High Priority' ? 'selected' : '' }}>
                                    High Priority</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputStatus" class="form-label">Status</label>
                            <select name="status" class="form-control" id="inputStatus">
                                <option value="Available" {{ $need->status == 'Available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="Partially Fulfilled"
                                    {{ $need->status == 'Partially Fulfilled' ? 'selected' : '' }}>Partially Fulfilled
                                </option>
                                <option value="Fulfilled" {{ $need->status == 'Fulfilled' ? 'selected' : '' }}>Fulfilled
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputImage" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="inputImage">


                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Need</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                    @foreach ($currentImageS as $currentImage)
                        <div class="mt-3">
                            <small>Current Image: <img src="{{ asset('storage/need_images/' . $currentImage->image) }}"
                                    alt="Need Image" style="width: 100px;"></small>
                            <form method="POST" action="{{ route('organization.delete_need_image', $currentImage->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('language-selector').addEventListener('change', function() {
            const language = this.value;
            const container = document.getElementById('language-fields-container');

            if (!language) {
                container.innerHTML = '';
                return;
            }

            const existingFields = document.querySelector(`#fields-${language}`);
            if (existingFields) {
                existingFields.scrollIntoView({
                    behavior: 'smooth'
                });
                return;
            }

            const fields = document.createElement('div');
            fields.id = `fields-${language}`;
            fields.innerHTML = `
            <div class="col-md-12">
                <label for="item_name_${language}" class="form-label">Need Name (${language.toUpperCase()})</label>
                <input type="text" name="item_name[${language}]" class="form-control" id="item_name_${language}">
            </div>
            <div class="col-md-12">
                <label for="description_${language}" class="form-label">Description (${language.toUpperCase()})</label>
                <textarea name="description[${language}]" class="form-control" id="description_${language}"></textarea>
            </div>
        `;
            container.appendChild(fields);
        });
    </script>
@endsection
