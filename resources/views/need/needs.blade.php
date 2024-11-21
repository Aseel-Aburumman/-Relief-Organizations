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


    <div class="container my-4">
        @livewire('need-filter')
    </div>


    <style>
        .single_cause {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 450px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .single_cause:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .single_cause .thumb {
            width: 100%;
            height: 300px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .single_cause .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .causes_content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            background-color: #fff;
            text-align: center;
        }

        .causes_content h4 {
            font-size: 18px;
            font-weight: 600;
            margin: 10px 0;
        }

        .causes_content p {
            flex-grow: 1;
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        .balance {
            font-size: 14px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .read_more {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .read_more:hover {
            color: #0056b3;
        }
    </style>
@endsection
