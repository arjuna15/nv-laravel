<?php

class VillaModel extends CI_Model {

	public function __construct() {
        parent::__construct();
	}

	function cek_datavilla($idvilla) {
		return $this->db->get_where('villa', array('villa_id' => $idvilla))->row();
	}
	public function deleteBookingDateById($id) {
		$this->db->where('id', $id);
		return $this->db->delete('reservasi'); // Ganti dengan nama tabel yang sesuai
	}
	function getTanggalDetail($idvilla) {
		return $this->db->get_where('ta_vga', array('villa_id' => $idvilla))->row();
	}
	function getReservasiDetail($idvilla) {
		return $this->db->get_where('reservasi', array('villa_id' => $idvilla))->row();
	}

	// function reservasibyId($villa_id){
	// 	return $this->db->get_where('reservasi', array('villa_id' => $villa_id))->result();
	// }
	
	// function reservasi() {
	// 	return $this->db->get('reservasi')->result();
	// }

	function reservasibyId($villa_id){
		$this->db->where('villa_id', $villa_id);
		$this->db->where('check_in_date >=', date('Y-m-d')); // Memastikan check_in_date reservasi belum lewat
		return $this->db->get('reservasi')->result();
	}
	
	function reservasi() {
		$this->db->where('check_in_date >=', date('Y-m-d')); // Memastikan tanggal reservasi belum lewat
		return $this->db->get('reservasi')->result();
	}

	function cek_namavilla($id) {
		return $this->db->get_where('villa', array('nama_villa' => $id))->row();
	}
 
	function getDataVilla() {
		$data = $this->db->get('villa')->result();
		return $data;
	}

	function getDataVillabyId($data_vga) {
		return $this->db->get_where('villa', array('villa_id' => $data_vga))->result();
	}

	function getDataVillabyStatus() {
		
		return $this->db->get_where('villa', array('status_villa' => 1))->result();
	}
	function getDataVillaByPriceAndDay($min_price, $max_price, $day_range) {
    if ($day_range == 1) {
        // Ubah kolom harga dari JSON menjadi kolom yang sesuai berdasarkan hari
        $this->db->where('CAST(JSON_UNQUOTE(JSON_EXTRACT(price_villa, "$.minggu_kamis")) AS UNSIGNED) >=', $min_price);
        if ($max_price !== null) {
            $this->db->where('CAST(JSON_UNQUOTE(JSON_EXTRACT(price_villa, "$.minggu_kamis")) AS UNSIGNED) <=', $max_price);
        }
    }

    $this->db->where('status_villa', 1);
    return $this->db->get('villa')->result();
	}

	function getTanggalVGA() {
		return $this->db->get('ta_vga')->result();
	}
	
	function getTanggalVGAbyId($villa_id) {
		return $this->db->get_where('ta_vga', array('villa_id' => $villa_id))->result();
	}

	function addvilla($namavilla, $price) {

		$data = array(
			'nama_villa' => $namavilla,
			'price_villa' => $price
		);
		
	 	$this->db->insert('villa',$data);
		return $this->db->insert_id();
	}
	
	function addCalendar($date, $id) {

		$co = new DateTime($date['co']);
        $coFormatted = $co->format('Y-m-d');
		$ci = new DateTime($date['ci']);
        $ciFormatted = $ci->format('Y-m-d');
	    
	    $datapmb = array(
	        'villa_id'  => $id,
	        'check_in_date'  => $ciFormatted,
			'check_out_date' => $coFormatted
	    );
	    return $this->db->insert('reservasi', $datapmb);
	} 
	
// 	public function deleteCalendarEntry($villa_id, $dateToRemove) {
//         $formattedDateToRemove = date('Y-m-d', strtotime($dateToRemove));

//         $this->db->where('villa_id', $villa_id);
//         $this->db->where('data_pmb', $formattedDateToRemove);
//         $this->db->delete('ta_vga');
    
//         return $this->db->affected_rows() > 0;
//     }

	function addpmbdate($villa_id) {
		$datedefault[] = date('Y-m-d');
		$data = array(
			'villa_id' => $villa_id,
			'status'	=> 1,
			'data_pmb'	=> json_encode($datedefault)
		);
		return $this->db->insert('ta_vga', $data);
	}

	function updateVilla($params) {
		$id = $params['id'];
		$data = array(
			'deskripsi_villa' => $params['desc'],
			'kapasitas_villa' => $params['kap'],
			'fasilitas_villa' => $params['fas'],
			'detail_villa'	  => $params['det'],
			'images_villa'	  => $params['img'],
			'price_villa'	  => $params['hrg'],
			'status_villa'	  => 1
		);
        return $this->db->update('villa', $data, array('villa_id' => $id));
	}
	
	function updateVilla2($params) {
		$id = $params['id'];
		$data = array(
			'deskripsi_villa' => $params['desc'],
			'kapasitas_villa' => $params['kap'],
			'fasilitas_villa' => $params['fas'],
			'detail_villa'	  => $params['det'],
			'images_villa'	  => $params['img'],
			'price_villa'	  => $params['hrg'],
			'status_villa'	  => $params['stts']
		);
        return $this->db->update('villa', $data, array('villa_id' => $id));
	}
	
	function updatedate($date, $id) {
	    $data = array(
	        "data_pmb" => json_encode($date)
	    );
	    return $this->db->update('ta_vga', $data, array('villa_id' => $id));
	}
 
	function deleteVilla($id) {
	    $this->db->delete('ta_vga', array('villa_id' => $id));
		return $this->db->delete('villa', array('villa_id' => $id)); 
	}

	public function searchVilla($search) {
		$this->db->like('nama_villa', $search); // Sesuaikan dengan kolom yang ingin Anda cari
		$query = $this->db->get('villa');
		return $query->result();
	}
	
	public function getavailVilla($check_in_date, $check_out_date, $kapasitas_villa){
		return $this->db->query("SELECT * FROM villa WHERE villa_id NOT IN( 
			SELECT villa_id 
			FROM reservasi 
			WHERE reservasi.check_out_date > '$check_in_date' AND
			reservasi.check_in_date < '$check_out_date'
			) 
			OR villa.kapasitas_villa = '$kapasitas_villa'")->result();
		// return $this->db->get('villa')->result();
	} 
	public function getavailVillabyKapasitas($check_in_date, $check_out_date, $kapasitas_villa){
		return $this->db->query("SELECT * FROM villa WHERE villa_id NOT IN( 
			SELECT villa_id 
			FROM reservasi 
			WHERE reservasi.check_out_date > '$check_in_date' AND
			reservasi.check_in_date < '$check_out_date'
			) 
			AND villa.kapasitas_villa = '$kapasitas_villa'")->result();
		// return $this->db->get('villa')->result();
	} 
}