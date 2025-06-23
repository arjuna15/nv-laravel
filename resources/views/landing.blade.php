<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngevillayuk</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/landing/logo1pm.svg') }}"/>

    <link href="https://fonts.googleapis.com/css2?family=Neuton:ital,wght@0,200;0,300;0,400;0,700;0,800;1,400&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cal+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        .text-shadow {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }

        .check-availability-slider {
            background: rgba(255, 255, 255, 0.6);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .bootstrap-select.btn-group.awe-select .dropdown-toggle .caret {
            color: #000 !important;
        }

        .bootstrap-select.btn-group.awe-select {
            width: auto !important;
            border-radius: 10px !important;
        }

        .bootstrap-select.btn-group.awe-select .dropdown-toggle {
            width: 96% !important;
            border-radius: 10px !important;
            border: 2px solid #000 !important;
        }

        .check-availability-slider form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .check-availability-slider input,
        .check-availability-slider select {
            padding: 10px;
            border-radius: 10px;
            border: none;
            flex: 1 1 150px;
            min-width: 120px;
            max-width: 200px;
            box-sizing: border-box;
        }

        .vailability-submit {
            flex: 1 1 100%;
            text-align: center;
            margin-top: 10px;
        }

        .vailability-submit button {
            background-color: #ddd !important;
            color: #000 !important;
            padding: 10px 20px;
            border-radius: 5px;
            border: 2px solid #1b1b1b;
        }

        input::placeholder {
            color: #1b1b1b !important;
            opacity: 1;
        }

        input:-ms-input-placeholder {
            color: #1b1b1b;
        }

        input::-ms-input-placeholder {
            color: #1b1b1b;
        }

        .awe-calendar-wrapper i {
            color: #1b1b1b !important;
        }

        @media (max-width: 600px) {
            .check-availability-slider {
                display: inline-table;
                padding: 15px;
                max-width: 100px;
            }

            .tp-caption h1 {
                margin-top: 10px;
                font-size: 18px !important;
            }

            .check-availability-slider form {
                flex-direction: column;
                align-items: stretch;
            }

            .awe-calendar-wrapper {
                display: inline !important;
            }

            .awe-calendar-wrapper .awe-calendar {
                width: 30% !important;
            }

            .bootstrap-select.btn-group.awe-select .dropdown-toggle {
                margin-bottom: 6px;
            }

            .awe-calendar-wrapper i {
                top: 20% !important;
            }

            .check-availability-slider input,
            .check-availability-slider select,
            .vailability-submit button {
                max-width: 50%;
                width: 20% !important;
                font-size: 9px;
            }
        }

        @media only screen and (min-width: 1024px) {
            .slider-caption-sub.slider-caption-1 {
                font-size: 50px;
            }

            .slider-caption-sub-1 {
                font-size: 25px !important;
            }

            .slider-caption-sub.slider-caption-3 {
                font-size: 25px !important;
            }

            .slider-caption-sub-3 {
                font-size: 40px !important;
            }

            .awe-btn-slider {
                font-size: 20px;
                margin-top: 100px;
                border-width: 3px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 1023px) {
            .slider-caption-sub.slider-caption-1 {
                font-size: 50px !important;
            }

            .slider-caption-sub-1 {
                font-size: 25px !important;
            }

            .slider-caption-sub.slider-caption-3 {
                font-size: 50px !important;
            }

            .slider-caption-sub-3 {
                font-size: 25px !important;
            }

            .awe-btn-slider {
                font-size: 18px;
                margin-top: 80px;
                border-width: 1px;
            }
        }

        @media only screen and (max-width: 767px) {
            .slider-caption-sub.slider-caption-1 {
                font-size: 28px !important;
            }

            .slider-caption-sub-1 {
                font-size: 8px !important;
            }

            .slider-caption-sub.slider-caption-3 {
                font-size: 25px !important;
            }

            .slider-caption-sub-3 {
                font-size: 10px !important;
            }

            .awe-btn-slider {
                font-size: 30px !important;
                border-width: 1px !important;
            }
        }

        @media only screen and (max-width: 600px) {
            .tp-caption.slider-caption-sub-1 {
                font-size: 15px !important;
            }

            .tp-caption.slider-caption-sub-3 {
                font-size: 15px !important;
            }

            .awe-btn-slider {
                font-size: 5px !important;
                margin-top: 80px;
                border-width: 1px !important;
            }
        }

        .slider-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .slider-style-2 .tp-caption {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <div id="page-wrap" class="bg-white-2">
        <section class="section-slider slider-style-2 clearfix">
            <h1 class="element-invisible"></h1>
            <div id="slider-revolution">
                <ul>
                    <li data-transition="fade">
                        <section class="section-check-availability">
                            <div class="check-availibility">
                                <div class="tp-caption sfb fadeout check-availability-slider"
                                     data-x="center" data-y="380"
                                     data-speed="700" data-start="1500" data-easing="easeOutBack">
                                    <h1 style="color:#1b1b1b; font-size: 28px; font-family: 'Cal Sans';">CEK KETERSEDIAAN</h1>
                                    <form action="{{ route('filterVillas') }}" method="get">
                                        <div class="availability-form" style="margin-top:20px">
                                            <input style="border:2px solid #1b1b1b; color:#1b1b1b;" type="text" name="check_in_date" class="awe-calendar from" placeholder="Cekin" value="{{ request('check_in_date') }}">
                                            <input style="border:2px solid #1b1b1b; color:#1b1b1b;" type="text" name="check_out_date" class="awe-calendar to" placeholder="Cekout" value="{{ request('check_out_date') }}">
                                            <select class="awe-select" name="kapasitas_villa" style="width:50px !important;">
                                                <option value="Kapasitas" {{ request('kapasitas_villa') == 'Kapasitas' ? 'selected' : '' }}>Kapasitas</option>
                                                @foreach ($kapasitas as $k)
                                                    <option value="{{ $k->kapasitas_villa }}" {{ request('kapasitas_villa') == $k->kapasitas_villa ? 'selected' : '' }}>
                                                        {{ $k->kapasitas_villa }} Orang
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <div class="vailability-submit" style="margin-top:20px">
                                                <button class="awe-btn awe-btn-13" style="border:2px solid #1b1b1b">SEARCH</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                        <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <source src="{{ asset('assets/images/landing/dronelagi.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.3)); pointer-events: none; border-radius: 12px;"></div>
                        <div class="slider-overlay"></div>

                        <div class="tp-caption sfb fadeout slider-caption slider-caption-sub-1 text-shadow" data-x="center" data-y="150"
                             data-speed="700" data-start="1500" data-easing="easeOutBack" style="font-family: 'Raleway'; font-style:italic;">
                            NGEVILLAYUK
                        </div>
                        <div class="tp-caption sft fadeout slider-caption-sub slider-caption-1 text-shadow" data-x="center" data-y="230"
                             data-speed="700" data-start="1500" data-easing="easeOutBack" style="font-family: 'Cal Sans'; text-transform: capitalize">
                            Keep Calm and Stay at Our Villa
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section class="section-deals">
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col col-xs-12 col-lg-6 col-lg-offset-3">
                            <div class="ot-heading row-20 mb30 text-center mt90">
                                <h2>Deals & PACKAGE</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="item item-deal">
                                <div class="img">
                                    <img class="img-full" src="{{ asset('assets/images/landing/catering1.jpg') }}" alt="Catering">
                                </div>
                                <div class="info">
                                    <a class="title bold f26 font-monserat upper" href="#!">Catering</a>
                                    <p class="text-shadow">Dapatkan Catering dengan harga yang sudah disertakan dengan <br> berbagai macam menu yang sudah kami siapkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="item item-deal">
                                <div class="img">
                                    <img class="img-full" src="{{ asset('assets/images/landing/grill.jpg') }}" alt="Grill">
                                </div>
                                <div class="info">
                                    <a class="title bold f26 font-monserat upper" href="#!">Grill</a>
                                    <p class="text-shadow">Lengkapi liburan kalian dengan paket Grill yang sudah kami sediakan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="item item-deal">
                                <div class="img">
                                    <img class="img-full" src="{{ asset('assets/images/landing/image.jpg') }}" alt="Floaties">
                                </div>
                                <div class="info">
                                    <a class="title bold f26 font-monserat upper" href="#!">Floaties</a>
                                    <p class="text-shadow">Bermain bersama Floaties untuk di kolam renang, ada berbagai macam bentuk floaties.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

</body>
</html>
