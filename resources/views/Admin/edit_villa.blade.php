<?php 
// echo var_dump($datavilla); biasain kalo abis update atau tambah jangan redirect view, tapi redirect url eh itu lu ubah apanya tadi?
$price = json_decode($datavilla->price_villa, true); 
$facils = json_decode($datavilla->fasilitas_villa, true);
$dets = json_decode($datavilla->detail_villa, true); 
?>
<?php 
if ($this->session->flashdata('error') !='') {
	echo '<div class="alert alert-danger" role="alert">';
	echo $this->session->flashdata('error');
	echo '</div>';
}
?>
<?php 

if ($this->session->flashdata('success_register') !='') {
	echo '<div class="alert alert-success" role="alert">';
	echo $this->session->flashdata('success_register');
	echo '</div>';
}
?>
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
                    <h3>Edit <?php echo $datavilla->nama_villa ?></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Villa</li>
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
                                <form method="post" action="<?php echo base_url(); ?>Admin/updateVillas"> 
                                <input type="hidden" name="id" value="<?= $datavilla->villa_id ?>"> 
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="villa">Nama Villa</label>
                                                <input type="text" id="villa" class="form-control"
                                                    placeholder="Masukan Nama Villa" name="villa"
                                                    value="<?php echo $datavilla->nama_villa ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="villa">Lokasi Villa</label>
                                                <input type="text" id="desc" class="form-control"
                                                    placeholder="Masukan Lokasi Villa" name="desc"
                                                    value="<?php echo $datavilla->deskripsi_villa ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="villa">Kapasitas Villa</label>
                                                <input type="number" id="kap" class="form-control"
                                                    placeholder="Masukan Kapasitas Villa" name="kap"
                                                    value="<?php echo $datavilla->kapasitas_villa ?>">
                                            </div>
                                        </div>
                                        <div for="dets">
                                            <div class="row">
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="dets">Jumlah Kamar Tidur</label>
                                                    <input type="text" class="form-control" placeholder="Jumlah Kamar" id="kmr" name="kmr" value="<?php echo isset($dets['jumlah_kamar']) ? $dets['jumlah_kamar'] : ''; ?>">
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="dets">Jumlah Tempat Tidur</label>
                                                    <input type="text" class="form-control" placeholder="Jumlah Tempat Tidur" id="tmptdr" name="tmptdr" value="<?php echo isset($dets['tempat_tidur']) ? $dets['tempat_tidur'] : ''; ?>">
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="dets">Jumlah Kamar Mandi</label>
                                                    <input type="text" class="form-control" placeholder="Jumlah Kamar Mandi" id="kmrmnd" name="kmrmnd" value="<?php echo isset($dets['kamar_mandi']) ? $dets['kamar_mandi'] : ''; ?>">
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="dets">Jumlah Parkir Mobil</label>
                                                    <input type="text" class="form-control" placeholder="Jumlah Parkir" id="pkr" name="pkr" value="<?php echo isset($dets['parkir_mobil']) ? $dets['parkir_mobil'] : ''; ?>">
                                                </div>
                                            </div>
                                           
                                            <label>Fasilitas Tambahan</label>
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" class="form-control" placeholder="Tambahan" id="tmbhn" name="tmbhn" value="<?php echo isset($dets['tambahan']) ? $dets['tambahan'] : ''; ?>">
                                                    <br>
                                                </div>
                                            </div>
                                        </div>

                                        <label>Fasilitas</label>
                                        <?php if (!empty($facils) && is_array($facils)): ?>
                                        <?php for ($i = 0; $i < count($facils); $i += 3): ?>
                                            <div class="row">
                                                <div class="col-md-4 col-12 mb-3">
                                                    <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="<?php echo isset($facils[$i]['facility']) ? $facils[$i]['facility'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="<?php echo isset($facils[$i+1]['facility']) ? $facils[$i+1]['facility'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="<?php echo isset($facils[$i+2]['facility']) ? $facils[$i+2]['facility'] : ''; ?>">
                                                </div>
                                            </div>
                                            
                                        <?php endfor; ?>
                                    <?php else: ?>
                                        <div class="row">
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <input type="text" class="form-control" placeholder="Enter Facility" name="fas[][facility]" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="villa">Minggu - Kamis</label>
                                                <input type="text" id="mk" class="form-control"
                                                    placeholder="Masukan Harga" name="mk"
                                                    value="<?php echo isset($price['minggu_kamis']) ? $price['minggu_kamis'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="villa">Jum'at</label>
                                                <input type="text" id="jmt" class="form-control"
                                                    placeholder="Masukan Harga" name="jmt"
                                                    value="<?php echo isset($price['jumat']) ? $price['jumat'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="villa">Sabtu & Harga Libur</label>
                                                <input type="text" id="sw" class="form-control"
                                                    name="sw" placeholder="Masukan Harga"
                                                    value="<?php echo isset($price['sabtu_weeekend']) ? $price['sabtu_weeekend'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-first">
                                            <input type="submit" class="btn btn-primary me-1 mb-1" value="Submit" />
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
    <script src="<?=base_url('new_admin/dist/assets/static/js/components/dark.js');?>"></script>
    <script src="<?=base_url('new_admin/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js');?>"></script>
    <script src="<?=base_url('new_admin/dist/assets/compiled/js/app.js');?>"></script>
    

    
</body>

</html>