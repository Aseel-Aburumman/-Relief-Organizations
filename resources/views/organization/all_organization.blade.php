@extends('layout.master')
@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>{{ __('messages.AllorganizationA') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <div class="popular_causes_area pt-120">
        <div class="container">
            <div class="row g-4 mb-5">
                @foreach ($organizations as $organization)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_cause"
                            style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                            <div class="thumb" style="height: 250px; overflow: hidden; position: relative;">
                                @if ($organization->image->isNotEmpty())
                                    <img src="{{ asset('storage/organization_images/' . $organization->image->first()->image) }}"
                                        alt="Organization Image" class="organization-img"
                                        style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <img src="{{ asset('img/default.jpg') }}" alt="Default Image" class="organization-img"
                                        style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @endif
                            </div>
                            <!-- القسم السفلي للنصوص -->
                            <div class="causes_content" style="padding: 20px; text-align: center; background-color: #fff;">
                                <h4 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                                    {{ $organization->userDetail->first()->name ?? 'No Name Available' }}</h4>
                                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
                                    {{ $organization->userDetail->first()->description ?? 'No Description Available' }}</p>
                                <a href="{{ route('organization.profile.one', ['id' => $organization->id]) }}"
                                    class="read_more">{{ __('messages.LearnMoreA') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
