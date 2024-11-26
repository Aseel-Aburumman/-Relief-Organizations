@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        {{-- Display success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            @role('organization')
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body  pt-4 d-flex flex-column align-items-center">

                            <img src="{{ asset('storage/organization_images/' . $user->organization->image->first()->image) }}"
                                alt="Profile" class="" style="height:300px; width:300px;">

                            <h2>{{ $user->name }}</h2>
                            {{--  <h3>{{ $user->roles->name }}</h3>  --}}
                        </div>
                    </div>
                </div>
            @endrole

            @role('organization')
                <div class="col-xl-8">
                @endrole
                @role('doner')
                    <div class="col-xl-12">
                    @endrole
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                <!-- Overview Section -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>
                                    @role('doner')
                                        @foreach ($userDetail as $detail)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Full Name
                                                    ({{ $detail->language_id == 1 ? 'en' : 'ar' }})
                                                </div>
                                                <div class="col-lg-9 col-md-8">{{ $detail->name }}</div>
                                            </div>
                                        @endforeach
                                    @endrole
                                    @role('organization')
                                        @foreach ($organizationDetail as $detail)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">organization Name
                                                    ({{ $detail->language_id == 1 ? 'en' : 'ar' }})
                                                </div>
                                                <div class="col-lg-9 col-md-8">{{ $detail->name }}</div>
                                            </div>
                                        @endforeach

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Contact Info</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->organization->contact_info }}</div>
                                        </div>
                                    @endrole

                                    @role('organization')
                                        @foreach ($organizationDetail as $detail)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Description
                                                    ({{ $detail->language_id == 1 ? 'en' : 'ar' }})
                                                </div>
                                                <div class="col-lg-9 col-md-8">{{ $detail->description ?? 'N/A' }}</div>
                                            </div>
                                        @endforeach

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">status</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->organization->status ?? 'N/A' }}</div>
                                        </div>
                                    @endrole
                                    @foreach ($userDetail as $detail)
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Address</div>
                                            <div class="col-lg-9 col-md-8">{{ $detail->address ?? 'N/A' }}</div>
                                        </div>
                                    @endforeach

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                    </div>
                                </div>

                                <!-- Edit Profile Section -->
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form action="{{ route('profile.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Language Selector -->
                                        <div class="col-md-6">
                                            <label for="language" class="form-label">Select Language</label>
                                            <select id="language-selector" class="form-control">
                                                <option value="">Select a language</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->key }}">{{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Dynamic Fields Container -->
                                        <div id="language-fields-container">
                                            @foreach ($userDetail as $detail)
                                                <div class="col-md-12" id="fields-{{ $detail->language->key }}">
                                                    <label for="name_{{ $detail->language->key }}" class="form-label">
                                                        Name ({{ strtoupper($detail->language->key) }})
                                                    </label>
                                                    <input type="text" name="name[{{ $detail->language->key }}]"
                                                        class="form-control" id="name_{{ $detail->language->key }}"
                                                        value="{{ $detail->name }}">

                                                    @if ($user->hasRole('organization'))
                                                        @foreach ($organizationDetail as $detail)
                                                            <label for="description_{{ $detail->language->key }}"
                                                                class="form-label">
                                                                Description ({{ strtoupper($detail->language->key) }})
                                                            </label>
                                                            <textarea name="description[{{ $detail->language->key }}]" class="form-control"
                                                                id="description_{{ $detail->language->key }}">{{ $detail->description }}</textarea>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Email Field -->
                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="email"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                        </div>

                                        <!-- password Field -->
                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-lg-3 col-form-label">new
                                                password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control" id="password"
                                                    value="{{ $user->password }}" required>
                                            </div>
                                        </div>

                                        <!-- Contact Info (for organizations) -->
                                        @role('organization')
                                            <div class="row mb-3">
                                                <label for="contact_info" class="col-md-4 col-lg-3 col-form-label">Contact
                                                    Info</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="contact_info" type="text" class="form-control"
                                                        id="contact_info" value="{{ $user->organization->contact_info }}">
                                                </div>
                                            </div>
                                        @endrole

                                        <!-- Address Field -->
                                        <div class="row mb-3">
                                            <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select class="form-select" id="address" name="address" required>
                                                    <option value="{{ $userDetail[0]->address ?? '' }}" disabled selected>
                                                        Select your country</option>
                                                    @foreach ($countries as $code => $country)
                                                        <option value="{{ $country['name'] }}">{{ $country['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{--  <input name="address" type="text" class="form-control" id="address"
                                                    value="{{ $userDetail[0]->address ?? '' }}">  --}}
                                            </div>
                                        </div>

                                        <!-- Profile Picture Upload -->
                                        @role('organization')
                                            <div class="row mb-3">
                                                <label for="image" class="col-md-4 col-lg-3 col-form-label">Profile
                                                    Picture</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="file" name="image" class="form-control"
                                                        id="image">
                                                </div>
                                            </div>
                                        @endrole

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>


                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('language-selector').addEventListener('change', function() {
                    const language = this.value;
                    const container = document.getElementById('language-fields-container');

                    if (!language) {
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
                <label for="name_${language}" class="form-label">Name (${language.toUpperCase()})</label>
                <input type="text" name="name[${language}]" class="form-control" id="name_${language}">
            </div>
            @if ($user->hasRole('organization'))
                <div class="col-md-12">
                    <label for="description_${language}" class="form-label">Description (${language.toUpperCase()})</label>
                    <textarea name="description[${language}]" class="form-control" id="description_${language}"></textarea>
                </div>
            @endif
        `;
                    container.appendChild(fields);
                });
            </script>
    </section>
@endsection