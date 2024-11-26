@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Edit Organization</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Organization Control Center</li>
                <li class="breadcrumb-item active">Edit Organization</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Organization Information</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3" method="POST" action="{{ route('organization.update_organization', $organization->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- اختيار اللغة -->
                        <div class="col-md-6">
                            <label for="language" class="form-label">Select Language</label>
                            <select id="language-selector" class="form-control">
                                <option value="">Select a language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الحقول الديناميكية بناءً على اللغة -->
                        <div id="language-fields-container">
                            @foreach ($organizationDetails as $detail)
                                <div class="col-md-12" id="fields-{{ $detail->language_id }}">
                                    <label for="name_{{ $detail->language_id }}" class="form-label">
                                        Organization Name ({{ $detail->language->name }})
                                    </label>
                                    <input type="text" name="name[{{ $detail->language_id }}]" class="form-control"
                                           id="name_{{ $detail->language_id }}" value="{{ $detail->name }}" required>

                                    <label for="description_{{ $detail->language_id }}" class="form-label">
                                        Description ({{ $detail->language->name }})
                                    </label>
                                    <textarea name="description[{{ $detail->language_id }}]" class="form-control"
                                              id="description_{{ $detail->language_id }}">{{ $detail->description }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <label for="contact_info" class="form-label">Contact Information</label>
                            <input type="text" name="contact_info" class="form-control" id="contact_info"
                                   value="{{ old('contact_info', $organization->contact_info) }}">
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <select name="address" class="form-control" id="address">
                                <option value="">Select your country</option>
                                <option value="US" {{ old('address', $organization->address) == 'US' ? 'selected' : '' }}>United States</option>
                                <option value="UK" {{ old('address', $organization->address) == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="IN" {{ old('address', $organization->address) == 'IN' ? 'selected' : '' }}>India</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>

                        <!-- Proof Image -->
                        <div class="col-md-6">
                            <label for="proof_image" class="form-label">Proof Image</label>
                            <input type="file" name="proof_image" class="form-control" id="proof_image">
                            @if ($organization->certificate_image)
                                <small>Current Proof: <a href="{{ asset('storage/certificate_images/' . $organization->certificate_image) }}" target="_blank">View Image</a></small>
                            @endif
                        </div>

                        <!-- Organization Image -->
                        <div class="col-md-6">
                            <label for="organization_image" class="form-label">Organization Image</label>
                            <input type="file" name="organization_image" class="form-control" id="organization_image">
                            @if ($organization->image->isNotEmpty())
                                <small>Current Image: <a href="{{ asset('storage/organization_images/' . $organization->image->first()->image) }}" target="_blank">View Image</a></small>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Organization</button>
                            <a href="{{ route('organization.manage_organization') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('language-selector').addEventListener('change', function () {
            const languageId = this.value;
            const container = document.getElementById('language-fields-container');

            Array.from(container.children).forEach(child => {
                child.style.display = child.id === `fields-${languageId}` ? 'block' : 'none';
            });
        });
    </script>
@endsection
