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
        'detail',
        'kedalaman_luas_kolam',
        'fasilitas_tambahan_vila',
        'fasilitas_vila',
        'harga_villa',
        'gambar',
    ];

    protected $casts = [
    'fasilitas_vila' => 'array',
    'detail' => 'array',
    'harga_villa' => 'array',
    'gambar' => 'array',
    ];

    public static function getAll()
    {
        return self::all();
    }

    public static function getById($id)
    {
        return self::where('vila_id', $id)->first();
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

}