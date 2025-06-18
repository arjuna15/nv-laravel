<!DOCTYPE html>
<html lang="en">

<!-- PRELOADER -->
<div id="preloader">
    <span class="preloader-dot"></span>
</div>
<!-- END / PRELOADER -->
    <div id="page-wrap">  
        <section class="section-room bg-white">
            <div class="container">
            <section class="section-room bg-white">
                    <div class="container">

                        <div class="room-wrap-1">
                            <div class="row">
                                <!-- ITEM -->
                                <div class="col-md-6">
                                    <div class="room_item-1" style="margin-top: 100px;">
                                    
                                        <h2>List Villa</h2>
                                        <p>Temukan Villa yang anda butuhkan dengan mudah dan cepat</p>
                                    
                                    </div>
                                </div>
                                <!-- END / ITEM -->
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Konten section di sini -->
                <!-- CHECK AVAILABILITY -->
                
                <section class="section-check-availability">
                    <div class="container">
                        <div class="check-availability">
                            <div class="row v-align">
                                <div class="col-lg-9">
                                    <form action="<?php echo base_url('user/filter_villas');?>" method="get">
                                        <div class="availability-form mb40">
                                            <input type="text" name="check_in_date" class="awe-calendar from" placeholder="Tanggal Checkin" value="<?php echo isset($_GET['check_in_date']) ? $_GET['check_in_date'] : ''; ?>">
                                            <input type="text" name="check_out_date" class="awe-calendar to" placeholder="Tanggal Checkout" value="<?php echo isset($_GET['check_out_date']) ? $_GET['check_out_date'] : ''; ?>">
                                            <select class="awe-select" name="kapasitas_villa">
                                                <option <?php echo !isset($_GET['kapasitas_villa']) ? 'selected' : ''; ?>>Kapasitas</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '10' ? 'selected' : ''; ?>>10</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '15' ? 'selected' : ''; ?>>15</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '20' ? 'selected' : ''; ?>>20</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '25' ? 'selected' : ''; ?>>25</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '30' ? 'selected' : ''; ?>>30</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '50' ? 'selected' : ''; ?>>50</option>
                                                <option <?php echo isset($_GET['kapasitas_villa']) && $_GET['kapasitas_villa'] == '100' ? 'selected' : ''; ?>>100</option>
                                            </select>
                                                <div class="vailability-submit">
                                                    <button type="submit" class="awe-btn awe-btn-13">Cari Villa</button>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="hr"></div>
                        </div>
                    </div>
                </section>           
                <!-- END / CHECK AVAILABILITY -->
                

            <!-- PAGE WRAP -->
                <!-- ROOM -->
                <section class="section-room bg-white">
                    <div class="container">

                        <div class="room-wrap-1">
                            <div class="row">    
                            <?php if (isset($_GET['check_in_date']) && isset($_GET['check_out_date']) && isset($_GET['kapasitas_villa']) && !empty($dataVilla)): ?>
                                <!-- HASIL PENCARIAN -->
                                    <div class="container">
                                        <p class="align-bottom">Hasil pencarian yang dilakukan :</p>
                                        <!-- Anda dapat menambahkan informasi atau pesan tambahan di sini -->
                                    </div>
                                <!-- END / HASIL PENCARIAN -->
                            <?php endif; ?>
                            <?php
                            foreach ($dataVilla as $key => $villa) {
                                $price = json_decode($villa->price_villa, true);
                                $images = json_decode($villa->images_villa, true);
                                $dets = json_decode($villa->detail_villa, true); 
                                $i = $key + 1;
                            { ?>   
                                <!-- ITEM -->
                                <div class="col-md-6">
                                    <div class="room_item-1" style="margin-top:-5px" >
                                            
                                        <h2><?php echo $villa->nama_villa ?></h2>
                                    
                                        <div class="img">
                                            <a href="#"><img src="<?php echo base_url() . 'images/' . $images[0]['image'] ?>" width="270" height="290" alt=""></a>
                                        </div>
                                    
                                        <div class="desc">
                                            
                                            <ul>
                                                <li>Kapasitas : <?php echo $villa->kapasitas_villa ?></li>
                                                <li>Kamar Mandi : <?php echo $dets['kamar_mandi']?></li>
                                                <li>Kamar Tidur : <?php echo $dets['jumlah_kamar']?></li>
                                                <li>Tempat Tidur : <?php echo $dets['tempat_tidur']?></li>
                                            </ul>
                                            <br>
                                            <p>Lokasi: <?php echo $villa->deskripsi_villa ?></p>
                                        </div>
                                    
                                        <div class="bot">
                                            <span class="price">Mulai dari <span class="amout"><?php echo number_format($price['minggu_kamis'], 2, ',', '.') ?></span> /malam</span>
                                            <a href="<?php echo base_url('user/detail/' . $villa->villa_id) ?>"" class="awe-btn awe-btn-13">SELENGKAPNYA</a>
                                        </div>
                                    <br>
                                    </div>
                                </div>
                                <!-- END / ITEM -->
                                <?php } ?>
                            <?php } ?>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- END / ROOM -->
            </div>
        </section>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengatur event listener pada tombol "Reset Filter"
        document.getElementById('reset-filter-btn').addEventListener('click', function() {
            // Mengatur nilai default pada input tanggal cekin, cekout, dan select kapasitas
            document.querySelector('input[name="check_in_date"]').value = '';
            document.querySelector('input[name="check_out_date"]').value = '';
            document.querySelector('select[name="kapasitas_villa"]').selectedIndex = 0;
        });
    });
</script>
</html>