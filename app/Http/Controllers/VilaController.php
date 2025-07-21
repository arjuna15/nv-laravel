<?php

namespace App\Http\Controllers;

use App\Models\Vila;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageManager;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // tambahkan paling atas


class VilaController extends Controller
{

    public function showLogin()
    {
        return view('vila.login');
    }

    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:30', 'exists:users,username'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.exists' => 'Username tidak ditemukan',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/master');
        }

        return back()->withErrors([
            'password' => 'Password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function login(Request $request)
    {
        // Validasi pakai username, bukan email
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/master');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }


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

            'detail.jumlah_kamar' => 'required|integer',
            'detail.jumlah_tempat_tidur' => 'required|integer',
            'detail.jumlah_kamar_mandi' => 'required|integer',
            'detail.jumlah_parkir' => 'required|integer',

            'harga_villa.minggu_kamis' => 'required|numeric',
            'harga_villa.jumat' => 'required|numeric',
            'harga_villa.sabtu' => 'required|numeric',

            'gambar' => 'required|array|min:1',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:50240',
        ]);


        $gambar = [];

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originalName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $originalName); // bersihkan nama
                $fileName = $originalName . '_' . uniqid() . '.webp'; // pastikan unik

                $savePath = public_path('images/' . $fileName);
                try {
                    $image = ImageManager::make($file->getRealPath());

                    // Resize kalau dimensi terlalu besar (misal > 4000px)
                    if ($image->width() > 4000 || $image->height() > 4000) {
                        $image->resize(1920, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    $image->encode('webp', 85)->save($savePath);
                    $gambar[] = ['image' => $fileName];
                } catch (\Exception $e) {
                    \Log::error("Gagal convert: " . $e->getMessage());
                    return back()->withErrors(['gambar' => 'Gagal memproses gambar.'])->withInput();
                }

            }
        }

        Vila::create([
            'nama_vila' => $request->nama_vila,
            'lokasi_vila' => $request->lokasi_vila,
            'kapasitas_vila' => $request->kapasitas_vila,
            'detail' => $request->input('detail'),
            'kedalaman_luas_kolam' => $request->kedalaman_luas_kolam,
            'fasilitas_tambahan_vila' => $request->fasilitas_tambahan_vila,
            'fasilitas_vila' => $request->input('fasilitas_vila'),
            'harga_villa' => $request->input('harga_villa'),
            'gambar' => $gambar, // sudah array
            'status_villa' => 1,
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
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:50240',
        ]);

        $gambarLama = json_decode($vila->gambar, true) ?? [];

        // Hapus gambar yang ditandai
        if ($request->hapus_gambar) {
            foreach ($request->hapus_gambar as $fileName) {
                $path = public_path('images/' . $fileName);
                if (file_exists($path)) {
                    unlink($path);
                }

                // Hapus dari array lama
                $gambarLama = array_filter($gambarLama, function ($g) use ($fileName) {
                    return $g['image'] !== $fileName;
                });
            }
        }

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $fileName = Str::slug($originalName) . '-' . uniqid() . '.' . $ext;

                $savePath = public_path('images/' . $fileName);

                try {
                    ImageManager::make($file->getRealPath())
                        ->encode('jpg', 85)
                        ->save($savePath);

                    $gambarLama[] = ['image' => $fileName];
                } catch (\Exception $e) {
                    \Log::error("Gagal menyimpan gambar ($fileName): " . $e->getMessage());
                }
            }
        }

        if (count($gambarLama) < 5) {
            return redirect()->back()->with('error', 'Minimal harus ada 5 gambar pada vila.');
        }

        // Update vila
        $vila->update([
            'nama_vila' => $request->nama_vila,
            'lokasi_vila' => $request->lokasi_vila,
            'kapasitas_vila' => $request->kapasitas_vila,
            'detail' => $request->detail,
            'kedalaman_luas_kolam' => $request->kedalaman_luas_kolam,
            'fasilitas_tambahan_vila' => $request->fasilitas_tambahan_vila,
            'fasilitas_vila' => $request->fasilitas_vila,
            'harga_villa' => $request->harga_villa,
            'gambar' => json_encode(array_values($gambarLama)),
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
        $today = Carbon::today()->toDateString();

        foreach ($datas as $datad) {
            $allBooking = Reservasi::where('vila_id', $datad->vila_id)->get();

            $todayBooking = Reservasi::where('vila_id', $datad->vila_id)
                ->whereDate('created_at', $today)
                ->get();

            $todayFormatted = [];
            foreach ($todayBooking as $reserv) {
                $todayFormatted[] = [
                    'no' => $reserv->no,
                    'nama_tamu' => $reserv->nama_tamu,
                    'no_hp' => $reserv->no_hp,
                    'check_in' => $reserv->check_in_date,
                    'check_out' => $reserv->check_out_date,
                    'total' => $reserv->total,
                    'uang_masuk' => $reserv->uang_masuk,
                    'sisa' => $reserv->sisa,
                    'pelunasan' => $reserv->pelunasan,
                    'catatan' => $reserv->catatan,
                    'status' => $reserv->status,
                ];
            }

            // ✅ Inisialisasi di sini
            $unpaidFormatted = [];

            $unpaid = Reservasi::where('vila_id', $datad->vila_id)
                ->whereIn('status', ['Belum Lunas', 'Cicil'])
                ->whereDate('pelunasan', '<=', $today)
                ->orderBy('pelunasan', 'asc')
                ->get();

            foreach ($unpaid as $reserv) {
                $unpaidFormatted[] = [
                    'id' => $reserv->id,
                    'no' => $reserv->no,
                    'nama_tamu' => $reserv->nama_tamu,
                    'no_hp' => $reserv->no_hp,
                    'check_in' => $reserv->check_in_date,
                    'check_out' => $reserv->check_out_date,
                    'total' => $reserv->total,
                    'uang_masuk' => $reserv->uang_masuk,
                    'sisa' => $reserv->sisa,
                    'pelunasan' => $reserv->pelunasan,
                    'catatan' => $reserv->catatan,
                    'status' => $reserv->status,
                ];
            }

            $vgadata[] = [
                "vila_id" => $datad->vila_id,
                "nama_vila" => $datad->nama_vila,
                "total_booking" => $allBooking->count(),
                "today_bookings" => $todayFormatted,
                "unpaid_pelunasan" => $unpaidFormatted
            ];
        }

        return view('vila.datakalender', ['villa' => $vgadata]);
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Belum Lunas,Lunas,Cicil,Batal',
        ]);

        $reservasi = Reservasi::findOrFail($id);

        if ($request->status === 'Lunas') {
            $reservasi->uang_masuk = $reservasi->total;
            $reservasi->sisa = 0;
        }

        if ($request->status === 'Batal') {
            $reservasi->total = $reservasi->uang_masuk;
            $reservasi->sisa = 0;
            $reservasi->catatan = $request->catatan ?? 'Dibatalkan tanpa catatan';
        }

        $reservasi->status = $request->status;
        $reservasi->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function pelunasan($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Update status jadi Lunas dan sisa jadi 0
        $reservasi->update([
            'status' => 'Lunas',
            'sisa' => 0,
        ]);

        return redirect()->back()->with('success', 'Status pelunasan berhasil diubah menjadi Lunas.');
    }




    public function cicil(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1'
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $jumlah = $request->jumlah;

        // Tambah ke uang_masuk
        $uangMasukBaru = (int)$reservasi->uang_masuk + $jumlah;
        $sisaBaru = (int)$reservasi->total - $uangMasukBaru;

        $status = 'Belum Lunas';
        if ($sisaBaru <= 0) {
            $status = 'Lunas';
            $sisaBaru = 0;
        } elseif ($uangMasukBaru > 0 && $uangMasukBaru < $reservasi->total) {
            $status = 'Cicil';
        }

        $reservasi->update([
            'uang_masuk' => $uangMasukBaru,
            'sisa' => $sisaBaru,
            'status' => $status,
        ]);
        
        if ($request->filled('pelunasan')) {
                $dataUpdate['pelunasan'] = $request->pelunasan;
            }

        $reservasi->update($dataUpdate);

        return back()->with('success', 'Cicilan berhasil ditambahkan.');
    }

    public function pindah(Request $request, $id)
    {
        $request->validate([
            // 'villa_id_baru' => 'required|exists:villas,id',
            'checkin_baru' => 'required|date',
            'checkout_baru' => 'required|date|after_or_equal:checkin_baru',
            'total' => 'required|numeric',
            'uang_masuk' => 'required|numeric',
            'pelunasan' => 'required|date',
        ]);

        $sisa = $request->total - $request->uang_masuk;
        $reservasi = Reservasi::findOrFail($id);

        // $reservasi->vila_id = $request->villa_id_baru;
        $reservasi->check_in_date = $request->checkin_baru;
        $reservasi->check_out_date = $request->checkout_baru;
        $reservasi->catatan = $request->catatan;

        // Data pembayaran
        $reservasi->total = $request->total;
        $reservasi->uang_masuk = $request->uang_masuk;
        $reservasi->sisa = $sisa;
        $reservasi->pelunasan = $request->pelunasan;

        $reservasi->save();

        return redirect()->back()->with('success', 'Data reservasi berhasil diperbarui.');
    }



    public function sendToGoogleForm($reservasi)
    {
        $url = 'https://docs.google.com/forms/d/e/1FAIpQLSdubZ-jDxzJ-Oc4pRPU_lf5U1ZaGHHboL3XdJdOBwyfNk0zTQ/formResponse';

        // Pastikan locale Carbon dalam Bahasa Indonesia
        Carbon::setLocale('id');

        $data = [
            'entry.596168328' => $reservasi->no,
            'entry.1680845292' => $reservasi->nama_tamu,
            'entry.339184750' => $reservasi->vila->nama_vila ?? 'Tidak Diketahui',
            'entry.1066245962' => Carbon::parse($reservasi->check_in_date)->translatedFormat('d F Y'),
            'entry.783451766' => $reservasi->total,
            'entry.109554030' => $reservasi->uang_masuk,
            'entry.715474057' => $reservasi->sisa,
            'entry.1925620616' => Carbon::parse($reservasi->pelunasan)->translatedFormat('d F Y'),
            'entry.1011407538' => $reservasi->catatan,
            'entry.342183189' => $reservasi->no_hp,
        ];

        Http::asForm()->post($url, $data);
    }



    public function tambahTanggal($id)
    {
        $villa = Vila::getById($id);
        $reservasi = Reservasi::where('vila_id', $id)->orderBy('check_in_date', 'asc')->get();
        $villas = Vila::all(); // ✅ tambahkan ini

        return view('vila.tambah_kalender', compact('villa', 'reservasi', 'villas'));
    }


    public function storeTanggal(Request $request)
    {
        $data = $request->only([
            'vila_id', 'no', 'nama_tamu', 'check_in_date', 'check_out_date',
            'total', 'uang_masuk', 'sisa', 'pelunasan', 'catatan', 'no_hp', 'status'
        ]);

        $reservasi = Reservasi::create($data); // <-- simpan

        // 🔽 Panggil untuk kirim ke Google Form
        $this->sendToGoogleForm($reservasi);

        return redirect()->back()->with('success', 'Reservasi berhasil Ditambah.');
    }



    public function destroyTanggal($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->back()->with('success', 'Reservasi berhasil dihapus.');
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

            $reservasi = Reservasi::where('vila_id', $villa->vila_id)
                ->where('status', '!=', 'Batal') // Tambahkan ini
                ->get();

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


    public function show($encodedData)
    {
        // Decode dari base64 dan parse JSON
        $decoded = base64_decode($encodedData, true);
        $rawDates = json_decode($decoded, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            abort(400, 'Invalid booking data');
        }

        // Potong tanggal agar jadi YYYY-MM-DD (tanpa waktu)
        $dates = array_map(function ($item) {
            return substr($item, 0, 10);
        }, $rawDates);

        // Encode ulang sebagai base64 untuk dikirim ke Blade
        return view('layout.calendar', [
            'datedata' => base64_encode(json_encode($dates))
        ]);
    }

    public function cetakInvoice($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $villa = Vila::findOrFail($reservasi->vila_id);

        return view('vila.invoice', [
            'reservasi' => $reservasi,
            'villa' => $villa
        ])->setPaper('a4', 'portrait');
    }

public function cetakInvoicePDF($id)
{
    $reservasi = Reservasi::findOrFail($id); // hanya satu data
    $villa = Vila::findOrFail($reservasi->vila_id);

    $pdf = Pdf::loadView('vila.invoice_pdf', [
        'reservasi' => $reservasi,
        'villa' => $villa,
    ]);

    return $pdf->download('invoice-' . $reservasi->id . '.pdf');
}

}
