@php
    $images = json_decode($dataVilla->images_villa, true);
    $dets = json_decode($dataVilla->detail_villa, true); 
    $facils = json_decode($dataVilla->fasilitas_villa, true);
    $price = json_decode($dataVilla->price_villa, true);
    $nama_villa = $dataVilla->nama_villa;
    $kapasitas_villa = $dataVilla->kapasitas_villa;
    $deskripsi_villa = $dataVilla->deskripsi_villa;
    $kolam_villa = $dataVilla->kolam_villa;
@endphp

@extends('layouts.app')
@section('title', 'Detail ' . $nama_villa)
@section('content')
<div id="page-wrap">
    <section class="section-room-detail bg-white">
        <div class="container">
            <div class="room-detail">
                <div class="row">
                    <div class="col-lg-9">
                        <h2 style="margin-top: 100px;"><b>{{ $nama_villa }}</b></h2>

                        <div class="room-detail_img">
                            @foreach ($images as $index => $image)
                                <div class="room_img-item">
                                    <img src="{{ asset('images/' . $image['image']) }}" alt="">
                                </div>
                            @endforeach
                        </div>

                        <div class="room-detail_thumbs">
                            @foreach ($images as $index => $image)
                                <a href="#">
                                    <img src="{{ asset('images/' . $image['image']) }}" alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-3" style="margin-top:140px">
                        <div class="room-detail_book">
                            <div class="room-detail_total">
                                <img src="{{ asset('images/icon-logo.png') }}" alt="" class="icon-logo">
                                <h6 align="left">List Harga:</h6>

                                <p class="price">
                                    <span class="amout" align="left">Rp {{ number_format($price['minggu_kamis'], 0, ',', '.') }}</span> <h7>minggu s/d kamis</h7>
                                </p>
                                <br>
                                <p class="price">
                                    <span class="amout" align="left">Rp {{ number_format($price['jumat'], 0, ',', '.') }}</span> <h7>jum'at</h7>
                                </p>
                                <br>
                                <p class="price">
                                    <span class="amout" align="left">Rp {{ number_format($price['sabtu_weeekend'], 0, ',', '.') }}</span> <h7>sabtu & hari libur</h7>
                                </p>
                            </div>

                            <div class="room-detail_form">
                                <label for="checkin">Tanggal Checkin</label>
                                <input id="checkin" type="text" class="awe-calendar from" placeholder="Tanggal Checkin">
                                <label for="checkout">Tanggal Checkout</label>
                                <input id="checkout" type="text" class="awe-calendar to" placeholder="Tanggal Checkout">
                                <label for="guests">Jumlah Tamu</label>
                                <select id="guests" class="awe-select">
                                    <option selected disabled>Pilih Jumlah Orang</option>
                                    <option>10</option>
                                    <option>15</option>
                                    <option>20</option>
                                    <option>25</option>
                                    <option>30</option>
                                    <option>35</option>
                                    <option>50 ></option>
                                </select>
                                <small>Max {{ $kapasitas_villa }} Orang</small>
                                <button id="bookNowBtn" class="awe-btn awe-btn-13"><i class="fa-brands fa-whatsapp"></i> &nbsp;Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="room-detail_tab">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="room-detail_tab-header">
                            {{-- <li><a href="#overview" data-toggle="tab">OVERVIEW</a></li> --}}
                            <li class="active"><a href="#amenities" data-toggle="tab">FASILITAS</a></li>
                            <li><a href="#package" data-toggle="tab">PAKET LAINNYA</a></li>
                            {{-- <li><a href="#rates" data-toggle="tab">KALENDER</a></li> --}}
                            <li><a href="#calendar" data-toggle="tab">KALENDER VILLA</a></li>
                            <li><a href="#rates" data-toggle="tab">PERATURAN</a></li>
                        </ul>
                    </div>

                    <!-- NEW TAB -->
                    <div class="col-md-9">
                        <div class="room-detail_tab-content tab-content">

                            {{-- OVERVIEW --}}
                            <div class="tab-pane fade" id="overview">
                                <div class="room-detail_overview">
                                    <p>{{ $dataVilla->deskripsi }}</p>
                                </div>
                            </div>

                            {{-- AMENITIES --}}
                            <div class="tab-pane fade active in" id="amenities">
                                <div class="room-detail_amenities">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6">
                                            <h6>SPESIFIKASI VILLA</h6>
                                            <ul>
                                                <li>Kapasitas Max: {{ $dataVilla->kapasitas_villa }} Orang</li>
                                                <li>Kamar Tidur: {{ $dets['jumlah_kamar'] }} Kamar</li>
                                                <li>Tempat Tidur: {{ $dets['tempat_tidur'] }} Kasur</li>
                                                <li>Kamar Mandi: {{ $dets['kamar_mandi'] }} Kamar Mandi</li>
                                                <li>Parkir Mobil: {{ $dets['parkir_mobil'] }} Mobil</li>
                                                <li>Luas & Kedalaman Kolam: {{ $dataVilla->luas_kolam_villa }} M &nbsp; {{ $dataVilla->kedalaman_kolam }} M</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6 col-lg-4">
                                            <h6>Detail Fasilitas</h6>
                                            @php
                                                $facils_count = count($facils);
                                                $facils_per_column = 5;
                                                $column_count = ceil($facils_count / $facils_per_column);
                                                $current_facil_index = 0;
                                            @endphp

                                            @for ($i = 0; $i < $column_count; $i++)
                                                <ul>
                                                    @for ($j = 0; $j < $facils_per_column; $j++)
                                                        @if ($current_facil_index < $facils_count)
                                                            @php $fac = $facils[$current_facil_index]; @endphp
                                                            @if (!empty($fac['facility']))
                                                                <li>{{ $fac['facility'] }}</li>
                                                            @endif
                                                            @php $current_facil_index++; @endphp
                                                        @else
                                                            @break
                                                        @endif
                                                    @endfor
                                                </ul>
                                            @endfor
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-xs-12 col-lg-12"><h6>• Fasilitas Tambahan : {{ $dets['tambahan'] }}</h6></div>
                                    <div class="col-xs-12 col-lg-12"><h6>• Lokasi : {{ $dataVilla->deskripsi_villa }}</h6></div>
                                </div>
                            </div>

                            {{-- PACKAGE --}}
                            <div class="tab-pane fade" id="package">
                                <div class="room-detail_package">
                                    <div class="room-package_item">
                                        <div class="text">
                                            <h4><a href="#">Catering</a></h4>
                                            <p>Dapatkan Catering dengan harga yang sudah disertakan dengan berbagai macam menu yang sudah kami siapkan.</p>
                                        </div>
                                    </div>

                                    <div class="room-package_item">
                                        <div class="text">
                                            <h4><a href="#">Grill</a></h4>
                                            <p>Lengkapi liburan kalian dengan paket Grill yang sudah kami sediakan.</p>
                                        </div>
                                    </div>

                                    <div class="room-package_item">
                                        <div class="text">
                                            <h4><a href="#">Floaties</a></h4>
                                            <p>Bermain bersama Floaties untuk di kolam renang, ada berbagai macam bentuk floaties.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- RATES --}}
                            <div class="tab-pane fade" id="rates">
                                <div class="room-detail_amenities">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12">
                                            <h6>PERATURAN VILLA</h6>
                                            <ul>
                                                <li>Penanggung jawab penyewa villa Wajib memberikan KTP/KARTU IDENTITAS kepada staf villa.</li>
                                                <li>Anak di atas 7 tahun sudah terhitung 1 orang / pax.</li>
                                                <li>Lebih dari kapasitas max orang, akan dikenakan charge 50.000/org.</li>
                                                <li>Jam check out pukul 12:00, lewat akan dikenakan denda 500.000.</li>
                                                <li>Kerusakan atau kehilangan akan dikenakan ganti rugi sesuai harga barang + biaya pemasangan.</li>
                                                <li>Jam malam dari 23:00 (dilarang berisik).</li>
                                                <li>Dilarang merokok di dalam villa, jika dilanggar denda 1.000.000.</li>
                                                <li>Dilarang merubah posisi barang-barang villa, jika dilanggar denda 1.000.000.</li>
                                                <li>Dilarang buang sampah sembarangan, denda 200.000.</li>
                                                <li>Dilarang nyalakan hand flare, denda 1.000.000.</li>
                                                <li>Dilarang bawa hewan peliharaan.</li>
                                                <li>Force Majeure di luar tanggung jawab.</li>
                                                <li>Dilarang bawa catering luar, denda 5rb/pax.</li>
                                                <li>Kerusakan billiard dikenakan denda sesuai jenis kerusakan.</li>
                                                <li>Dilarang duduk/letakkan barang di meja billiard, denda 1.000.000.</li>
                                                <li>Villa berantakan berlebihan (muntahan/sampah) denda 500.000.</li>
                                                <li>Peraturan kolam: dilarang makan/sabun di kolam, denda 1.500.000.</li>
                                                <li>Villa dengan bus dikenakan charge 200rb–300rb sesuai wilayah.</li>
                                                <li>Manajemen tidak bertanggung jawab atas kehilangan properti.</li>
                                                <li>Dilarang gunakan villa untuk kegiatan melanggar hukum.</li>
                                                <br>
                                                <h6><b>* NOTED:</b> untuk villa tertentu ada peraturan tambahan yang wajib dipatuhi</h6>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CALENDAR --}}
                            <div class="tab-pane fade" id="calendar">
                                <div class="room-detail_calendar-wrap row">
                                    <div class="col-sm-12 text-center">
                                        <iframe class="disable-click scaled-iframe background-div1" style="width: 300px; height: 315px;" frameborder="0" 
                                            src="{{ url('User/calendar/' . base64_encode(json_encode($reserv))) }}">
                                        </iframe>
                                    </div>

                                    <div class="calendar_status text-center col-sm-12">
                                        <span>Belum Terisi</span>
                                        <span class="not-available">Terisi</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END TAB -->

            <!-- COMPARE ACCOMMODATION -->
            <div class="room-detail_compare">
                <h2 class="room-compare_title">REKOMENDASI VILLA</h2>

                <div class="room-compare_content">
                    <div class="row">
                        <!-- ITEM 1 -->
                        <div class="col-md-4" style="margin-top:50px">
                            <div class="room_item-1">
                                <h2>Villa Kamela</h2>

                                <div class="img">
                                    <a href="{{ url('/user/detail/1/villa-kamela') }}">
                                        <img src="{{ asset('images/kamela_1.png') }}" alt="">
                                    </a>
                                </div>

                                <div class="desc">
                                    <ul>
                                        <li>Kapasitas : 15</li>
                                        <li>Kamar Mandi : 1</li>
                                        <li>Kamar Tidur : 2</li>
                                        <li>Tempat Tidur : 3</li>
                                    </ul>
                                    <br>
                                    <p>Lokasi: Pasir Muncang, Cisarua</p>
                                </div>

                                <div class="bot">
                                    <a href="{{ url('user/detail/1') }}" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
                                </div>
                                <br>
                            </div>
                        </div>

                        <!-- ITEM 2 -->
                        <div class="col-md-4" style="margin-top:50px">
                            <div class="room_item-1">
                                <h2>Villa Kamela 2</h2>

                                <div class="img">
                                    <a href="{{ url('/user/detail/9/villa-kamela-2') }}">
                                        <img src="{{ asset('images/kamela2_1.png') }}" alt="">
                                    </a>
                                </div>

                                <div class="desc">
                                    <ul>
                                        <li>Kapasitas : 30</li>
                                        <li>Kamar Mandi : 5</li>
                                        <li>Kamar Tidur : 5</li>
                                        <li>Tempat Tidur : 7</li>
                                    </ul>
                                    <br>
                                    <p>Lokasi: Batulayang, Cisarua</p>
                                </div>

                                <div class="bot">
                                    <a href="{{ url('user/detail/2') }}" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
                                </div>
                                <br>
                            </div>
                        </div>

                        <!-- ITEM 3 -->
                        <div class="col-md-4" style="margin-top:50px">
                            <div class="room_item-1">
                                <h2>Villa Clover</h2>

                                <div class="img">
                                    <a href="{{ url('/user/detail/3/villa-demang') }}">
                                        <img src="{{ asset('images/clover1.png') }}" alt="">
                                    </a>
                                </div>

                                <div class="desc">
                                    <ul>
                                        <li>Kapasitas : 25</li>
                                        <li>Kamar Mandi : 4</li>
                                        <li>Kamar Tidur : 5</li>
                                        <li>Tempat Tidur : 5</li>
                                    </ul>
                                    <br>
                                    <p>Lokasi: Pasir Muncang, Alternatif Cisarua Bogor</p>
                                </div>

                                <div class="bot">
                                    <a href="{{ url('user/detail/3') }}" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END / COMPARE ACCOMMODATION -->
        </div>
    </section>
</div>

<script>
    document.getElementById("bookNowBtn").addEventListener("click", function () {
        var checkin = document.getElementById("checkin").value;
        var checkout = document.getElementById("checkout").value;
        var guests = document.getElementById("guests").value;
        var villaName = '{{ $nama_villa }}';

        if (checkin === "" || checkout === "" || guests === "") {
            alert("Mohon lengkapi data sebelum melanjutkan!");
            return;
        }

        var checkinParts = checkin.split("/");
        var formattedCheckin = checkinParts[1] + "/" + checkinParts[0] + "/" + checkinParts[2];

        var checkoutParts = checkout.split("/");
        var formattedCheckout = checkoutParts[1] + "/" + checkoutParts[0] + "/" + checkoutParts[2];

        var message = "Halo kak, saya ingin pesan villa.\n\n";
        message += "Nama Villa: " + villaName + "\n";
        message += "Check-in: " + formattedCheckin + "\n";
        message += "Check-out: " + formattedCheckout + "\n";
        message += "Jumlah tamu: " + guests + "\n\n";
        message += "Terima kasih";

        var whatsappLink = "https://wa.me/62895360610100?text=" + encodeURIComponent(message);
        window.open(whatsappLink, '_blank');
    });
</script>
@endsection
