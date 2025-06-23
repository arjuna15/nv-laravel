<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngevillayuk</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/landing/logo1pm.svg') }}"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Neuton:ital,wght@0,200;0,300;0,400;0,700;0,800;1,400&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cal+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/font-lotusicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/helper.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Meta SEO -->
    <meta name="description" content="Ngevillayuk">
    <meta name="keywords" content="reservasi villa puncak, puncak bogor, puncak cipanas, wisata cipanas, cipanas update, tentang cipanas, keyword3, wisata bogor, bogor update, tentang bogor, villa murah, villa bagus">
    <meta name="author" content="Ngevillayuk">

    <!-- Inline Custom Styles -->
    <style>
        .header_mobile .header_menu ul li .sub-menu {
            background-color: rgba(0, 0, 0, 0.85);
            display: none;
        }
    </style>

    <!-- Fallback IE -->
    <!--[if lt IE 9]>
    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<body>
    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- JavaScript Files -->
    <script src="{{ asset('assets/js/lib/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/js/lib/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.countTo.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/SmoothScroll.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.form.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
