<!DOCTYPE html>
<html lang="en">
<style>
.text-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Memberikan bayangan pada teks */
}
</style>

<!-- PRELOADER -->
<div id="preloader">
    <span class="preloader-dot"></span>
</div>
<!-- END / PRELOADER -->

<div id="page-wrap" class="bg-white-2">
    <!-- BANNER SLIDER -->
    <section class="section-slider slider-style-2 clearfix">
        <h1 class="element-invisible">Slider</h1>
        <div id="slider-revolution">
            <ul>
                <li data-transition="fade">
                    <img src=<?= base_url("assets/images/landing/landing_top1.jpg");?> data-bgposition="left center" data-duration="14000"
                         data-bgpositionend="right center" alt="">

                    

                    <div class="tp-caption sft fadeout slider-caption-sub slider-caption-1 text-shadow" data-x="center" data-y="240"
                         data-speed="700" data-start="1500" data-easing="easeOutBack">
                        SELAMAT DATANG DI
                    </div>

                    <div class="tp-caption sfb fadeout slider-caption slider-caption-sub-1 text-shadow" data-x="center" data-y="280"
                         data-speed="700" data-easing="easeOutBack" data-start="2000">NGEVILLAYUK
                    </div>

                    <a href="<?= base_url('/list')?>" class="tp-caption sfb fadeout awe-btn awe-btn-12 awe-btn-slider text-shadow" data-x="center"
                       data-y="380" data-easing="easeOutBack" data-speed="700" data-start="2200">SELENGKAPNYA</a>
                </li>

                <li data-transition="fade">
                    <img src=<?= base_url("assets/images/landing/landing_top2.jpg");?> data-bgposition="left center" data-duration="14000"
                         data-bgpositionend="right center" alt="">

                    <div class="tp-caption sft fadeout" data-x="center" data-y="195" data-speed="700" data-start="1300"
                         data-easing="easeOutBack">
                        <img src="assets/images/icon-slider-1.png" alt="">
                    </div>

                    <div class="tp-caption sft fadeout slider-caption-sub slider-caption-sub-3 text-shadow" data-x="center"
                         data-y="220" data-speed="700" data-start="1500" data-easing="easeOutBack">
                        DAPATKAN
                    </div>

                    <div class="tp-caption sfb fadeout slider-caption slider-caption-3 text-shadow" data-x="center" data-y="260"
                         data-speed="700" data-easing="easeOutBack" data-start="2000">
                        BERBAGAI PILIHAN VILLA
                    </div>

                    <div class="tp-caption sfb fadeout slider-caption-sub slider-caption-sub-3 text-shadow" data-x="center"
                         data-y="365" data-easing="easeOutBack" data-speed="700" data-start="2200">YANG KAMI SEDIAKAN
                    </div>

                    <div class="tp-caption sfb fadeout slider-caption-sub slider-caption-sub-3" data-x="center"
                         data-y="395" data-easing="easeOutBack" data-speed="700" data-start="2400"><img
                            src="assets/images/icon-slider-2.png" alt=""></div>
                </li>

            </ul>
        </div>

    </section>
    <!-- END / BANNER SLIDER -->
    <!-- CHECK AVAILABILITY -->
    <section class="section-check-availability availability-style-2 clearfix">
        <div class="container">
            <div class="check-availability">
                <div class="ot-heading">
                    <h2 class="mb40">Cek Ketersediaan Villa</h2>
                </div>
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
                    </div>
                    <div class="vailability-submit">
                        <button class="awe-btn awe-btn-13 pr30 pl30 f16 bold font-hind">Cek Ketersediaan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- END / CHECK AVAILABILITY -->
    
    <!-- DEALS PACKAGE -->
    <section class="section-deals mt90">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col col-xs-12 col-lg-6 col-lg-offset-3">
                        <div class="ot-heading row-20 mb30 text-center">
                            <h2>Deals & PACKAGE</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="item item-deal">
                            <div class="img">
                                <img class="img-full" src="<?= base_url('assets/images/landing/catering.jpg')?>" alt="">
                            </div>
                            <div class="info">
                                <a class="title bold f26 font-monserat upper" href="!#">Catering</a>
                                <p class="text-shadow">Dapatkan Catering dengan harga yang sudah disertakan dengan <br> berbagai macam menu yang sudah kami siapkan.</p>
                                <a class="awe-btn awe-btn-12 btn-medium font-hind f12 bold" href="!#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item item-deal">
                            <div class="img">
                                <img class="img-full" src="<?= base_url('assets/images/landing/grill.jpg')?>" alt="">
                            </div>
                            <div class="info">
                                <a class="title bold f26 font-monserat upper" href="!#">Grill</a>
                                <p class="text-shadow">Lengkapi liburan kalian dengan paket Grill yang sudah kami sediakan.</p>
                                <a class="awe-btn awe-btn-12 btn-medium font-hind f12 bold" href="!#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item item-deal">
                            <div class="img">
                                <img class="img-full" src="<?= base_url('assets/images/landing/floaties.jpg')?>" alt="">
                            </div>
                            <div class="info">
                                <a class="title bold f26 font-monserat upper" href="!#">Floaties</a>
                                <p class="text-shadow">Bermain bersama Floaties untuk di kolam renang, ada berbagai macam bentuk floaties.</p>
                                <a class="awe-btn awe-btn-12 btn-medium font-hind f12 bold" href="!#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xs-12 col-sm-6">
                        <div class="item item-deal">
                            <div class="img">
                                <img class="img-full" src="assets/images/home-3/deals/deals-1.png" alt="">
                            </div>
                            <div class="info">
                                <a class="title bold f26 font-monserat upper" href="!#">Lorem</a>
                                <p>lorem Ipsum ini mau coba coba pakai kata kata panjang biar pas dites cocok.</p>
                                <a class="awe-btn awe-btn-12 btn-medium font-hind f12 bold" href="!#">Selengkapnya</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- END / DEALS PACKAGE -->
</div>
</body>
</html>