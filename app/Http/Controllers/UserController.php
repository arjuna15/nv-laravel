<?php

namespace App\Http\Controllers;

use App\Models\VillaModels;
use App\Models\Vila;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function index()
    {
        $kapasitas = DB::table('vilas')
            ->select('kapasitas_vila')
            ->distinct()
            ->orderByRaw('CAST(kapasitas_vila AS UNSIGNED) ASC')
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

        $dataVilla = Vila::getByPriceAndDay($min_price, $max_price, $day_range);

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
        $checkInDate = Carbon::createFromFormat('m/d/Y', $request->check_in_date)->format('Y-m-d');
        $checkOutDate = Carbon::createFromFormat('m/d/Y', $request->check_out_date)->format('Y-m-d');

        $kapasitas_villa = $request->input('kapasitas_vila');
        

        if ($kapasitas_villa === 'Kapasitas') {
            $dataVilla = Vila::getAvailVilla($checkInDate, $checkOutDate, $kapasitas_villa);
        } else {
            $dataVilla = Vila::getAvailVillaByKapasitas($checkInDate, $checkOutDate, $kapasitas_villa);
        }
        

        return view('list', [
            'dataVilla' => $this->rearrangeVillas($dataVilla),
        ]);
    }

    public function detail($villaId, $villaName = null)
    {
        $dataVilla = Vila::find($villaId);

        if (!$dataVilla) {
            abort(404);
        }

        $expectedVillaName = Str::slug($dataVilla->nama_vila);

        if ($villaName !== $expectedVillaName) {
            return redirect()->route('user.detail', [
                'villaId' => $villaId,
                'villaName' => $expectedVillaName
            ]);
        }

        // Ambil reservasi via method byVilla
        $reservasi = Reservasi::byVilla($villaId)
            ->where('status', '!=', 'Batal')
            ->get();

        $reserv = [];

        foreach ($reservasi as $item) {
            $start = Carbon::parse($item->check_in_date);
            $end = Carbon::parse($item->check_out_date);

            while ($start < $end) {
                $reserv[] = $start->toDateString();
                $start->addDay();
            }
        }

        $images = is_string($dataVilla->gambar) ? json_decode($dataVilla->gambar, true) : $dataVilla->gambar;
        $dets = is_string($dataVilla->detail) ? json_decode($dataVilla->detail, true) : $dataVilla->detail;
        $facils = is_string($dataVilla->fasilitas_vila) ? json_decode($dataVilla->fasilitas_vila, true) : $dataVilla->fasilitas_vila;
        $price = is_string($dataVilla->harga_villa) ? json_decode($dataVilla->harga_villa, true) : $dataVilla->harga_villa;


        $nama_villa = $dataVilla->nama_vila;
        $kapasitas_villa = $dataVilla->kapasitas_vila;
        $lokasi_vila = $dataVilla->lokasi_vila;
        $kolam_villa = $dataVilla->kolam_villa;
        $fasilitas_tambahan_villa = $dataVilla->fasilitas_tambahan_villa;
        // Ambil tanggal detail, jika pakai model langsung

        return view('detail', [
            'dataVilla' => $dataVilla,
            'images' => $images,
            'dets' => $dets,
            'facils' => $facils,
            'price' => $price,
            'nama_villa' => $nama_villa,
            'fasilitas_tambahan_villa' => $fasilitas_tambahan_villa,
            'kapasitas_villa' => $kapasitas_villa,
            'lokasi_vila' => $lokasi_vila,
            'kolam_villa' => $kolam_villa,
            'reserv' => $reserv
        ]);

    }
}