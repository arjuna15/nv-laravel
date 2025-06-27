<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vila extends Model
{
    use HasFactory;

    protected $table = 'vilas';
    protected $primaryKey = 'vila_id';

    protected $fillable = [
        'nama_vila',
        'lokasi_vila',
        'kapasitas_vila',
        'jumlah_kamar_tidur',
        'jumlah_tempat_tidur',
        'jumlah_kamar_mandi',
        'jumlah_area_parkir_mobil',
        'jumlah_area_parkir_bus',
        'kedalaman_luas_kolam',
        'fasilitas_tambahan_vila',
        'fasilitas_vila',
        'harga_minggu_kamis',
        'harga_jumat',
        'harga_sabtu',
        'gambar',
    ];

    protected $casts = [
        'fasilitas_vila' => 'array',
    ];
}