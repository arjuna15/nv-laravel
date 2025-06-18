<link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/extensions/simple-datatables/style.css');?>">
<link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/compiled/css/table-datatable.css');?>">

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
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr align="center">
                            <th>Nama Villa</th>
                            <th>ID Villa</th>
                            <th>Status Data</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($villa as $villas) { ?>
                    <tr align="center">
                      <td><?php echo $villas->villa_id ?></td>
                      <td><?php echo $villas->nama_villa?></td>
                      <td><?php if ($villas->status_villa == 0) { echo '<span class="badge bg-danger">No Completed</span>'; } else { echo '<span class="badge bg-success">Completed</span>'; }?></td>
                      <td>
                        
                        <form method="post" action="<?php echo base_url(); ?>Admin/updateVilla">
                          <input type='hidden' name='id' value='<?php echo $villas->villa_id?>' />
                          <button class="btn btn-sm btn-warning" type="submit"><span class="fas fa-upload" aria-hidden="true"></span></button>
                        </form>
                        <form method="post" action="<?php echo base_url(); ?>Admin/updateImage">
                          <input type='hidden' name='id' value='<?php echo $villas->villa_id?>' />
                          <button class="btn btn-sm btn-info mt-1" type="submit"><span class="far fa-images" aria-hidden="true"></span></button>
                        </form>
                            <form method="post" action="<?php echo base_url(); ?>Admin/deleteVilla">
                              <input type='hidden' name='id' value='<?php echo $villas->villa_id?>' />
                              <button class="btn btn-danger mt-1" type="submit"><span class="far fa-trash-alt" aria-hidden="true"></span></button>
                            </form>
                      </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
<script src="<?=base_url('new_admin/dist/assets/static/js/components/dark.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/compiled/js/app.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/extensions/simple-datatables/umd/simple-datatables.js');?>"></script>
<script src="<?=base_url('new_admin/dist/assets/static/js/pages/simple-datatables.js');?>"></script>
</body>

</html>