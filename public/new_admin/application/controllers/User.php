<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('VillaModel');
	}
	
	public function index()
	{
		// $this->load->view('landing');
        $data['content'] =  "landing";
        $this->load->view('layouts/main', $data);
	}
    public function kontak()
	{
		// $this->load->view('landing');
        $data['content'] =  "kontak";
        $this->load->view('layouts/main', $data);
	}
    public function tentang()
	{
		// $this->load->view('landing');
        $data['content'] =  "tentang";
        $this->load->view('layouts/main', $data);
	}
	public function list()
    {   
    $price_range = $this->input->get('price_range');
    $day_range = $this->input->get('day_range');

    // Konversi parameter harga menjadi kisaran harga
    $min_price = null;
    $max_price = null;
    if ($price_range == 1) {
        $min_price = 0;
        $max_price = 999999;
    } elseif ($price_range == 2) {
        $min_price = 1000000;
        $max_price = 1999999;
    } elseif ($price_range == 3) {
        $min_price = 2000000;
        $max_price = 2999999;
    } elseif ($price_range == 4) {
        $min_price = 3000000;
    }

    // Filter data berdasarkan kisaran harga dan hari
    $data['dataVilla'] = $this->VillaModel->getDataVillaByPriceAndDay($min_price, $max_price, $day_range);
    $data['content'] =  "list";
    $this->load->view('layouts/main', $data);
    }
    public function filter_villas() {
        // Ambil data dari form
        $check_in_date = $this->input->get('check_in_date');
        $check_out_date = $this->input->get('check_out_date');
        $kapasitas_villa = $this->input->get('kapasitas_villa');
    
        // Ubah format tanggal menjadi Y-m-d
        $check_in_date = date('Y-m-d', strtotime($check_in_date));
        $check_out_date = date('Y-m-d', strtotime($check_out_date));
    
        // Panggil fungsi model untuk mendapatkan data villa yang tersedia
        if ($this->input->get('kapasitas_villa')== "Kapasitas") {
            $data['dataVilla'] = $this->VillaModel->getavailVilla($check_in_date, $check_out_date, $kapasitas_villa);
        }
        else {
            $data['dataVilla'] = $this->VillaModel->getavailVillabyKapasitas($check_in_date, $check_out_date, $kapasitas_villa);
        }
        $data['content'] = "list"; // Tentukan view mana yang akan ditampilkan
        $this->load->view('layouts/main', $data);
    }
    function detail($villaId) {
        // $villaId = $this->input->post('id');
        $reservasi = $this->VillaModel->reservasibyId($villaId);
        $date = [];
        foreach ($reservasi as $reserv) {
             $date[] = $reserv->check_in_date;
        }
        $tanggal = $this->VillaModel->getTanggalDetail($villaId);
        $data['dataVilla'] = $this->VillaModel->cek_datavilla($villaId);
        $data['reserv'] = $date;
        $data['content'] =  "detail";
        $this->load->view('layouts/main', $data);
    }
    public function calendar($datas){
        $data['datedata'] = $datas;
        $this->load->view('layouts/calendar', $data);
    }
}
