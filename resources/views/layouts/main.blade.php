<?php $this->load->view($content) ?>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <meta charset="utf-8">
    <!-- TITLE -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="Ngevillayuk">
    <meta name="keywords" content="reservasi villa puncak, puncak bogor, puncak cipanas, wisata cipanas, cipanas update, tentang cipanas, keyword3, wisata bogor, bogor update, tentang bogor, villa murah, villa bagus">
    <meta name="author" content="Ngevillayuk">

    <style>
        .header_mobile .header_menu ul li .sub-menu {
            background-color: rgba(0, 0, 0, 0.85);
            display: none;
        }
    </style>

    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Hind:400,300,500,600%7cMontserrat:400,700' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">

    <!-- CSS LIBRARY -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/font-lotusicon.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/owl.carousel.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/jquery-ui.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/magnific-popup.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/settings.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lib/bootstrap-select.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/helper.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/fontawesome/css/fontawesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/fontawesome/css/all.min.css'); ?>">    
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive.css'); ?>">

    <!-- MAIN STYLE -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/style.css');?>">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<!-- HEADER -->
<div id="page-wrap">

    <header id="header">
        
        <!-- HEADER LOGO & MENU -->
        <div class="header_content" id="header_content">

            <div class="container">
                <!-- HEADER LOGO -->
                <div class="header_logo" id="logo-puncak">
                    <a href=<?= base_url('')?>><img src="<?=base_url('assets/images/landing/nvb.png');?>" alt=""></a>
                </div>
                <!-- END / HEADER LOGO -->
                
                <!-- HEADER MENU -->
                <nav class="header_menu">
                    <ul class="menu">
                    <li><a href="<?php echo base_url('')?>">Home</a></li>
                        
                    <li>
                        <a href="<?= base_url('list');?>">List Villa <span class="fa fa-caret-down"></span></a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('list')?>">Semua Villa</a></li>
                            <li><a href="<?=base_url('list')?>?price_range=1&day_range=1">Villa < 1 Juta</a></li>
                            <li><a href="<?=base_url('list')?>?price_range=2&day_range=1">Villa 1 - 2 Juta</a></li>
                            <li><a href="<?=base_url('list')?>?price_range=3&day_range=1">Villa 2 - 3 Juta</a></li>
                            <li><a href="<?=base_url('list')?>?price_range=4&day_range=1">Villa > 3 Juta</a></li>
                        </ul>
                    </li>
                        <li><a href="<?php echo base_url('kontak')?>">Kontak</a></li>
                        <li><a href="<?php echo base_url('tentang')?>">Tentang</a></li>
                    </ul>
                </nav>
                <!-- END / HEADER MENU -->

                <!-- MENU BAR -->
                <span class="menu-bars">
                    <span></span>
                </span>
                <!-- END / MENU BAR -->

            </div>
        </div>
        <!-- END / HEADER LOGO & MENU -->

    </header>
    <!-- END / HEADER -->

    <footer id="footer">

        <!-- FOOTER CENTER -->
        <div class="footer_center">
            <div class="container">
                <div class="row">

                    <div class="col-xs-12 col-lg-3">
                        <div class="widget widget_logo">
                            <div class="widget-logo">
                                <div class="img">
                                    <a href="#"><img src="<?=base_url('assets/images/landing/nvt.png');?>" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-lg-3">
                        <div class="widget">
                            <h4 class="widget-title"><b>Sosial Media</b></h4>
                            <ul>
                                <li><a href="https://instagram.com/ngevillayuk"><i class="fa-brands fa-instagram"></i> &nbsp; @ngevillayuk</a></li>
                                <li><a href="https://www.tiktok.com/@ngevillayuk?is_from_webapp=1&sender_device=pc"><i class="fa-brands fa-tiktok"></i> &nbsp; @ngevillayuk</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-6 col-lg-6">
                        <div class="widget">
                            <h4 class="widget-title"><b>Kontak</b></h4>
                            <ul>
                                <li><a href="https://wa.me/+62895360610100"><i class="fa-brands fa-whatsapp"></i> &nbsp; +62895360610100</a></li>
                                <li><a href="https://maps.app.goo.gl/Bu965GdgB9Xp1623A"><i class="fa-solid fa-location-dot"></i> &nbsp;  Jl. Cikopo Selatan No.29, Sukagalih. Kec. Megamendung Kab. Bogor (Direct to Gmaps)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END / FOOTER CENTER -->

        <!-- FOOTER BOTTOM -->
        <div class="footer_bottom">
            <div class="container">
                <p>&copy; Ngevillayuk</p>
            </div>
        </div>
        <!-- END / FOOTER BOTTOM -->

    </footer>
    <!-- END / FOOTER -->
</div>
    
<!-- LOAD JQUERY -->
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery-1.11.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/bootstrap-select.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/isotope.pkgd.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.themepunch.revolution.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.themepunch.tools.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/owl.carousel.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.appear.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.countTo.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.countdown.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.parallax-1.1.3.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.magnific-popup.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/SmoothScroll.js'); ?>"></script>
<!--<script type="text/javascript" src="<?= base_url('assets/fontawesome/js/fontawesome.js'); ?>"></script>-->
<!--<script type="text/javascript" src="<?= base_url('assets/fontawesome/js/fontawesome.min.js'); ?>"></script>-->
<!-- validate -->
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.form.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lib/jquery.validate.min.js'); ?>"></script>
<!-- Custom jQuery -->
<script type="text/javascript" src="<?= base_url('assets/js/scripts.js'); ?>"></script>
<!--<script src="https://kit.fontawesome.com/4458d74b1d.js" crossorigin="anonymous"></script>-->