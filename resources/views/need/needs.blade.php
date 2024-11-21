@extends('layout.master')
@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Needs</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end -->

    <!-- Filter Form -->
    <div class="container my-4">
        <form action="{{ route('need') }}" method="GET" class="row">
            <!-- Category Filter -->
            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Urgency Filter -->
            <div class="col-md-3">
                <select name="urgency" class="form-control">
                    <option value="">Select Urgency</option>
                    @foreach ($urgencies as $urgency)
                        <option value="{{ $urgency }}" {{ request('urgency') == $urgency ? 'selected' : '' }}>
                            {{ ucfirst($urgency) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100" >Filter</button>
            </div>
        </form>
    </div>

    <!-- popular_causes_area_start -->
    <div class="popular_causes_area pt-120">
        <div class="container">
            <div class="row g-4">
                @forelse ($needs as $need)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_cause">
                            <div class="thumb">
                                @if ($need->image->isNotEmpty())
                                    <img src="{{ asset('storage/need_images/' . $need->image->first()->image) }}" alt="{{ $need->item_name }}" style="width: 100%; height: auto;">
                                @else
                                    <img src="{{ asset('img/default-image.png') }}" alt="{{ $need->item_name }}" style="width: 100%; height: auto;">
                                @endif
                            </div>

                            <div class="causes_content">
                                <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ ($need->donated_quantity / max($need->quantity_needed, 1)) * 100 }}%;"
                                             aria-valuenow="{{ $need->donated_quantity }}"
                                             aria-valuemin="0"
                                             aria-valuemax="{{ $need->quantity_needed }}">
                                            <span class="progres_count">
                                                {{ round(($need->donated_quantity / max($need->quantity_needed, 1)) * 100) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center">
                                    <span>Raised: ${{ $need->donated_quantity }}</span>
                                    <span>Goal: ${{ $need->quantity_needed }}</span>
                                </div>
                                <a href="#"><h4>{{ $need->item_name }}</h4></a>
                                <p>{{ Str::limit($need->description, 100) }}</p>
                                <a class="read_more" href="{{ route('need.show', $need->id) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No needs found. Please adjust your filters.</p>
                @endforelse
            </div>
            <div class="pagination">
                {{ $needs->links() }}
            </div>
        </div>
    </div>
    <!-- popular_causes_area_end -->
<style>

/* line 166, ../../Arafath/CL/january 2020/242. charity/HTML/scss/_blog_part.scss */
.blog_part .single-home-blog .card ul li span {
  margin-right: 10px;
  font-size: 12px;
}

/*# sourceMappingURL=style.css.map */
.single_cause {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Ensures cards are the same height */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px; /* Increased space between rows */
}

.row > .col-lg-4, .row > .col-md-6 {
    margin-bottom: 20px; /* Additional spacing for row */
}
.single_cause .thumb {
    width: 100%; /* Ensure the container spans the full width of the card */
    height: 200px; /* Set a fixed height for the image container */
    overflow: hidden; /* Crop any overflowing part of the image */
    display: flex; /* Center-align image */
    justify-content: center;
    align-items: center;
}

.single_cause .thumb img {
    width: 100%; /* Make the image fill the width of the container */
    height: 100%; /* Make the image fill the height of the container */
    object-fit: cover; /* Maintain aspect ratio while covering the container */
}

.causes_content {
    flex: 1; /* Makes content fill the remaining space */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 15px; /* Add padding for better spacing */
}

.causes_content a h4 {
    margin-top: 10px;
    font-size: 18px;
    text-align: center;
}

.causes_content .balance {
    margin: 10px 0;
}

.causes_content p {
    flex-grow: 1; /* Push the read more link to the bottom */
    margin-bottom: 10px;
}

.read_more {
    align-self: center;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}

.read_more:hover {
    color: #0056b3;
}

</style>
@endsection
