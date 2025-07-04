<?php

namespace App\Http\Controllers;

use App\Models\Vila;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VilaController extends Controller
{
    public function index(Request $request)
    {
        $query = Vila::query();

        if ($request->has('search')) {
            $query->where('nama_vila', 'like', '%' . $request->search . '%')
                ->orWhere('lokasi_vila', 'like', '%' . $request->search . '%');
        }

        $vilas = $query->orderBy('vila_id', 'desc')->paginate(5);

        return view('vila.index', compact('vilas'));
    }

    public function create()
    {
        return view('vila.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_vila' => 'required',
            'lokasi_vila' => 'required',
            'kapasitas_vila' => 'required',
            'detail' => 'required',
            'harga_villa' => 'required',
            'gambar' => 'required|array|min:5|max:50',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambar[] = $file->store('gambar_vila', 'public');
            }
        }

        Vila::create([
            'nama_vila' => $request->nama_vila,
            'lokasi_vila' => $request->lokasi_vila,
            'kapasitas_vila' => $request->kapasitas_vila,
            'detail' => $request->detail,
            'kedalaman_luas_kolam' => $request->kedalaman_luas_kolam,
            'fasilitas_tambahan_vila' => $request->fasilitas_tambahan_vila,
            'fasilitas_vila' => $request->fasilitas_vila,
            'harga_villa' => $request->harga_villa,
            'gambar' => array_values($gambar), // simpan array langsung
        ]);


        return redirect()->route('vila.index')->with('success', 'Data vila berhasil disimpan.');
    }

    public function edit($vila_id)
    {
        $vila = Vila::findOrFail($vila_id);
        return view('vila.edit', compact('vila'));
    }

    public function update(Request $request, $vila_id)
    {
        $vila = Vila::findOrFail($vila_id);

        $request->validate([
            'nama_vila' => 'required',
            'lokasi_vila' => 'required',
            'kapasitas_vila' => 'required',
            'detail' => 'required',
            'harga_villa' => 'required',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = $vila->gambar ?? [];

        // Hapus gambar lama jika dipilih
        if ($request->hapus_gambar) {
            foreach ($request->hapus_gambar as $gbr) {
                if (Storage::disk('public')->exists($gbr)) {
                    Storage::disk('public')->delete($gbr);
                }
                if (($key = array_search($gbr, $gambar)) !== false) {
                    unset($gambar[$key]);
                }
            }
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambar[] = $file->store('gambar_vila', 'public');
            }
        }

        if (count($gambar) < 5) {
            return redirect()->back()->with('error', 'Minimal harus ada 5 gambar pada vila.');
        }

        $vila->update([
            'nama_vila' => $request->nama_vila,
            'lokasi_vila' => $request->lokasi_vila,
            'kapasitas_vila' => $request->kapasitas_vila,
            'detail' => $request->detail,
            'kedalaman_luas_kolam' => $request->kedalaman_luas_kolam,
            'fasilitas_tambahan_vila' => $request->fasilitas_tambahan_vila,
            'fasilitas_vila' => $request->fasilitas_vila,
            'harga_villa' => $request->harga_villa,
            'gambar' => array_values($gambar), // simpan array langsung
        ]);

        return redirect()->route('vila.index')->with('success', 'Data vila berhasil diupdate.');
    }

    public function destroy($vila_id)
    {
        $vila = Vila::findOrFail($vila_id);

        $gambar = $vila->gambar;

        if ($gambar) {
            foreach ($gambar as $gbr) {
                if (Storage::disk('public')->exists($gbr)) {
                    Storage::disk('public')->delete($gbr);
                }
            }
        }

        $vila->delete();

        return redirect()->route('vila.index')->with('success', 'Data vila berhasil dihapus.');
    }

    public function calendarVilla()
    {
        $datas = Vila::getAll();
        $vgadata = [];

        foreach ($datas as $datad) {
            $date = [];

            $reservasi = Reservasi::byVilla($datad->vila_id);

            foreach ($reservasi as $reserv) {
                $date[] = $reserv->check_in_date;
            }

            $vgadata[] = [
                "vila_id" => $datad->vila_id,
                "nama_vila" => $datad->nama_vila,
                "jumlah_reserv" => $date
            ];
        }
        return view('vila.datakalender', [
            'villa' => $vgadata,
        ]);
    }

    public function tambahTanggal($id)
    {
        $villa = Vila::getById($id);
        $reservasi = Reservasi::where('vila_id', $id)->orderBy('check_in_date', 'asc')->get();

        return view('vila.tambah_kalender', compact('villa', 'reservasi'));
    }


    public function storeTanggal(Request $request)
    {
        $request->validate([
            'vila_id' => 'required|exists:vilas,vila_id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
        ]);

        Reservasi::addCalender(
            $request->vila_id,
            $request->check_in_date,
            $request->check_out_date
        );

        return redirect()->back()->with('success', 'Reservasi berhasil Ditambah.');
    }

    public function calendar()
    {
        $allVillas = Vila::getAll();
        $vgadata = [];

        foreach ($allVillas as $villa) {
            $detailVilla = json_decode($villa->detail_villa, true);

            $datashow = [
                'orang' => $villa->kapasitas_vila,
                'kamar' => $detailVilla['jumlah_kamar'] ?? '-',
                'bed'   => $detailVilla['jumlah_tempat_tidur'] ?? '-',
                'bath'  => $detailVilla['jumlah_kamar_mandi'] ?? '-',
                'park'  => $detailVilla['jumlah_parkir_mobil'] ?? '-',
            ];

            $reservasi = Reservasi::where('vila_id', $villa->vila_id)->get();
            $reservDate = $reservasi->pluck('check_in_date')->toArray();


            $vgadata[$villa->vila_id] = [
                'image' => $villa->images_vila,
                'nama' => $villa->nama_vila,
                'detail' => $datashow,
                'reserv' => $reservDate
            ];
        }

        return view('vila.kalender', [
            'vgadata' => $vgadata,
        ]);
    }




}
