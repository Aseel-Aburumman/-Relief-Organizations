@extends('layout.master')
@section('content')
<style>
    .help_content {
        height: 25vh;
        width: 35vh;
    }
</style>
<br><br><br>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="section_title text-center mb-55">
            <h3><span>{{ __('messages.AboutWebsite') }}</span></h3>
        </div>
    </div>
</div>
<!-- bradcam_area_end  -->
<div class="slider_area">
    <div class="single_slider d-flex align-items-center slider_bg_1 overlay2" style="background-image: url(../img/banner/banner2.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="slider_text">
                        <h3 style="font-size: 40px; text-align:center; margin-left:40%;">
                            {{ __('messages.WebsiteDescription') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
@endsection
