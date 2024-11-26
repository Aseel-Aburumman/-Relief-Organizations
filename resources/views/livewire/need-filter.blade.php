<div>
    <!-- Filter Form -->
    <div class="container my-4">
        <div class="row align-items-center mb-3">
            <!-- Search Bar -->
            <div class="col-md-9">
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="{{ __('messages.searchPlaceholder') }}"
                    class="form-control"
                />
            </div>

            <!-- Reset Button -->
            <div class="col-md-3 text-md-end">
                <button wire:click="resetFilters" class="btn btn-secondary w-100">
                    {{ __('messages.resetFilters') }}
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="row gy-3">
            <!-- Category Filter -->
            <div class="col-lg-4 col-md-6">
                <select wire:model.change="selectedCategory" class="form-select">
                    <option value="">{{ __('messages.selectCategory') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ __('messages.categories.' . strtolower(str_replace([' ', '(', ')', ','], '_', $category->name))) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Urgency Filter -->
            <div class="col-lg-4 col-md-6">
                <select wire:model.change="selectedUrgency" class="form-select">
                    <option value="">{{ __('messages.selectUrgency') }}</option>
                    @foreach ($urgencies as $urgency)
                        <option value="{{ $urgency }}">
                            {{ __('messages.urgency.' . strtolower(str_replace(' ', '_', $urgency))) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-lg-4 col-md-6">
                <select wire:model.change="selectedStatus" class="form-select">
                    <option value="">{{ __('messages.selectStatus') }}</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">
                            {{ __('messages.status.' . strtolower(str_replace(' ', '_', $status))) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Needs Display -->
    <div class="row mt-4">
        @forelse ($needs as $need)
            <div class="col-lg-4 col-md-6">
                <div class="single_cause">
                    <a href="{{ route('donation.show', $need->id) }}">
                        <div class="thumb">
                            @if ($need->image->isNotEmpty())
                                <img src="{{ asset('storage/need_images/' . $need->image->first()->image) }}" alt="">
                            @else
                                <img src="{{ asset('img/default-image.png') }}" alt="">
                            @endif
                        </div>
                    </a>
                    <div class="causes_content">
                        <h4>{{ $need->needDetail->first()->item_name ?? __('messages.noName') }}</h4>
                        <p>{{ Str::limit($need->needDetail->first()->description ?? __('messages.noDescription'), 75) }}</p>
                        <a class="read_more" href="{{ route('donation.show', $need->id) }}">{{ __('messages.readMore') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('messages.noNeedsFound') }}</p>
        @endforelse
    </div>
<!-- Pagination -->
<div class="mt-4">
    <nav>
        <ul class="pagination justify-content-center ">
            {{ $needs->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </nav>
</div>
