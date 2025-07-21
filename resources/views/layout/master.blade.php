<!DOCTYPE html>
<html lang="en">
    @include('layout.header')
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layout.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layout.navbar')

                <!-- Main Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layout.footer')
        </div>
    </div>
    @stack('scripts')

</body>
</html>
