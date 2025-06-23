<!DOCTYPE html>
<html lang="en">
    <title>Tentang Kami</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/landing/tab.svg') }}">
    <!-- PRELOADER -->
    <!--<div id="preloader">-->
    <!--    <span class="preloader-dot"></span>-->
    <!--</div>-->
    <!-- END / PRELOADER -->

    <!-- PAGE WRAP -->
    @extends('layouts.app')
    @section('content')
    <div id="page-wrap">
  
        <!-- SUB BANNER -->
        <section class="section-sub-banner bg-9">
            <div class="awe-overlay"></div>
            <div class="sub-banner">
                <div class="container">
                    <div class="text text-center">
                        <h2>TENTANG KAMI</h2>
                        <p>Media Agency Penyewaan Villa Terbesar di Puncak Bogor</p>
                    </div>
                </div>

            </div>

        </section>
        <!-- END / SUB BANNER -->

        <!-- ABOUT -->
        <section class="section-about">
            <div class="container">
                    <div class="img" align="center">
                        <img src="{{'assets/images/landing/imagi.svg'}}" width="400px" alt="">
                    </div>
                <div class="about" style="margin-top:100px">

                    <!-- ITEM -->
                    <div class="text">
                        <h2 class="heading">Tentang Kami</h2>
                        <br>
                        <div class="desc">
                            <p>Di Ngevillayuk, visi kami adalah menjadi pemimpin dalam menyediakan informasi terkini, 
                            inspiratif, dan bermakna yang membawa dampak positif pada masyarakat. Kami berkomitmen untuk menjadi 
                            sumber terkemuka dalam berita, hiburan, dan cerita lokal yang menghubungkan dan memberdayakan komunitas.</p>
                        </div>
                    </div>
                    <!-- END / ITEM -->
                    <br>
                    <!-- ITEM -->
                    <div class="about-item about">

                        <div class="img">
                            <img src="assets/images/about/img-1.jpg" height="300" alt="">
                        </div>

                        <div class="text">
                            <h2 class="heading">Visi Kami</h2>
                            <div class="desc">
                                <p>Di Ngevillayuk, visi kami adalah menjadi pemimpin dalam menyediakan informasi terkini, 
                                   inspiratif, dan bermakna yang membawa dampak positif pada masyarakat. Kami berkomitmen untuk menjadi 
                                   sumber terkemuka dalam berita, hiburan, dan cerita lokal yang menghubungkan dan memberdayakan komunitas.</p>
                            </div>
                        </div>

                    </div>
                    <!-- END / ITEM -->

                    <!-- ITEM -->
                    <div class="about-item about-right">

                        <div class="img">
                            <img src="assets/images/about/img-1.jpg" height="300" alt="">
                        </div>

                        <div class="text">
                            <h2 class="heading">Misi Kami</h2>
                            <div class="desc">
                                <p>Memberikan Informasi Berkualitas: Kami berusaha menyajikan berita dan informasi terkini yang akurat 
                                   dan relevan, memberikan pandangan mendalam tentang isu-isu lokal dan global.
                                   <br>
                                   Menginspirasi dan Mencerahkan: Kami bertujuan untuk menginspirasi dan memberdayakan masyarakat Bogor dengan menghadirkan cerita-cerita positif dan solusi yang konstruktif.
                                   <br>
                                   Memajukan Talenta Lokal: Kami mendukung dan mempromosikan bakat dan inisiatif lokal di bidang media, seni, dan budaya untuk mengangkat citra Bogor.</p>
                            </div>
                        </div>
                    </div>
                    <!-- END / ITEM -->

                </div>

            </div>
        </section>
        <!-- END / ABOUT -->
        
        <!-- HOTEL STATISTICS -->

        <!-- TEAM -->
        <section class="section-team">
            <div class="container">

                <div class="team">
                    <h2 class="heading" style="text-align:center">TIM KAMI</h2>
                    <br>
                    <p>"Ngevillayuk" bangga memiliki tim yang bersemangat dan berpengalaman, yang berkomitmen untuk memberikan kualitas terbaik dalam setiap tugas mereka. Keberagaman bakat dan perspektif di dalam tim kami memastikan bahwa kami dapat memenuhi berbagai kebutuhan dan minat pembaca dan pemirsa kami.Terima kasih telah menjadi bagian dari perjalanan kami di Ngevillayuk. Kami berharap dapat terus melayani dan memberikan kontribusi positif bagi masyarakat Bogor dan sekitarnya.</p>
                </div>
                <div class="img" align="center" style="margin-top:50px;">
                    <img src="{{'assets/images/landing/team3.jpg'}}" width="585" height="300" alt="">
                </div>

            </div>
        </section>
        <!-- END / TEAM -->

    </div>
    @endsection
    <!-- END / PAGE WRAP -->
</html>