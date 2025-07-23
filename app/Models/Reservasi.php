<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    public $timestamps = true;


    protected $fillable = [
        'vila_id', 'no', 'nama_tamu', 'check_in_date', 'check_out_date',
        'total', 'uang_masuk', 'sisa', 'pelunasan', 'catatan', 'no_hp', 'status', 'nama_admin', 'input_by_admin'
    ];


    public static function byVilla($villaId)
    {
        return self::where('vila_id', $villaId)
                   ->where('check_in_date', '>=', now()->toDateString());
    }

    public function vila()
    {
        return $this->belongsTo(Vila::class, 'vila_id');
    }


    public static function addCalender($vila_id, $nama_tamu, $check_in, $check_out, $data_lain = [])
    {
        return self::create([
            'vila_id' => $vila_id,
            'nama_tamu' => $nama_tamu,
            'check_in_date' => $check_in,
            'check_out_date' => $check_out,
            'no' => $data_lain['no'] ?? '',
            'no_hp' => $data_lain['no_hp'] ?? '',
            'total' => $data_lain['total'] ?? '0',
            'uang_masuk' => $data_lain['uang_masuk'] ?? '0',
            'sisa' => $data_lain['sisa'] ?? '0',
            'pelunasan' => $data_lain['pelunasan'] ?? now(),
            'catatan' => $data_lain['catatan'] ?? '',
            'status' => $data_lain['status'] ?? 'Belum Lunas',
        ]);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

}