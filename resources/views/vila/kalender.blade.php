@extends('layout.master')

@section('content')
<div class="container-fluid">
    @foreach($vgadata as $vga)
        @php
            $images = json_decode($vga['image'], true);
            $image = isset($images[0]['image']) ? asset('images/' . $images[0]['image']) : asset('sampel.jpg');
        @endphp

        <div class="card bg-dark text-white mb-4">
            <div class="position-relative">
                <img src="{{ $image }}" class="card-img" alt="Villa Image" style="height: 500px; object-fit: cover; opacity: 0.3;">
                
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Kalender di kiri -->
                            <div class="col-md-6 d-flex justify-content-center mb-4 mb-md-0">
                                <iframe class="disable-click" style="width: 300px; height: 292px;" frameborder="0"
                                    src="{{ route('calendar.show', base64_encode(json_encode($vga['reserv']))) }}">
                                </iframe>
                            </div>

                            <!-- Teks di kanan -->
                            <div class="col-md-6 text-white">
                                <h2 class="text-shadow">Kalender {{ $vga['nama'] }}</h2>
                                <p class="text-shadow">
                                    Kap. Max {{ $vga['detail']['orang'] }} Orang |
                                    {{ $vga['detail']['kamar'] }} Kamar Tidur |
                                    {{ $vga['detail']['bed'] }} Bed |
                                    {{ $vga['detail']['bath'] }} Kamar Mandi |
                                    {{ $vga['detail']['park'] }} Parkir Mobil
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</div>
@stop


@section('css')
<style>
.text-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}
</style>
@stop

@section('js')
<!-- No custom JS needed yet -->
@stop
