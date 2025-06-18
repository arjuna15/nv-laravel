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
                    <h3>Tambah Villa</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Villa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url(); ?>Admin/tambahVilla">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="villa">Nama Villa</label>
                                                <input type="text" id="villa" class="form-control"
                                                    placeholder="Masukan Nama Villa" name="villa">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="villa">Minggu - Kamis</label>
                                                <input type="text" id="mk" class="form-control"
                                                    placeholder="Masukan Harga" name="mk">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="villa">Jum'at</label>
                                                <input type="text" id="jmt" class="form-control" placeholder="Masukan Harga"
                                                    name="jmt">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="villa">Sabtu & Harga Libur</label>
                                                <input type="text" id="sw" class="form-control"
                                                    name="sw" placeholder="Masukan Harga">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-first">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>
</div>
    </div>
    <script src="<?=base_url('new_admin/dist/assets/static/js/components/dark.js');?>"></script>
    <script src="<?=base_url('new_admin/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js');?>"></script>
    <script src="<?=base_url('new_admin/dist/assets/compiled/js/app.js');?>"></script>
    

    
</body>

</html>