<?php

namespace App\Http\Controllers;

use App\Models\VillaModels;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function index()
    {
        $kapasitas = DB::table('villa')
            ->select('kapasitas_villa')
            ->distinct()
            ->orderByRaw('CAST(kapasitas_villa AS UNSIGNED) ASC')
            ->get();

        return view('landing', [
            'kapasitas' => $kapasitas,
        ]);
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function list(Request $request)
    {
        $price_range = $request->input('price_range');
        $day_range = $request->input('day_range');

        $min_price = null;
        $max_price = null;

        switch ($price_range) {
            case 1:
                $min_price = 0;
                $max_price = 1000000;
                break;
            case 2:
                $min_price = 1000001;
                $max_price = 1999999;
                break;
            case 3:
                $min_price = 2000000;
                $max_price = 2999999;
                break;
            case 4:
                $min_price = 3000000;
                break;
        }

        $dataVilla = VillaModels::getByPriceAndDay($min_price, $max_price, $day_range);

        return view('list', [
            'dataVilla' => $this->rearrangeVillas($dataVilla),
        ]);
    }

    protected function rearrangeVillas($villas)
    {
        $result = collect();
        $specificIds = [230, 231, 17, 1, 9, 10, 4, 2, 3, 6, 7];

        foreach ($specificIds as $id) {
            $villa = $villas->firstWhere('villa_id', $id);
            if ($villa) {
                $result->push($villa);
                $villas = $villas->reject(fn($v) => $v->villa_id === $id);
            }
        }

        $modified = $villas->filter(fn($v) => in_array($v->villa_id, [12, 16]));
        $rest = $villas->filter(fn($v) => !in_array($v->villa_id, [12, 16]));

        return $result->merge($modified)->merge($rest);
    }

    public function filterVillas(Request $request)
    {
        $check_in_date = date('Y-m-d', strtotime($request->input('check_in_date')));
        $check_out_date = date('Y-m-d', strtotime($request->input('check_out_date')));
        $kapasitas = $request->input('kapasitas_villa');

        if ($kapasitas === 'Kapasitas') {
            $dataVilla = Villa::getAvailable($check_in_date, $check_out_date);
        } else {
            $dataVilla = Villa::getAvailableByKapasitas($check_in_date, $check_out_date, $kapasitas);
        }

        return view('layouts.main', [
            'dataVilla' => $this->rearrangeVillas(collect($dataVilla)),
            'content' => 'list'
        ]);
    }

    public function detail($villaId, $villaName = null)
    {
        $dataVilla = VillaModels::find($villaId);

        if (!$dataVilla) {
            abort(404);
        }

        $expectedVillaName = Str::slug($dataVilla->nama_villa);
        if ($villaName !== $expectedVillaName) {
            return redirect()->route('user.detail', ['villaId' => $villaId, 'villaName' => $expectedVillaName]);
        }

        $reservasi = Reservasi::allUpcoming($villaId);
        $dates = collect($reservasi)->pluck('check_in_date');

        return view('detail', [
            'dataVilla' => $dataVilla,
            'reserv' => $dates
        ]);
    }

    public function calendar($datas)
    {
        return view('layouts.calendar', ['datedata' => $datas]);
    }
}