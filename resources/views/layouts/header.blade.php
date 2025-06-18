<header id="header">
    <div class="header_content" id="header_content">
        <div class="container">
            <div class="header_logo" id="logo-puncak">
                <a href="{{ url('/') }}"><img src="{{ asset('assets/images/landing/nvb.png') }}" alt=""></a>
            </div>
            <nav class="header_menu">
                <ul class="menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>
                        <a href="{{ url('/list') }}">List Villa <span class="fa fa-caret-down"></span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('/list') }}">Semua Villa</a></li>
                            <li><a href="{{ url('/list?price_range=1&day_range=1') }}">Villa < 1 Juta</a></li>
                            <li><a href="{{ url('/list?price_range=2&day_range=1') }}">Villa 1 - 2 Juta</a></li>
                            <li><a href="{{ url('/list?price_range=3&day_range=1') }}">Villa 2 - 3 Juta</a></li>
                            <li><a href="{{ url('/list?price_range=4&day_range=1') }}">Villa > 3 Juta</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/kontak') }}">Kontak</a></li>
                    <li><a href="{{ url('/tentang') }}">Tentang</a></li>
                </ul>
            </nav>
            <span class="menu-bars">
                <span></span>
            </span>
        </div>
    </div>
</header>
