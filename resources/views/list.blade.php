<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Villa</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/landing/tab.svg') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .awe-search {
            width: 50%;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd !important;
            border-radius: 10px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            display: block;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .awe-search:focus {
            border-color: #66afe9;
            outline: 0;
            box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
        }

        .room_item-1 .img img {
            width: 100%;
            height: auto;
        }

        @media (min-width: 768px) {
            .room_item-1 .img img {
                height: 300px;
            }
        }

        @media (max-width: 767px) {
            .room_item-1 .img img {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <div id="page-wrap">  
        <section class="section-room bg-white">
            <div class="container">
                <div class="title-section" style="margin-top:100px;">
                    <h2>List Villa</h2>
                    <p>Temukan Villa yang anda butuhkan dengan mudah dan cepat</p>
                </div>

                <section class="section-check-availability">
                    <form action="{{ route('user.filterVillas') }}" method="get">
                        <input type="text" name="check_in_date" class="awe-search" placeholder="Tanggal Checkin" value="{{ request('check_in_date') }}">
                        <input type="text" name="check_out_date" class="awe-search" placeholder="Tanggal Checkout" value="{{ request('check_out_date') }}">
                        <select name="kapasitas_villa" class="awe-search">
                            <option selected disabled>Kapasitas</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <button type="submit" class="awe-search">Cari Villa</button>
                    </form>
                </section>

                <section class="search-section">
                    <input type="text" id="search_villa" name="search_villa" class="awe-search" placeholder="Cari Nama Villa">
                </section>

                <section class="section-room bg-white">
                    <div class="room-wrap-1">
                        <div class="row">
                            @forelse($dataVilla as $villa)
                                @php
                                    $price = json_decode($villa->price_villa, true);
                                    $images = json_decode($villa->images_villa, true);
                                    $dets = json_decode($villa->detail_villa, true);
                                @endphp

                                <div class="col-md-6">
                                    <div class="room_item-1">
                                        <h2>{{ $villa->nama_villa }}</h2>
                                        <div class="img">
                                            <a href="{{ url('user/detail/' . $villa->villa_id . '/' . Str::slug($villa->nama_villa)) }}">
                                                <img src="{{ asset('images/' . $images[0]['image']) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="desc">
                                            <ul>
                                                <li>Kapasitas: {{ $villa->kapasitas_villa }}</li>
                                                <li>Kamar Mandi: {{ $dets['kamar_mandi'] }}</li>
                                                <li>Kamar Tidur: {{ $dets['jumlah_kamar'] }}</li>
                                                <li>Tempat Tidur: {{ $dets['tempat_tidur'] }}</li>
                                            </ul>
                                            <p>Lokasi: {{ $villa->deskripsi_villa }}</p>
                                        </div>
                                        <div class="bot">
                                            <span class="price">Mulai dari <span class="amout">{{ number_format($price['minggu_kamis'], 2, ',', '.') }}</span> /malam</span>
                                            <a href="{{ url('user/detail/' . $villa->villa_id . '/' . Str::slug($villa->nama_villa)) }}" class="awe-search">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Villa tidak ditemukan.</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
@endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search_villa');
            const villaItems = document.querySelectorAll('.room_item-1');

            searchInput.addEventListener('keyup', function() {
                const searchQuery = searchInput.value.toLowerCase();

                villaItems.forEach(function(item) {
                    const villaName = item.querySelector('h2').textContent.toLowerCase();
                    item.style.display = villaName.includes(searchQuery) ? 'block' : 'none';
                });
            });
        });
    </script>
</body>
</html>
