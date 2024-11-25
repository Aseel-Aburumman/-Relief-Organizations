@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Create New Need</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Need Control Center</li>
                <li class="breadcrumb-item active">Create Need</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Need Information</h5>

                    <form class="row g-3" method="POST" action="{{ route('organization.store_need') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="organization_id" value="{{ $organization->id }}">

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
                            <!-- Dynamically generated fields will be added here -->
                        </div>

                        <div class="col-md-6">
                            <label for="inputQuantity" class="form-label">Quantity Needed</label>
                            <input type="number" name="quantity_needed" class="form-control" id="inputQuantity"
                                value="{{ old('quantity_needed') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputUrgency" class="form-label">Urgency Level</label>
                            <select name="urgency" class="form-control" id="inputUrgency">
                                <option value="Low Priority">Low Priority</option>
                                <option value="Medium Priority">Medium Priority</option>
                                <option value="High Priority">High Priority</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputStatus" class="form-label">Status</label>
                            <select name="status" class="form-control" id="inputStatus">
                                <option value="Available">Available</option>
                                <option value="Partially Fulfilled">Partially Fulfilled</option>
                                <option value="Fulfilled">Fulfilled</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputImage" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="inputImage">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create Need</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

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
