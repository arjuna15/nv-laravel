<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class VillaModels extends Model
{
    protected $table = 'villa';
    protected $primaryKey = 'villa_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_villa', 'deskripsi_villa', 'kapasitas_villa', 'fasilitas_villa',
        'detail_villa', 'images_villa', 'price_villa', 'status_villa'
    ];

    public static function getById($id)
    {
        return self::where('villa_id', $id)->first();
    }

    public static function getByName($name)
    {
        return self::where('nama_villa', $name)->first();
    }

    public static function getAll()
    {
        return self::all();
    }

    public static function getByStatus()
    {
        return self::where('status_villa', 1)->get();
    }

    public static function getByPriceAndDay($minPrice, $maxPrice = null, $dayRange = 1)
    {
        $query = self::where('status_villa', 1);

        if ($dayRange == 1) {
            $query->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(price_villa, "$.minggu_kamis")) AS UNSIGNED) >= ?', [$minPrice]);
            if ($maxPrice !== null) {
                $query->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(price_villa, "$.minggu_kamis")) AS UNSIGNED) <= ?', [$maxPrice]);
            }
        }

        return $query->get();
    }

    public static function search($search)
    {
        return self::where('nama_villa', 'like', "%$search%")
                   ->get();
    }

    public static function getAvailable($checkIn, $checkOut, $capacity = null)
    {
        $query = self::whereNotIn('villa_id', function ($q) use ($checkIn, $checkOut) {
            $q->select('villa_id')
              ->from('reservasi')
              ->where('check_out_date', '>', $checkIn)
              ->where('check_in_date', '<', $checkOut);
        });

        if ($capacity !== null) {
            $query->where('kapasitas_villa', $capacity);
        }

        return $query->get();
    }

    public static function deleteWithRelated($id)
    {
        DB::table('ta_vga')->where('villa_id', $id)->delete();
        return self::where('villa_id', $id)->delete();
    }

    public static function updateWithParams($params)
    {
        return self::where('villa_id', $params['id'])
                   ->update([
                       'deskripsi_villa' => $params['desc'],
                       'kapasitas_villa' => $params['kap'],
                       'fasilitas_villa' => $params['fas'],
                       'detail_villa'    => $params['det'],
                       'images_villa'    => $params['img'],
                       'price_villa'     => $params['hrg'],
                       'status_villa'    => $params['stts'] ?? 1
                   ]);
    }
}

class Reservasi extends Model
{
    protected $table = 'reservasi';
    public $timestamps = false;

    protected $fillable = [
        'villa_id', 'check_in_date', 'check_out_date'
    ];

    public static function deleteById($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function byVilla($villaId)
    {
        return self::where('villa_id', $villaId)
                   ->where('check_in_date', '>=', now()->toDateString())
                   ->get();
    }

    public static function allUpcoming()
    {
        return self::where('check_in_date', '>=', now()->toDateString())->get();
    }

    public static function addCalendarEntry($villaId, $checkIn, $checkOut)
    {
        return self::create([
            'villa_id' => $villaId,
            'check_in_date' => Carbon::parse($checkIn)->format('Y-m-d'),
            'check_out_date' => Carbon::parse($checkOut)->format('Y-m-d'),
        ]);
    }
}

class TaVga extends Model
{
    protected $table = 'ta_vga';
    public $timestamps = false;

    protected $fillable = [
        'villa_id', 'status', 'data_pmb'
    ];

    public static function getByVilla($villaId)
    {
        return self::where('villa_id', $villaId)->first();
    }

    public static function getAll()
    {
        return self::all();
    }

    public static function getById($villaId)
    {
        return self::where('villa_id', $villaId)->get();
    }

    public static function updateDate($villaId, $dates)
    {
        return self::where('villa_id', $villaId)
                   ->update(['data_pmb' => json_encode($dates)]);
    }

    public static function createDefault($villaId)
    {
        return self::create([
            'villa_id' => $villaId,
            'status'   => 1,
            'data_pmb' => json_encode([now()->toDateString()])
        ]);
    }
}
