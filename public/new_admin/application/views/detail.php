<?php 
    $images = json_decode($dataVilla->images_villa, true);
    $dets = json_decode($dataVilla->detail_villa, true); 
    $facils = json_decode($dataVilla->fasilitas_villa, true);
    $price = json_decode($dataVilla->price_villa, true);
    $nama_villa = json_decode($dataVilla->nama_villa, true);
    $kapasitas_villa = json_decode($dataVilla->kapasitas_villa, true);
    $deskripsi_villa = json_decode($dataVilla->deskripsi_villa, true);
    ?>
<!DOCTYPE html>
<html lang="en">
    <title>Detail <?php echo $dataVilla->nama_villa?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/landing/logo1pm.svg');?>"/>

<!-- PRELOADER -->
<div id="preloader">
    <span class="preloader-dot"></span>
</div>
<!-- END / PRELOADER -->

    <!-- PAGE WRAP -->
    <div id="page-wrap">
        <!-- ROOM DETAIL -->
        <section class="section-room-detail bg-white">
            <div class="container">
                
                <!-- DETAIL -->
                <div class="room-detail">
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 style="margin-top: 100px;"><b><?php echo $dataVilla->nama_villa?></b></h2>
                            
                            <!-- LAGER IMGAE -->
                            <div class="room-detail_img">
                            <?php foreach ($images as $index => $image) : ?>
                                <div class="room_img-item">
                                    <img src="<?php echo base_url().'images/'.$image['image']; ?>" alt="">
                                    <?php if ($index > 0) : ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <!-- END / LAGER IMGAE -->
                            
                            <!-- THUMBNAIL IMAGE -->
                            <div class="room-detail_thumbs">
                                <?php foreach ($images as $index => $image) : ?>
                                    <a href="#">
                                        <img src="<?php echo base_url().'images/'.$image['image']; ?>" alt="">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <!-- END / THUMBNAIL IMAGE -->

                        </div>

                        <div class="col-lg-3" style="margin-top:140px">

                            <!-- FORM BOOK -->
                            <div class="room-detail_book">

                                <div class="room-detail_total">
                                    <img src="images/icon-logo.png" alt="" class="icon-logo">
                                    
                                    <h6 align="left">List Harga:</h6>
                                    
                                    <p class="price">
                                        <span class="amout" align="left">Rp <?php echo number_format($price['minggu_kamis'],0,',','.')?></span> <h7>minggu s/d kamis</h7>
                                    </p>
                                    <br>
                                    <p class="price">
                                        <span class="amout" align="left">Rp <?php echo number_format($price['jumat'],0,',','.')?></span> <h7>jum'at</h7>
                                    </p>
                                    <br>
                                    <p class="price">
                                        <span class="amout" align="left">Rp <?php echo number_format($price['sabtu_weeekend'],0,',','.')?></span> <h7>sabtu & hari libur</h7>
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
                                    <small>Max <?php echo $dataVilla->kapasitas_villa?> Orang</small>
                                    <button id="bookNowBtn" class="awe-btn awe-btn-13"><i class="fa-brands fa-whatsapp"></i> &nbsp;Book Now</button>
                                </div>

                            </div>
                            <!-- END / FORM BOOK -->

                        </div>
                    </div>
                </div>
                <!-- END / DETAIL -->
                
                <!-- TAB -->
                <div class="room-detail_tab">
                    
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="room-detail_tab-header">
                                 <!--<li><a href="#overview" data-toggle="tab">OVERVIEW</a></li> -->
                                <li class="active"><a href="#amenities" data-toggle="tab">FASILITAS</a></li>
                                <li><a href="#package" data-toggle="tab">PAKET LAINNYA</a></li>
                                <!-- <li><a href="#rates" data-toggle="tab">KALENDER</a></li> -->
                                <li><a href="#calendar" data-toggle="tab">KALENDER VILLA</a></li>
                                 <li><a href="#rates" data-toggle="tab">PERATURAN</a></li> 
                            </ul>
                        </div>
                                        
                        <div class="col-md-9">
                            <div class="room-detail_tab-content tab-content">
                                
                                <!-- OVERVIEW -->
                                <div class="tab-pane fade" id="overview">

                                    <div class="room-detail_overview">
                                        <p><?php echo $dataVilla->deskripsi?></p>

                                        

                                    </div>

                                </div>
                                <!-- END / OVERVIEW -->

                                <!-- AMENITIES -->
                                <div class="tab-pane fade active in" id="amenities">
                                    
                                    <div class="room-detail_amenities">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-4">
                                                <h6>SPESIFIKASI VILLA</h6>
                                                <ul>
                                                    <li>Kapasitas Max: <?php echo $dataVilla->kapasitas_villa ?> Orang</li>
                                                    <li>Kamar Tidur: <?php echo $dets['jumlah_kamar'] ?> Kamar</li>
                                                    <li>Tempat Tidur: <?php echo $dets['tempat_tidur'] ?> Kasur</li>
                                                    <li>Kamar Mandi: <?php echo $dets['kamar_mandi'] ?> Kamar Mandi</li>
                                                    <li>Parkir Mobil: <?php echo $dets['parkir_mobil'] ?> Mobil</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-xs-6 col-lg-4">
                                                <h6>Detail Fasilitas</h6>
                                                <?php
                                                $facils_count = count($facils);
                                                $facils_per_column = 5;
                                                $column_count = ceil($facils_count / $facils_per_column);
                                                $current_facil_index = 0;
    
                                                for ($i = 0; $i < $column_count; $i++) {
                                             
                                                    
                                                    echo '<ul>';
    
                                                    // Loop through each facility for this column
                                                    for ($j = 0; $j < $facils_per_column; $j++) {
                                                        // Check if there are still facilities left
                                                        if ($current_facil_index < $facils_count) {
                                                            $fac = $facils[$current_facil_index];
                                                            if ($fac['facility'] != "") {
                                                                echo '<li> ' . $fac['facility'] . '</h6>';
                                                            }
                                                            $current_facil_index++;
                                                        } else {
                                                            // If no more facilities, break the loop
                                                            break;
                                                        }
                                                    }
    
                                                    echo '</ul>';
                                                
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        <br>
                                        <div class="col-xs-12 col-lg-12"><h6>• Fasilitas Tambahan : <?php echo $dets['tambahan']?></h6></div>
                                         <div class="col-xs-12 col-lg-12"><h6>• Lokasi : <?php echo $dataVilla->deskripsi_villa?></h6></div>
                                    </div>

                                </div>
                                <!-- END / AMENITIES -->

                                <!-- PACKAGE -->
                                <div class="tab-pane fade" id="package">
                            
                                    <div class="room-detail_package">

                                        <!-- ITEM package -->
                                        <div class="room-package_item">
                                        
                                            <div class="text">
                                                <h4><a href="#">Catering</a></h4>
                                                <p>Dapatkan Catering dengan harga yang sudah disertakan dengan berbagai macam menu yang sudah kami siapkan.</p>
                                                                    
                                                
                                            </div>
                                        </div>
                                        <!-- END / ITEM package -->
                                                                    
                                        <!-- ITEM package -->
                                        <div class="room-package_item">
                                        
                                            <div class="text">
                                                <h4><a href="#">Grill</a></h4>
                                                <p>Lengkapi liburan kalian dengan paket Grill yang sudah kami sediakan.</p>
                                                                    
                                                
                                            </div>
                                        </div>
                                        <!-- END / ITEM package -->
                                        
                                        <!-- ITEM package -->
                                        <div class="room-package_item">
                                        
                                            <div class="text">
                                                <h4><a href="#">Floaties</a></h4>
                                                <p>Bermain bersama Floaties untuk di kolam renang, ada berbagai macam bentuk floaties.</p>
                                                                    
                                                
                                            </div>
                                        </div>
                                        <!-- END / ITEM package -->
                                    </div>
                            
                                </div>
                                <!-- END / PACKAGE -->

                                <!-- RATES -->
                                <div class="tab-pane fade" id="rates">
                                    
                                    <div class="room-detail_amenities">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12">
                                                <h6>PERATURAN VILLA</h6>
                                                <ul>
                                                    <li>Anak di atas 7 tahun sudah terhitung 1 orang / pax.</li>
                                                    <li>Lebih dari kapasitas max orang, di kenakan charge 50.000/orang.</li>
                                                    <li>Jam check out pukul 12:00, apabila lewat dari jam check out maka akan di kenakan denda 500.000.</li>
                                                    <li>Kerusakan atau kehilangan barang-barang villa yang di timbulkan oleh tamu, akan di kenakan biaya ganti rugi sebesar harga barang yang rusak atau yang hilang berikut dengan biaya pemasangan.</li>
                                                    <li>Jam malam berlaku dimulai dari pukul 23:00 ( dilarang berisik menggunakan michrophone dengan volume tinggi dan berteriak ).</li>
                                                    <li>Dilarang merokok di dalam villa ataupun di dalam kamar, apabila merokok di dalam villa atau di dalam kamar maka akan di kenakan denda 500.000.</li>
                                                    <li>Dilarang merubah posisi barang-barang villa, merubah akan di kenakan denda 200.000</li>
                                                    <li>Dilarang membuang sampah dan puntung rokok sembarangan.</li>
                                                    <li>Dilarang membawa hewan peliharaan.</li>
                                                    <li>Kami tidak bertanggung jawab apabila terjadi Force Majeure ( kecelekaan yang di sebabkan oleh tamu ).</li>
                                                    <li>Dilarang membawa catering dari luar, apabila membawa catering dari luar akan di kenakan denda pembersihan ( 5rb/pax ).</li>
                                                    <li>Management villa tidak bertanggung jawab atas kehilangan properti penyewa villa.</li>
                                                    <li>Kerusakan billiard akan di kenakan denda ( laken sobek 1.000.000, stik billiard patah/pecah 200.000, segitiga billiard patah/pecah 100.000, bola billiard hilang 100.000 ).</li>
                                                    <li>Ketika villa berantakan berlebihan, contoh ( muntahan, sampah berserakan, benda apapun seperti tanah, makanan, sabun, shampoo masuk ke dalam kolam renang ) akan di denda 500.000</li>
                                                    <li>Peraturan Kolam Renang ( dilarang makan di kolam renang, dilarang menggunakan shampo & sabun di kolam renang, dilarang memasukan benda apapun kedalam kolam renang ) ketika peraturan tersebut di langgar makan akan di kenakan denda 1.500.000.</li>
                                                    <li>Penyewa dilangan menggunakan villa untuk tempat asusila atau yang bertentangan dengan peraturan dan ketentuan perundang-undangan yang berlaku di negara indonesia :
bermain judi / kegiatan pencucian uang / membawa / menggunakan / mengedarkan obat-obatan terlarang Napza ( narkotika,psikotropika dan zat adiktif lainnya ) dan alcohol / membawa senjata tajam ( apapun jenisnya )/ melakukan kegiatan pornografi dan pornoaksi atau kegiatan yang melanggar UU.ITE dan cybercrime.</li>
                                                    <br>
                                                    <h6><b>* NOTED</b> ( untuk villa tertentu ada peraturan - peraturan tamabahan yang wajib di patuhi )</h6>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                                <!-- END / RATES -->

                                <!-- CALENDAR -->
                                <div class="tab-pane fade" id="calendar">

                                    <div class="room-detail_calendar-wrap row">

                                        <div class="col-sm-12" align="center">
                                            <iframe class="disable-click scaled-iframe background-div1" style="width: 300px; height: 315px;" frameborder="0" src='<?php echo base_url().'User/calendar/'. base64_encode(json_encode($reserv)) ?>'
                                            ></iframe>
                                        </div>

                                        
                                        
                                        <div class="calendar_status text-center col-sm-12">
                                            <span>Belum Terisi</span>
                                            <span class="not-available">Terisi</span>
                                        </div>
                                    </div>

                                </div>
                                <!-- END / CALENDAR -->

                            </div>
                        </div>

                    </div>

                </div>
                <!-- END / TAB -->

                <!-- COMPARE ACCOMMODATION -->
                <div class="room-detail_compare">
                    <h2 class="room-compare_title">REKOMENDASI VILLA</h2>

                    <div class="room-compare_content">
                        <div class="row">
                            <!-- ITEM -->
                            <div class="col-md-4" style="margin-top:50px">
                                <div class="room_item-1">
                                        
                                    <h2>Villa Kamela</h2>
                                
                                    <div class="img">
                                        <a href="#"><img src="<?=base_url('assets/images/landing/Kamela.jpg');?>" alt=""></a>
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
                                        <a href="<?= base_url('user/detail/1'); ?>" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
                                    </div>
                                <br>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top:50px">
                                <div class="room_item-1">
                                        
                                    <h2>Villa Anya</h2>
                                
                                    <div class="img">
                                        <a href="#"><img src="<?=base_url('assets/images/landing/Anya.jpg');?>" alt=""></a>
                                    </div>
                                
                                    <div class="desc">
                                        
                                        <ul>
                                            <li>Kapasitas : 30</li>
                                            <li>Kamar Mandi : 2</li>
                                            <li>Kamar Tidur : 3</li>
                                            <li>Tempat Tidur : 4</li>
                                        </ul>
                                        <br>
                                        <p>Lokasi: Pasir Muncang Cisarua</p>
                                    </div>
                                
                                    <div class="bot">
                                        <a href="<?= base_url('user/detail/4'); ?>" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
                                    </div>
                                <br>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top:50px">
                                <div class="room_item-1">
                                        
                                    <h2>Villa Demang</h2>
                                
                                    <div class="img">
                                        <a href="#"><img src="<?=base_url('assets/images/landing/Demang.jpg');?>" alt=""></a>
                                    </div>
                                
                                    <div class="desc">
                                        
                                        <ul>
                                            <li>Kapasitas : 25</li>
                                            <li>Kamar Mandi : 4</li>
                                            <li>Kamar Tidur : 6</li>
                                            <li>Tempat Tidur : 6</li>
                                        </ul>
                                        <br>
                                        <p>Lokasi: Taman Safari, Cisarua</p>
                                    </div>
                                
                                    <div class="bot">
                                        <a href="<?= base_url('user/detail/3'); ?>" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
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
    document.getElementById("bookNowBtn").addEventListener("click", function() {
        var checkin = document.getElementById("checkin").value;
        var checkout = document.getElementById("checkout").value;
        var guests = document.getElementById("guests").value;
        var villaName = '<?php echo $dataVilla->nama_villa?>';

        // Validasi input
        if (checkin === "" || checkout === "" || guests === "") {
            alert("Mohon lengkapi data sebelum melanjutkan!");
            return;
        }

        // Mengubah format tanggal check-in
        var checkinParts = checkin.split("/");
        var formattedCheckin = checkinParts[1] + "/" + checkinParts[0] + "/" + checkinParts[2];

        // Mengubah format tanggal check-out
        var checkoutParts = checkout.split("/");
        var formattedCheckout = checkoutParts[1] + "/" + checkoutParts[0] + "/" + checkoutParts[2];

        var message = "Halo kak, saya ingin pesan villa.\n\n";
        message += "Nama Villa: " + villaName + "\n";
        message += "Check-in: " + formattedCheckin + "\n";
        message += "Check-out: " + formattedCheckout + "\n";
        message += "Jumlah tamu: " + guests + "\n\n";
        message += "Terima kasih";

        var whatsappLink = "https://wa.me/6289607709270?text=" + encodeURIComponent(message);
        window.open(whatsappLink, '_blank');
    });
</script>
</html>