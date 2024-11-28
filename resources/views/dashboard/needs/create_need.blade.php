@extends('layout.admin_master')

@section('content')
    <div class="pagetitle">
        <h1>{{ __('messages.CreateNeed') }}
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">{{ __('messages.Home') }}
                    </a></li>
                <li class="breadcrumb-item">{{ __('messages.NeedControlCenter') }}
                </li>
                <li class="breadcrumb-item active">{{ __('messages.CreateNeed') }}
                </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.NewNeedInformation') }}
                    </h5>

                    <form class="row g-3" method="POST" action="{{ route('organization.store_need') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @role('organization')
                            <input type="hidden" name="organization_id" value="{{ $organization->id }}">
                        @endrole
                        @role('admin')
                            <div class="col-md-6">
                                <label for="organization_id" class="form-label">{{ __('messages.Selectorganization') }}
                                </label>
                                <select id="language-organization_id" name="organization_id" class="form-control">
                                    <option value="">{{ __('messages.Selectorganization') }}
                                    </option>
                                    @foreach ($organization as $organization1)
                                        <option value="{{ $organization1->id }}">{{ $organization1->userDetail->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endrole


                        <div class="col-md-6">
                            <label for="language" class="form-label">{{ __('messages.SelectLanguage') }}
                            </label>
                            <select id="language-selector" class="form-control">
                                <option value="">{{ __('messages.SelectLanguage') }} </option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->key }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="language-fields-container">
                            <!-- Dynamically generated fields will be added here -->
                        </div>

                        <div class="col-md-6">
                            <label for="inputQuantity" class="form-label">{{ __('messages.QuantityNeeded') }}
                            </label>
                            <input type="number" name="quantity_needed" class="form-control" id="inputQuantity"
                                value="{{ old('quantity_needed') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">{{ __('messages.Category') }}
                            </label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputUrgency" class="form-label">{{ __('messages.UrgencyLevel') }}
                            </label>
                            <select name="urgency" class="form-control" id="inputUrgency">
                                <option value="Low Priority">{{ __('messages.LowPriorityA') }}
                                </option>
                                <option value="Medium Priority">{{ __('messages.MediumPriorityA') }}
                                </option>
                                <option value="High Priority">{{ __('messages.HighPriorityA') }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputStatus" class="form-label">{{ __('messages.Status') }}
                            </label>
                            <select name="status" class="form-control" id="inputStatus">
                                <option value="Available">{{ __('messages.AvailableA') }}
                                </option>
                                <option value="Partially Fulfilled">{{ __('messages.PartiallyFulfilledA') }}
                                </option>
                                <option value="Fulfilled">{{ __('messages.FulfilledA') }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputImage" class="form-label">{{ __('messages.Image') }}
                            </label>
                            <input type="file" name="image" class="form-control" id="inputImage">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.CreateNeed') }}
                            </button>
                            <button type="reset" class="btn btn-secondary">{{ __('messages.Reset') }}
                            </button>
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
                <label for="item_name_${language}" class="form-label">{{ __('messages.NeedName') }}
 (${language.toUpperCase()})</label>
                <input type="text" name="item_name[${language}]" class="form-control" id="item_name_${language}">
            </div>
            <div class="col-md-12">
                <label for="description_${language}" class="form-label">{{ __('messages.Description') }}
 (${language.toUpperCase()})</label>
                <textarea name="description[${language}]" class="form-control" id="description_${language}"></textarea>
            </div>
        `;
            container.appendChild(fields);
        });
    </script>
@endsection
