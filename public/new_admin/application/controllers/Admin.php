<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class Admin extends CI_Controller {

    function __construct() {
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('VillaModel');
	}

	public function index() {
        if ($this->session->userdata("is_login")) {
            $data['content'] = "Admin/dash";
			$data['sbactive'] = 0;
            $this->load->view('layouts/admin', $data);
        } else {
            $this->load->view("admin/login");
        }
	}

	public function login_proses() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if($this->UserModel->login_user($username,$password)) {
			redirect('Admin');
		} else {
			$this->session->set_flashdata('error','Username & Password salah');
			redirect('Admin');
		}
	}

	public function createUser() {
		if ($this->session->userdata("is_login")) {
            $data['villa'] = $this->VillaModel->getDataVilla();
			$data['content'] = "app/createadmin";
			$this->load->view('layouts/admin/admin', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/login', $data);
        }
	}

	public function createAdmin() {
		$id_villa = $this->input->post('villaid');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$role = "2";
		$data = array(
			'username' => $username,
			'password' => $password,
			'roleid' => $role,
			'idvilla' => $id_villa
		);
		$cek = $this->UserModel->cek_username($username);
		if ($cek->username == $username) {
			$this->session->set_flashdata('error','Username sudah ada!');
			redirect('admin/createUser');
		} else {
			$this->UserModel->register($data);
			$this->session->set_flashdata('success_register','Berhasil membuat Akun Admin');
			redirect('admin/createUser');
		}
	}

	public function addVilla() {
		if ($this->session->userdata("is_login")) {
			$data['content'] = "Admin/tambah_villa";
			$data['sbactive'] = 1;
            $this->load->view('layouts/admin', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('admin/login', $data);
        }
	}
	
	public function addCalendar($id) {
		 if ($this->session->userdata("is_login")) {
			
            $datavilla  = $this->VillaModel->cek_datavilla($id);

						$reservasi = $this->VillaModel->reservasibyId($datavilla->villa_id);

                        $vgadata  = array(
                                "villa_id"  => $datavilla->villa_id,
                                "nama"      => $datavilla->nama_villa,
                                "tanggal_cico"   => $reservasi,
                        );

            $data['villa_id']   = $id;
            $data['nama_villa'] = $datavilla->nama_villa;
            $data['data'] = $vgadata;
			$data['content'] = "Admin/tambah_kalender";
			$data['sbactive'] = 2;
			$this->load->view('layouts/admin', $data);
        } else {
			redirect('admin');
        }
	}
	
	public function deleteKalendars() {
        $villa_id = $this->input->post('villa_id');
        $dateToRemove = $this->input->post('delete_date');

        if ($this->VillaModel->deleteCalendarEntry($villa_id, $dateToRemove)) {
            $this->session->set_flashdata('success', 'Date deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete date.');
        }

        // Redirect to the previous page or any desired location
        redirect('/admin'); // Replace with your actual previous page URL
    }

	public function hapusKalender($id) {
		if ($this->session->userdata("is_login")) {
			$datavilla  = $this->VillaModel->cek_datavilla($id);
			$reservasi = $this->VillaModel->reservasibyId($datavilla->villa_id);
	
			$vgadata  = array(
				"villa_id"  => $datavilla->villa_id,
				"nama"      => $datavilla->nama_villa,
				"tanggal_cico"   => $reservasi,
			);
	
			$data['villa_id']   = $id;
			$data['nama_villa'] = $datavilla->nama_villa;
			$data['data'] = $vgadata;
			$data['content'] = "Admin/hapus_kalender";
			$data['sbactive'] = 2;
			$this->load->view('layouts/admin', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function deleteBookedDate($id) {
		if ($this->session->userdata("is_login")) {
			// Pastikan ID diterima
			if($id) {
				// Hapus tanggal dari database berdasarkan ID
				$this->load->model('VillaModel');
				$result = $this->VillaModel->deleteBookingDateById($id);
	
				if($result) {
					$this->session->set_flashdata('success', 'Tanggal berhasil dihapus.');
				} else {
					$this->session->set_flashdata('error', 'Gagal menghapus tanggal.');
				}
			} else {
				$this->session->set_flashdata('error', 'ID tanggal tidak valid.');
			}
	
			// Redirect ke halaman hapus kalender dengan ID villa yang sesuai
			redirect('admin/hapusKalender/'.$this->input->post('villa_id'));
		} else {
			redirect('admin');
		}
	}
	
	
	
	public function deleteCalendar($id) {
		 if ($this->session->userdata("is_login")) {
			
            $datas = $this->VillaModel->getTanggalDetail($id);
            $datavilla  = $this->VillaModel->cek_datavilla($id);
                        $detailvilla = json_decode($datavilla->detail_villa, true);
                        $datashow = array(
                            "orang" => $datavilla->kapasitas_villa,
                            "kamar" => $detailvilla['jumlah_kamar'],
                            "bed"   => $detailvilla['tempat_tidur'],
                            "bath"  => $detailvilla['kamar_mandi'],
                            "park"  => $detailvilla['parkir_mobil']
                        );
                        $vgadata[]  = array(
                                "villa_id"  => $datavilla->villa_id,
                                "image"     => $datavilla->images_villa,
                                "nama"      => $datavilla->nama_villa,
                                "data"      => $datad->data,
                                "tanggal"   => json_decode($datas->data_pmb, true),
                                "detail"    => $datashow
                        );
            $data['villa_id']   = $id;
            $data['nama_villa'] = $datavila->nama_villa;
            $data['datatanggal'] = $datas->data_pmb;
			$data['content'] = "app/deletecalendar";
			$this->load->view('layouts/admin', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/login', $data);
        }
        
	}
	function myCalendar($datas) {
        $data['datedata'] = $datas;
        $this->load->view('layouts/calendar', $data);
    }
	function infotanggal(){
		$allVillas = $this->VillaModel->getDataVilla();
			// $reservasi = $this->VillaModel->reservasi();
			// $query ['reservasi'] = $this->VillaModel->reservasi();
			$vgadata=array();
		foreach ($allVillas as $datavilla) {
				$detailvilla = json_decode($datavilla->detail_villa, true);
				$datashow = array(
					"orang" => $datavilla->kapasitas_villa,
					"kamar" => $detailvilla['jumlah_kamar'],
					"bed"   => $detailvilla['tempat_tidur'],
					"bath"  => $detailvilla['kamar_mandi'],
					"park"  => $detailvilla['parkir_mobil']
				);
				// $date = [];
				// foreach ($reservasi as $reserv) {
				// 	$date[] = $reserv->check_in_date;
				// }
				$reservasi = $this->VillaModel->reservasibyId($datavilla->villa_id);
				// var_dump(count($reservasi));
				$reservDate = [];
				if(count($reservasi) > 0){
					foreach ($reservasi as $reserv) {
						$reservDate[] = $reserv->check_in_date;
					}
				}

				$getTanggal = $this->VillaModel->getTanggalVGAbyId($datavilla->villa_id);
				// var_dump(count($reservasi));
				$tanggalIframe = '';
				if(count($getTanggal) > 0){//gak kosong di table ta_vga artinya kita set tanggalIframe ke kolom data yang di ta_vga
					$tanggalIframe = $getTanggal[0]->data;
				}


				
				$vgadata[$datavilla->villa_id] = array(
					"image"     => $datavilla->images_villa,
					"nama"      => $datavilla->nama_villa,
					"detail"    => $datashow,
					// "check_in_dates" => array(),
					"reserv" => $reservDate,
					"getTanggal" => $tanggalIframe // kalo != '' (else) ambil ke frame --- frontend => if($vga['getTanggal'] != ''){ code untuk menampilkan iframe }
					);
					// var_dump($date[1]);
			}
	
			// foreach ($reservasi as $datad) {
			// 	$datavilla  = $this->VillaModel->cek_datavilla($datad->villa_id);
			// 	$detailvilla = json_decode($datavilla->detail_villa, true);
			// 	$datashow = array(
			// 		"orang" => $datavilla->kapasitas_villa,
			// 		"kamar" => $detailvilla['jumlah_kamar'],
			// 		"bed"   => $detailvilla['tempat_tidur'],
			// 		"bath"  => $detailvilla['kamar_mandi'],
			// 		"park"  => $detailvilla['parkir_mobil']
			// 	);
			// 	// $date = [];
			// 	// 	foreach ($reservasi as $reserv) {
			// 	// 		$date[] = $reserv->check_in_date;
			// 	// 	}

			// 		$vgadata[]  = array(
			// 			"image"     => $datavilla->images_villa,
			// 			"nama"      => $datavilla->nama_villa,
			// 			"detail"    => $datashow,
			// 			// "reserv" => $date
			// 		);  
			   
			// }
			
			// $data['reserv'] = $date;
			$data['sbactive'] = 4;
			$data['vgadata'] = $vgadata;
			$data['content'] =  "admin/kalender_semua_villa";
			$this->load->view('layouts/admin', $data);
		}
	public function deleteVilla() {
		$villa_id = $this->input->post('id');
		$this->VillaModel->deleteVilla($villa_id);
		$this->session->set_flashdata('success','Berhasil Menghapus Villa!');
		redirect('admin/dataVilla');
	}

	public function tambahVilla() {
		$namaVilla = $this->input->post('villa');

		$list_price = array(
			'minggu_kamis' 		=> $this->input->post('mk'),
			'jumat' 	   		=> $this->input->post('jmt'),
			'sabtu_weeekend' 	=> $this->input->post('sw'),
		);
		$cek = $this->VillaModel->cek_namavilla($namaVilla);
		if ($cek->nama_villa == $namaVilla) {
			$this->session->set_flashdata('error','Villa sudah ada!');
			redirect('admin/addVilla');
		} else {
			$id = $this->VillaModel->addvilla($namaVilla, json_encode($list_price));
			$this->VillaModel->addpmbdate($id);
			$this->session->set_flashdata('success_register','Berhasil membuat Villa');
			redirect('admin/addVilla');
		}
	}

	public function dataVilla() {
		if ($this->session->userdata("is_login")) {
			$villa_id = $this->session->userdata('villa_id');
			if ($this->session->userdata('role_id') == "1") {
            	$data['villa'] = $this->VillaModel->getDataVilla();
			} else {
				$data['villa'] = $this->VillaModel->getDataVillabyId($villa_id);
			}
			$data['content'] = "Admin/data_villa";
			$data['sbactive'] = 3;
			$this->load->view('layouts/admin', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/login', $data);
        }
	}
	
	public function calendarVilla() {
	    if ($this->session->userdata("is_login")) {
			$villa_id = $this->session->userdata('villa_id');
			if ($this->session->userdata('role_id') == "1") {
				$datas = $this->VillaModel->getDataVillabyStatus();
				$vgadata = array();
				foreach ($datas as $datad) {
					$date = array();
					$reservasi = $this->VillaModel->reservasibyId($datad->villa_id);

					foreach ($reservasi as $reserv) {
						$date[] = $reserv->check_in_date;
					}

					$vgadata[]  = array(
						"villa_id"  		=> $datad->villa_id,
						"nama"      		=> $datad->nama_villa,
						"jumlah_reserv"		=> $date
					);
				
				}
				$data['sbactive'] = 2;
				$data['villa'] = $vgadata;
				$data['content'] = "admin/kalender_villa";
    			$this->load->view('layouts/admin', $data);
			}
		}  else {
			$this->load->view("admin/login");
        }
		
	}

	public function updateVilla() {
		
		$id = $this->input->post('id');
		
		if ($id != null) {
			$data['datavilla'] = $this->VillaModel->cek_datavilla($id);
			$data['content'] = "admin/edit_villa";
			$data['id'] = $id;
            $this->load->view('layouts/admin', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/login', $data);
        }
	}
	public function updateVillas() { 
		if ($this->session->userdata("is_login")) {
			$id = $this->input->post('id');
			
			$datavilla = $this->VillaModel->cek_datavilla($id);
	
			$facility = $this->input->post('fas');

			$list_price = array(
				'minggu_kamis' 		=> $this->input->post('mk'),
				'jumat' 	   		=> $this->input->post('jmt'),
				'sabtu_weeekend' 	=> $this->input->post('sw')
			);
	
			$detail = array(
				'jumlah_kamar'	=> $this->input->post('kmr'),
				'tempat_tidur'	=> $this->input->post('tmptdr'),
				'kamar_mandi'	=> $this->input->post('kmrmnd'),
				'parkir_mobil'	=> $this->input->post('pkr'),
				'tambahan'		=> $this->input->post('tmbhn')
			);
	
			$params = array(
				'id'	=> $this->input->post('id'),
				'desc' 	=> $this->input->post('desc'),
				'kap' 	=> $this->input->post('kap'),
				'fas' 	=> json_encode($facility),
				'det'	=> json_encode($detail),
				'hrg'	=> json_encode($list_price),
				'img'	=> $this->input->post('image')
			);
			
			$this->VillaModel->updateVilla($params);
			$data['datavilla'] = $datavilla;
			$data['content'] = "admin/edit_villa";
			$data['id'] = $id;
			$this->load->view('layouts/admin', $data);
		} else {
			$data['content'] = "admin/login";
			$this->load->view('layouts/admin', $data);
		}
	}
	
	public function updateImage() {
		$id = $this->input->post('id');
		if ($id != null) {
			$data['datavilla'] = $this->VillaModel->cek_datavilla($id);
			$data['content'] = "app/updateimage";
			$data['id'] = $id;
            $this->load->view('layouts/admin/admin', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/login', $data);
        }
	}
	
	public function updateImages() {
	    if ($this->session->userdata("is_login")) {

			$id = $this->input->post('id');

			$datavilla = $this->VillaModel->cek_datavilla($id);

			$jumlahData = count($_FILES['images']['name']);

			// Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
			for ($i=0; $i < $jumlahData ; $i++):

				// Inisialisasi Nama,Tipe,Dll.
				$_FILES['file']['name']     = $_FILES['images']['name'][$i];
				$_FILES['file']['type']     = $_FILES['images']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
				$_FILES['file']['size']     = $_FILES['images']['size'][$i];

				// Konfigurasi Upload
				$config['upload_path']          = './images/';
				$config['allowed_types']        = 'jpg|png|PNG|jpeg|JPEG';

				// Memanggil Library Upload dan Setting Konfigurasi
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('file')){ // Jika Berhasil Upload

					$fileData = $this->upload->data(); // Lakukan Upload Data

					// if ($datavilla->images_villa != null) {
					// 	$image[] = json_decode($datavilla->images_villa, true);
					// } else { 
					// }
					$image[] = array(
						'image' => $fileData['file_name']
					); 
					
				} else {
                    // Jika tidak ada file yang diunggah, pertahankan informasi gambar yang sudah ada
                    $image[] = array(
                        'image' => $datavilla->images_villa // Menggunakan gambar yang sudah ada
                    );
                }

			endfor; 
	
			$params = array(
				'id'	=> $this->input->post('id'),
				'desc' 	=> $this->input->post('desc_villa'),
				'kap' 	=> $this->input->post('kap_villa'),
				'fas' 	=> $this->input->post('fas_villa'),
				'stts'  => $this->input->post('stts_villa'),
				'det'	=> $this->input->post('det_villa'),
				'hrg'	=> $this->input->post('prc_villa'),
				'img'	=> json_encode($image)
			);
			
			
			$this->VillaModel->updateVilla2($params);
			$data['datavilla'] = $datavilla;
			$data['content'] = "app/updateimage";
			$data['id'] = $id;
			$this->session->set_flashdata('success_register','Berhasil update gambar villa');
			$this->load->view('layouts/admin/admin', $data);
		} else {
			$data['content'] = "app/login";
			$this->load->view('layouts/login', $data);
		}
	}
	
	public function addCalendars() {
		if ($this->session->userdata("is_login")) {
		    $villa_id = $this->input->post('villa_id');
		    $newdate = json_decode($this->input->post('datenew'), true);
			foreach ($newdate as $dates) {
				$datadate = array(
					"ci" => $dates['check_in'],
					"co" => $dates['check_out']
				);
				$this->VillaModel->addCalendar($datadate, $villa_id);
			}
    	    unset($_SESSION['new_dates']);
    	    $this->session->set_flashdata('succes_insert','Berhasil menambah tanggal booking!');
			redirect('admin/addCalendar/'. $villa_id);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/login', $data);
        }
	}
	
	public function deleteCalendars() {
		if ($this->session->userdata("is_login")) {
		    $villa_id = $this->input->post('villa_id');
		    $newdate = json_decode($this->input->post('datenew'), true);
    	    $this->VillaModel->updatedate($newdate, $villa_id);
    	    $this->session->set_flashdata('success_register','Berhasil menambah tanggal booking!');
			$villa_id = $this->session->userdata('villa_id');
			if ($this->session->userdata('role_id') == "1") {
			    $datas = $this->VillaModel->getTanggalVGA();
                $vgadata=array();
                foreach ($datas as $datad) {
                    if ($datad->status == 1) {
                        $datavilla  = $this->VillaModel->cek_datavilla($datad->villa_id);
                        $detailvilla = json_decode($datavilla->detail_villa, true);
                        $datashow = array(
                            "orang" => $datavilla->kapasitas_villa,
                            "kamar" => $detailvilla['jumlah_kamar'],
                            "bed"   => $detailvilla['tempat_tidur'],
                            "bath"  => $detailvilla['kamar_mandi'],
                            "park"  => $detailvilla['parkir_mobil']
                        );
                        $vgadata[]  = array(
                                "villa_id"  => $datavilla->villa_id,
                                "image"     => $datavilla->images_villa,
                                "nama"      => $datavilla->nama_villa,
                                "data"      => $datad->data,
                                "tanggal"   => json_decode($datad->data_pmb, true),
                                "detail"    => $datashow
                        );          
                    }
                
                }
                $data['villa'] = $vgadata;
			} else {
			    $datas = $this->VillaModel->getTanggalVGAbyId($villa_id);
                $vgadata=array();
                foreach ($datas as $datad) {
                    if ($datad->status == 1) {
                        $datavilla  = $this->VillaModel->cek_datavilla($datad->villa_id);
                        $detailvilla = json_decode($datavilla->detail_villa, true);
                        $datashow = array(
                            "orang" => $datavilla->kapasitas_villa,
                            "kamar" => $detailvilla['jumlah_kamar'],
                            "bed"   => $detailvilla['tempat_tidur'],
                            "bath"  => $detailvilla['kamar_mandi'],
                            "park"  => $detailvilla['parkir_mobil']
                        );
                        $vgadata[]  = array(
                                "villa_id"  => $datavilla->villa_id,
                                "image"     => $datavilla->images_villa,
                                "nama"      => $datavilla->nama_villa,
                                "data"      => $datad->data,
                                "tanggal"   => json_decode($datad->data_pmb, true),
                                "detail"    => $datashow
                        );          
                    }
                
                }
                $data['villa'] = $vgadata;
			}
			$data['content'] = "app/calendarvilla";
			$this->load->view('layouts/admin/login', $data);
        } else {
			$data['content'] = "app/login";
            $this->load->view('layouts/admin/login', $data);
        }
	}

	public function logout() {
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('is_login');
		redirect('admin');
	}

	function Voorst() 
	{
		$data['content'] = "Villa/Voorst";
		$this->load->view('layouts/admin', $data);
	}
	function Voru() 
	{
		$data['content'] = "Villa/Voru";
		$this->load->view('layouts/admin', $data);
	}
	function Ventura() 
	{
		$data['content'] = "Villa/Ventura";
		$this->load->view('layouts/admin', $data);
	}
	function Verona() 
	{
		$data['content'] = "Villa/Verona";
		$this->load->view('layouts/admin', $data);
	}
	function Vellore() 
	{
		$data['content'] = "Villa/Vellore";
		$this->load->view('layouts/admin', $data);
	}
	function Vacamonte() 
	{
		$data['content'] = "Villa/Vacamonte";
		$this->load->view('layouts/admin', $data);
	}
	function Veere() 
	{
		$data['content'] = "Villa/Veere";
		$this->load->view('layouts/admin', $data);
	}
	function Vitez() 
	{
		$data['content'] = "Villa/Vitez";
		$this->load->view('layouts/admin', $data);
	}
	function Volendam() 
	{
		$data['content'] = "Villa/Volendam";
		$this->load->view('layouts/admin', $data);
	}
	function Valeria() 
	{
		$data['content'] = "Villa/Valeria";
		$this->load->view('layouts/admin', $data);
	}
	function Vasai() 
	{
		$data['content'] = "Villa/Vasai";
		$this->load->view('layouts/admin', $data);
	}
	function Vaqueria() 
	{
		$data['content'] = "Villa/Vaqueria";
		$this->load->view('layouts/admin', $data);
	}
	function Venlo() 
	{
		$data['content'] = "Villa/Venlo";
		$this->load->view('layouts/admin', $data);
	}
	function Volcan() 
	{
		$data['content'] = "Villa/Volcan";
		$this->load->view('layouts/admin', $data);
	}
	function Venray() 
	{
		$data['content'] = "Villa/Venray";
		$this->load->view('layouts/admin', $data);
	}
	function Vermillion() 
	{
		$data['content'] = "Villa/Vermillion";
		$this->load->view('layouts/admin', $data);
	}
	function Valkensward() 
	{
		$data['content'] = "Villa/Valkensward";
		$this->load->view('layouts/admin', $data);
	}
	function Valparaiso() 
	{
		$data['content'] = "Villa/Valparaiso";
		$this->load->view('layouts/admin', $data);
	}
	function Veyo() 
	{
		$data['content'] = "Villa/Veyo";
		$this->load->view('layouts/admin', $data);
	}
	function Vyaz() 
	{
		$data['content'] = "Villa/Vyaz";
		$this->load->view('layouts/admin', $data);
	}
	function Vienna() 
	{
		$data['content'] = "Villa/Vienna";
		$this->load->view('layouts/admin', $data);
	}
	function Viensay() 
	{
		$data['content'] = "Villa/Viensay";
		$this->load->view('layouts/admin', $data);
	}
	function Velsen() 
	{
		$data['content'] = "Villa/Velsen";
		$this->load->view('layouts/admin', $data);
	}
	function Vineyard() 
	{
		$data['content'] = "Villa/Vineyard";
		$this->load->view('layouts/admin', $data);
	}
	function Vesper() 
	{
		$data['content'] = "Villa/Vesper";
		$this->load->view('layouts/admin', $data);
	}
	function Vals() 
	{
		$data['content'] = "Villa/Vals";
		$this->load->view('layouts/admin', $data);
	}
	function Vranje() 
	{
		$data['content'] = "Villa/Vranje";
		$this->load->view('layouts/admin', $data);
	}
	function Valjevo() 
	{
		$data['content'] = "Villa/Valjevo";
		$this->load->view('layouts/admin', $data);
	}
	function Vidisha() 
	{
		$data['content'] = "Villa/Vidisha";
		$this->load->view('layouts/admin', $data);
	}
	function Valga() 
	{
		$data['content'] = "Villa/Valga";
		$this->load->view('layouts/admin', $data);
	}
	function Vigan() 
	{
		$data['content'] = "Villa/Vigan";
		$this->load->view('layouts/admin', $data);
	}
	function Venilale() 
	{
		$data['content'] = "Villa/Venilale";
		$this->load->view('layouts/admin', $data);
	}
	function Virden() 
	{
		$data['content'] = "Villa/Virden";
		$this->load->view('layouts/admin', $data);
	}
	function Vagadeo() 
	{
		$data['content'] = "Villa/Vagadeo";
		$this->load->view('layouts/admin', $data);
	}
	function Vancourt() 
	{
		$data['content'] = "Villa/Vancourt";
		$this->load->view('layouts/admin', $data);
	}
	function Vilisca() 
	{
		$data['content'] = "Villa/Vilisca";
		$this->load->view('layouts/admin', $data);
	}
	function Volente() 
	{
		$data['content'] = "Villa/Volente";
		$this->load->view('layouts/admin', $data);
	}
	function Clay() 
	{
		$data['content'] = "Villa/Clay";
		$this->load->view('layouts/admin', $data);
	}
	function Mauve() 
	{
		$data['content'] = "Villa/Mauve";
		$this->load->view('layouts/admin', $data);
	}
	function Magenta() 
	{
		$data['content'] = "Villa/Magenta";
		$this->load->view('layouts/admin', $data);
	}
	function Rosewood() 
	{
		$data['content'] = "Villa/Rosewood";
		$this->load->view('layouts/admin', $data);
	}
	function Latte() 
	{
		$data['content'] = "Villa/Latte";
		$this->load->view('layouts/admin', $data);
	}
	function Sangria() 
	{
		$data['content'] = "Villa/Sangria";
		$this->load->view('layouts/admin', $data);
	}
	function Cinnamon() 
	{
		$data['content'] = "Villa/Cinnamon";
		$this->load->view('layouts/admin', $data);
	}
	function Ruby() 
	{
		$data['content'] = "Villa/Ruby";
		$this->load->view('layouts/admin', $data);
	}
	function Cortez() 
	{
		$data['content'] = "Villa/Ruby";
		$this->load->view('layouts/admin', $data);
	}
	function Blazer() 
	{
		$data['content'] = "Villa/Blazer";
		$this->load->view('layouts/admin', $data);
	}
	function Thistle() 
	{
		$data['content'] = "Villa/Thistle";
		$this->load->view('layouts/admin', $data);
	}
}
