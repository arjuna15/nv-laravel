<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_in_date']) && isset($_POST['check_out_date'])) {
        $check_in_date = $_POST['check_in_date'];
        $check_out_date = $_POST['check_out_date'];

        if (!isset($_SESSION['new_dates'])) {
            $_SESSION['new_dates'] = [];
        }
        $_SESSION['new_dates'][] = ['check_in' => $check_in_date, 'check_out' => $check_out_date];
    }
}

// Handle removal of a selected date
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_index'])) {
    $indexToRemove = $_POST['remove_index'];
    if (isset($_SESSION['new_dates'][$indexToRemove])) {
        array_splice($_SESSION['new_dates'], $indexToRemove, 1);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tanggal</title>
    <link rel="stylesheet" href="<?=base_url('new_admin/dist/assets/css/app.css');?>">
    <script>
        function setCheckoutDate() {
            var checkInDate = document.getElementById('check_in_date').value;
            if (checkInDate) {
                var date = new Date(checkInDate);
                date.setDate(date.getDate() + 1); // Tambahkan 1 hari ke tanggal check-in
                var day = ("0" + date.getDate()).slice(-2);
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                var checkOutDate = year + "-" + month + "-" + day;
                document.getElementById('check_out_date').value = checkOutDate;
            }
        }
    </script>
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
                        <h3>Tambah Tanggal</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Tanggal</li>
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
                if ($this->session->flashdata('succes_insert') !='') {
                    echo '<div class="alert alert-success" role="alert">';
                    echo $this->session->flashdata('succes_insert');
                    echo '</div>';
                }
            ?>

            <!-- // Basic multiple Column Form section start -->
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <form method="post" enctype="multipart/form-data" action="">
                                            <div class="row">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="villa">Masukan Tanggal Check in</label>
                                                        <input type="date" id="check_in_date" class="form-control" placeholder="Masukan Harga" name="check_in_date" onchange="setCheckoutDate()">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="villa">Masukan Tanggal Check out</label>
                                                        <input type="date" id="check_out_date" class="form-control" placeholder="Masukan Harga" name="check_out_date">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-first">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">Pilih</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Display newly selected dates -->
                                        <h5 class="mt-3">Tanggal Dipilih</h5>
                                        <div>
                                            <?php
                                            if (isset($_SESSION['new_dates'])) {
                                                foreach ($_SESSION['new_dates'] as $index => $date) {
                                                    $ci = new DateTime($date['check_in']);
                                                    $co = new DateTime($date['check_out']);

                                                    $ciFormatted = $ci->format('d-m-Y');
                                                    $coFormatted = $co->format('d-m-Y');

                                                    echo '
                                                    <form method="post" style="display:inline;">
                                                        <input type="hidden" name="remove_index" value="' . $index . '">
                                                        <span class="mt-1 badge badge-pill badge-warning">' . $ciFormatted . ' - ' . $coFormatted . '
                                                            <button type="submit" class="badge-remove btn btn-danger btn-sm">x</button>
                                                        </span>
                                                    </form>
                                                    ';
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div>
                                            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('/admin/addCalendars')?>">
                                                <input type='hidden' name='villa_id' value='<?php echo $villa_id ?>'/>
                                                <input type='hidden' name='datenew' value='<?php echo json_encode($_SESSION['new_dates']) ?>'/>
                                                <div class="mt-3 d-flex justify-content-first">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                                </div>                                            
                                            </form>
                                        </div>

                                        <!-- Display already booked dates -->
                                        <h5 class="mt-3">Sudah Terbooking :</h5>
                                        <div>
                                            <?php
                                            // Array untuk menyimpan tanggal berdasarkan bulan
                                            $datesByMonth = [];
                                            
                                            // Memproses setiap tanggal yang sudah terbooking
                                            foreach ($data['tanggal_cico'] as $dateString) {
                                                if (is_object($dateString->check_in_date)) {
                                                    $checkInDateString = $dateString->check_in_date->format('d-m-Y');
                                                    $ci = new DateTime($checkInDateString);
                                                } else {
                                                    $ci = new DateTime($dateString->check_in_date);
                                                }
                                            
                                                // Ambil bulan dari tanggal check-in
                                                $monthKey = $ci->format('Y-m'); // Kunci bulan dan tahun (format YYYY-MM)
                                            
                                                // Masukkan tanggal ke dalam grup bulan yang sesuai
                                                if (!isset($datesByMonth[$monthKey])) {
                                                    $datesByMonth[$monthKey] = [];
                                                }
                                                $datesByMonth[$monthKey][] = $ci;
                                            }
                                            
                                            // Tampilkan grup tanggal berdasarkan bulan
                                            foreach ($datesByMonth as $monthKey => $dates) {
                                                // Konversi kunci bulan ke format bulan
                                                $monthDateTime = new DateTime($monthKey . '-01');
                                                $monthName = $monthDateTime->format('F Y');
                                            
                                                echo '<h3>' . $monthName . '</h3>';
                                                echo '<ul>';
                                                foreach ($dates as $date) {
                                                    $formattedDate = $date->format('d F Y');
                                                    echo '<li>' . $formattedDate . '</li>';
                                                }
                                                echo '</ul>';
                                            }
                                            ?>
                                            
                                        </div>

                                    </div>
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
