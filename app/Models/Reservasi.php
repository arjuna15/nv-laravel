<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    public $timestamps = false;
    protected $casts = ['check_in_date' => 'date',];


    protected $fillable = [
        'vila_id', 'nama_tamu', 'check_in_date', 'check_out_date'
    ];

    public static function byVilla($villaId)
    {
        return self::where('vila_id', $villaId)
                   ->where('check_in_date', '>=', now()->toDateString())
                   ->get();
    }

    public static function addCalender($villaId, $namaTamu, $checkIn, $checkOut)
    {
        return self::create([
            'vila_id' => $villaId,
            'nama_tamu' => $namaTamu,
            'check_in_date' => Carbon::parse($checkIn)->format('Y-m-d'),
            'check_out_date' => Carbon::parse($checkOut)->format('Y-m-d'),
        ]);
    }


}