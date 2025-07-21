@extends('layout.master')

@section('content')
<div class="container-fluid">
    @foreach($vgadata as $vga)
        @php
            $images = json_decode($vga['image'], true);
            $image = isset($images[0]['image']) ? asset('images/' . $images[0]['image']) : asset('sampel.jpg');
            $detail = is_string($vga['detail']) ? json_decode($vga['detail'], true) : $vga['detail'];
        @endphp


        <div class="card shadow-lg border-0 mb-5">
            <div class="position-relative">
                <img src="{{ $image }}" class="card-img-top" alt="Villa Image" style="height: 450px; object-fit: cover; filter: brightness(60%);">
                
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center text-white">
                            <!-- Kalender -->
                            <div class="col-lg-5 d-flex justify-content-center mb-4 mb-lg-0">
                                <div class="bg-light rounded p-2 shadow-sm">
                                    <iframe class="disable-click rounded" style="width: 300px; height: 292px; border: none;"
                                        src="{{ route('calendar.show', base64_encode(json_encode($vga['reserv']))) }}">
                                    </iframe>
                                </div>
                            </div>

                            <!-- Info Vila -->
                            <div class="col-lg-7">
                                <h2 class="font-weight-bold text-white text-shadow mb-3">{{ $vga['nama'] }}</h2>
                                    <p class="lead text-shadow mb-0">
                                        Kap. Max <strong>{{ $detail['orang'] ?? '-' }}</strong> Orang |
                                        {{ $detail['kamar'] ?? '-' }} Kamar Tidur |
                                        {{ $detail['bed'] ?? '-' }} Bed |
                                        {{ $detail['bath'] ?? '-' }} Kamar Mandi |
                                        {{ $detail['park'] ?? '-' }} Parkir Mobil
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</div>
@endsection

@section('css')
<style>
    .text-shadow {
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
    }
    iframe.disable-click {
        pointer-events: none;
    }
</style>
@endsection

@section('js')
<!-- No custom JS yet -->
@endsection
