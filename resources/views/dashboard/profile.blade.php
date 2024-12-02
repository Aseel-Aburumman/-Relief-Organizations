@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.Profile') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">{{ __('messages.Profile') }} </li>
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
                                        data-bs-target="#profile-overview">{{ __('messages.Overview') }}</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-edit">{{ __('messages.EditProfile') }}</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                <!-- Overview Section -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">{{ __('messages.ProfileDetails') }}</h5>
                                    @role('doner')
                                        @foreach ($userDetail as $detail)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">{{ __('messages.FullName') }}
                                                    ({{ $detail->language_id == 1 ? 'en' : 'ar' }})
                                                </div>
                                                <div class="col-lg-9 col-md-8">{{ $detail->name }}</div>
                                            </div>
                                        @endforeach
                                    @endrole
                                    @role('organization')
                                        @foreach ($organizationDetail as $detail)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">{{ __('messages.OrganizationNameA') }}
                                                    ({{ $detail->language_id == 1 ? 'en' : 'ar' }})
                                                </div>
                                                <div class="col-lg-9 col-md-8">{{ $detail->name }}</div>
                                            </div>
                                        @endforeach

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">{{ __('messages.ContactInformation') }}
                                            </div>
                                            <div class="col-lg-9 col-md-8">{{ $user->organization->contact_info }}</div>
                                        </div>
                                    @endrole

                                    @role('organization')
                                        @foreach ($organizationDetail as $detail)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">{{ __('messages.Description') }}
                                                    ({{ $detail->language_id == 1 ? 'en' : 'ar' }})
                                                </div>
                                                <div class="col-lg-9 col-md-8">{{ $detail->description ?? 'N/A' }}</div>
                                            </div>
                                        @endforeach

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">{{ __('messages.Status') }}</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->organization->status ?? 'N/A' }}</div>
                                        </div>
                                    @endrole
                                    @foreach ($userDetail as $detail)
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">{{ __('messages.AddressA') }}
                                            </div>
                                            <div class="col-lg-9 col-md-8">{{ $detail->address ?? 'N/A' }}</div>
                                        </div>
                                    @endforeach

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">{{ __('messages.EmailA') }}</div>
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
                                        <div class="row mb-3 mt-3">
                                            <label for="language"
                                                class="col-md-4 col-lg-3 col-form-label">{{ __('messages.SelectLanguage') }}
                                            </label>
                                            <div class="col-md-8 col-lg-9">

                                                <select id="language-selector" class="form-control">
                                                    <option value="">{{ __('messages.SelectLanguage') }}
                                                    </option>
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->key }}">{{ $language->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <!-- Dynamic Fields Container -->
                                        <div id="language-fields-container">
                                            @foreach ($userDetail as $detail)
                                                <div class="row mb-3 mt-3" id="fields-{{ $detail->language->key }}">
                                                    <label for="name_{{ $detail->language->key }}"
                                                        class="col-md-4 col-lg-3 col-form-label">
                                                        {{ __('messages.Name') }}
                                                        ({{ strtoupper($detail->language->key) }})
                                                    </label>
                                                    <div class="col-md-8 col-lg-9">

                                                        <input type="text" name="name[{{ $detail->language->key }}]"
                                                            class="form-control" id="name_{{ $detail->language->key }}"
                                                            value="{{ $detail->name }}">
                                                    </div>

                                                    @if ($user->hasRole('organization'))
                                                        @foreach ($organizationDetail as $detail)
                                                            <label for="description_{{ $detail->language->key }}"
                                                                class="col-md-4 col-lg-3 col-form-label">
                                                                {{ __('messages.Description') }}
                                                                ({{ strtoupper($detail->language->key) }})
                                                            </label>
                                                            <div class="col-md-8 col-lg-9">

                                                                <textarea name="description[{{ $detail->language->key }}]" class="form-control"
                                                                    id="description_{{ $detail->language->key }}">{{ $detail->description }}</textarea>

                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Email Field -->
                                        <div class="row mb-3 mt-3">
                                            <label for="email"
                                                class="col-md-4 col-lg-3 col-form-label">{{ __('messages.EmailA') }}</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="email"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                        </div>

                                        <!-- password Field -->
                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-lg-3 col-form-label">new
                                                {{ __('messages.PasswordA') }}</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control" id="password"
                                                    value="{{ $user->password }}" required>
                                            </div>
                                        </div>

                                        <!-- Contact Info (for organizations) -->
                                        @role('organization')
                                            <div class="row mb-3">
                                                <label for="contact_info"
                                                    class="col-md-4 col-lg-3 col-form-label">{{ __('messages.ContactInformation') }}
                                                </label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="contact_info" type="text" class="form-control"
                                                        id="contact_info" value="{{ $user->organization->contact_info }}">
                                                </div>
                                            </div>
                                        @endrole

                                        <!-- Address Field -->
                                        <div class="row mb-3">
                                            <label for="address"
                                                class="col-md-4 col-lg-3 col-form-label">{{ __('messages.AddressA') }}</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select class="form-select" id="address" name="address" required>
                                                    <option value="{{ $userDetail[0]->address ?? '' }}" disabled selected>
                                                        {{ __('messages.Selectcountry') }} </option>
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
                                                <label for="image"
                                                    class="col-md-4 col-lg-3 col-form-label">{{ __('messages.ProfilePicture') }}</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="file" name="image" class="form-control"
                                                        id="image">
                                                </div>
                                            </div>
                                        @endrole

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('messages.SaveChanges') }}</button>
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
                <label for="name_${language}" class="form-label">{{ __('messages.Name') }} (${language.toUpperCase()})</label>
                <input type="text" name="name[${language}]" class="form-control" id="name_${language}">
            </div>
            @if ($user->hasRole('organization'))
                <div class="col-md-12">
                    <label for="description_${language}" class="form-label">{{ __('messages.Description') }} (${language.toUpperCase()})</label>
                    <textarea name="description[${language}]" class="form-control" id="description_${language}"></textarea>
                </div>
            @endif
        `;
                    container.appendChild(fields);
                });
            </script>
    </section>
@endsection
