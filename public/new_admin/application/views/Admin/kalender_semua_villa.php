<link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/extensions/simple-datatables/style.css');?>">
<link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/compiled/css/table-datatable.css');?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
            
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Villa</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Villa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <?php foreach($vgadata as $vga):?>		
                <?php $images = json_decode($vga['image'],true);?>
                <section class="page-heading opacity-dark" style="background-image: url(<?php echo base_url('images/'.$images[0]['image']);?>); background-size: 100% 100%; background-position: center;">


                        <div class="container mt-5" style="padding: 50px;">
                            <div class="row no-gutters">
                                <div class="col-md-5 wrap-about pb-md-3 ftco-animate pr-md-5 pb-md-5 pt-md-4" align="center">
                                    <div class="heading-section mb-4">
                                        <h2 class="text-white text-shadow">Kalender</h2>
                                        <h2 class="text-white text-shadow"><?php echo $vga['nama']?></h2>
                                    </div>
                                        <p class="text-white text-shadow"> Kap. Max <?php echo $vga['detail']['orang']?>  Orang,  <?php echo $vga['detail']['kamar']?>  Kamar Tidur,  <?php echo $vga['detail']['bed']?> Bed, <br> <?php echo $vga['detail']['bath']?> Kamar Mandi & <?php echo $vga['detail']['park']?> Parkir Mobil</p>
                                </div>
                                <div class="col-md-7 order-md-first d-flex">
                                    <?php if($vga['getTanggal'] != '') { ?>
                                        <iframe width="300" height="480" scrolling="no" frameborder="0" srcdoc='
                                        <div id="ZionCalendarWidget"></div>
                                        <script src="https://app.channelmanager.com.au/Widget/CMCalendarWidget.js" id="ZionCalendarWidgetId" type="text/javascript"><?=$vga['getTanggal'];?></script>
                                        '></iframe> 
                                    <?php }  ?>
                                        <iframe class="disable-click scaled-iframe background-div1" style="width: 300px; height: 292px;" frameborder="0" src='<?php echo base_url().'User/calendar/'. base64_encode(json_encode($vga['reserv'])) ?>'
                                        ></iframe>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>

    </section>
</div>
<script src="<?=base_url('new_admin/dist/assets/static/js/components/dark.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/compiled/js/app.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/extensions/simple-datatables/umd/simple-datatables.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/static/js/pages/simple-datatables.js');?>"></script>

<style>

.text-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Memberikan bayangan pada teks */
}
</style>
</body>

</html>