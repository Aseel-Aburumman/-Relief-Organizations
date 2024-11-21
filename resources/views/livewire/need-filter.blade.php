<div>
    <!-- Filter Form -->
    <div class="container my-4">
        <div class="row">
            <!-- Category Filter -->
            <div class="col-md-3">
                <select wire:model.change="selectedCategory" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Urgency Filter -->
            <div class="col-md-3">
                <select wire:model.change="selectedUrgency" class="form-control">
                    <option value="">Select Urgency</option>
                    @foreach ($urgencies as $urgency)
                        <option value="{{ $urgency }}">{{ ucfirst($urgency) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-md-3">
                <select wire:model.change="selectedStatus" class="form-control">
                    <option value="">Select Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
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
                        <h4>{{ $need->needDetail->first()->item_name ?? 'No Name' }}</h4>
                        <p>{{ Str::limit($need->needDetail->first()->description ?? 'No Description', 100) }}</p>
                        <a class="read_more" href="{{ route('donation.show', $need->id) }}">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No needs found!</p>
        @endforelse
    </div>
</div>
