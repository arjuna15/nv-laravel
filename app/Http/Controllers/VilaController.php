<?php

namespace App\Http\Controllers;

use App\Models\Vila;
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
            'kapasitas_vila' => 'required|integer',
            'jumlah_kamar_tidur' => 'required|integer',
            'jumlah_tempat_tidur' => 'required|integer',
            'jumlah_kamar_mandi' => 'required|integer',
            'jumlah_area_parkir_mobil' => 'required|integer',
            'jumlah_area_parkir_bus' => 'required|in:Ya,Tidak',
            'harga_minggu_kamis' => 'required|integer',
            'harga_jumat' => 'required|integer',
            'harga_sabtu' => 'required|integer',
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
            'jumlah_kamar_tidur' => $request->jumlah_kamar_tidur,
            'jumlah_tempat_tidur' => $request->jumlah_tempat_tidur,
            'jumlah_kamar_mandi' => $request->jumlah_kamar_mandi,
            'jumlah_area_parkir_mobil' => $request->jumlah_area_parkir_mobil,
            'jumlah_area_parkir_bus' => $request->jumlah_area_parkir_bus,
            'kedalaman_luas_kolam' => $request->kedalaman_luas_kolam,
            'fasilitas_tambahan_vila' => $request->fasilitas_tambahan_vila,
            'fasilitas_vila' => json_encode($request->fasilitas_vila),
            'harga_minggu_kamis' => $request->harga_minggu_kamis,
            'harga_jumat' => $request->harga_jumat,
            'harga_sabtu' => $request->harga_sabtu,
            'gambar' => json_encode($gambar),
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

        // Validasi tetap
        $request->validate([
            'nama_vila' => 'required',
            'lokasi_vila' => 'required',
            'kapasitas_vila' => 'required|integer',
            'jumlah_kamar_tidur' => 'required|integer',
            'jumlah_tempat_tidur' => 'required|integer',
            'jumlah_kamar_mandi' => 'required|integer',
            'jumlah_area_parkir_mobil' => 'required|integer',
            'jumlah_area_parkir_bus' => 'required|in:Ya,Tidak',
            'harga_minggu_kamis' => 'required|integer',
            'harga_jumat' => 'required|integer',
            'harga_sabtu' => 'required|integer',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = json_decode($vila->gambar) ?? [];

        // Proses hapus gambar
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

        // Proses upload gambar baru
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambar[] = $file->store('gambar_vila', 'public');
            }
        }

        // Cek minimal 5 gambar tersisa
        if (count($gambar) < 5) {
            return redirect()->back()->with('error', 'Minimal harus ada 5 gambar pada vila.');
        }

        // Update data
        $vila->update([
            'nama_vila' => $request->nama_vila,
            'lokasi_vila' => $request->lokasi_vila,
            'kapasitas_vila' => $request->kapasitas_vila,
            'jumlah_kamar_tidur' => $request->jumlah_kamar_tidur,
            'jumlah_tempat_tidur' => $request->jumlah_tempat_tidur,
            'jumlah_kamar_mandi' => $request->jumlah_kamar_mandi,
            'jumlah_area_parkir_mobil' => $request->jumlah_area_parkir_mobil,
            'jumlah_area_parkir_bus' => $request->jumlah_area_parkir_bus,
            'kedalaman_luas_kolam' => $request->kedalaman_luas_kolam,
            'fasilitas_tambahan_vila' => $request->fasilitas_tambahan_vila,
            'fasilitas_vila' => json_encode($request->fasilitas_vila),
            'harga_minggu_kamis' => $request->harga_minggu_kamis,
            'harga_jumat' => $request->harga_jumat,
            'harga_sabtu' => $request->harga_sabtu,
            'gambar' => json_encode(array_values($gambar)),
        ]);

        return redirect()->route('vila.index')->with('success', 'Data vila berhasil diupdate.');
    }

    public function destroy($vila_id)
    {
        $vila = Vila::findOrFail($vila_id);

        $gambar = json_decode($vila->gambar);
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
}
