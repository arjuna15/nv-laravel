<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Tanggal</title>
    <link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/extensions/simple-datatables/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/compiled/css/table-datatable.css');?>">
</head>
<body>
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
                        <h3>Hapus Tanggal</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Hapus Tanggal</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <?php 
                if ($this->session->flashdata('error') !='') {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo $this->session->flashdata('error');
                    echo '</div>';
                }
            ?>

            <?php 
                if ($this->session->flashdata('success') !='') {
                    echo '<div class="alert alert-success" role="alert">';
                    echo $this->session->flashdata('success');
                    echo '</div>';
                }
            ?>

            <!-- Display already booked dates by month -->
            <h5 class="mt-3">Tanggal Terbooking</h5>
            <?php
            $groupedDates = [];
            foreach ($data['tanggal_cico'] as $date) {
                $check_in_date = new DateTime($date->check_in_date);
                $month = $check_in_date->format('F Y'); // Format bulan dan tahun (contoh: Juli 2024)

                if (!isset($groupedDates[$month])) {
                    $groupedDates[$month] = [];
                }

                $groupedDates[$month][] = $date;
            }

            foreach ($groupedDates as $month => $dates) {
                echo '<h6 class="mt-3">' . $month . '</h6>';
                echo '<div>';
                foreach ($dates as $date) {
                    $check_in_date = new DateTime($date->check_in_date);
                    $check_out_date = new DateTime($date->check_out_date);
                    $ciFormatted = $check_in_date->format('d F Y'); // Format tanggal dengan nama bulan
                    $coFormatted = $check_out_date->format('d F Y'); // Format tanggal dengan nama bulan

                    echo '<form method="post" action="'.base_url('admin/deleteBookedDate/'.$date->id).'" style="display:inline;">
                            <input type="hidden" name="villa_id" value="' . $data['villa_id'] . '">
                            <input type="hidden" name="date_id" value="' . $date->id . '">
                            <span class="mt-1 badge badge-pill badge-primary">' . $ciFormatted . ' - ' . $coFormatted . '
                                <button type="submit" class="badge-remove btn btn-danger btn-sm">x</button>
                            </span>
                          </form>';
                }
                echo '</div>';
            }
            ?>

        </div>
    </div>

    <script src="<?=base_url('new_admin/dist/assets/static/js/components/dark.js');?>"></script>
    <script src="<?=base_url('new_admin/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js');?>"></script>
    <script src="<?=base_url('new_admin/dist/assets/compiled/js/app.js');?>"></script>
</body>
</html>
            