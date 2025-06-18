<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use App\Models\VillaModels;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return view('layouts.admin', [
                'content'  => 'Admin.dash',
            ]);
        }
        return view('Admin.login');
    }

    public function loginProcess(Request $req)
    {
        $credentials = $req->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $req->session()->regenerate();

            // DEBUG
            \Log::info("Login berhasil:", Auth::guard('admin')->user()->toArray());

            return redirect()->route('admin.index');
        }

        return back()->with('error', 'Username & Password salah');
    }


    public function createUser()
    {
        if (Auth::check()) {
            return view('layouts.admin', [
                'villa'    => Villa::all(),
                'content'  => 'Admin.create_user',
                'sbactive' => 0,
            ]);
        }
        return redirect()->route('admin.index');
    }

    public function storeUser(Request $req)
    {
        $req->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'villaid'  => 'required|exists:villas,villa_id'
        ]);

        User::create([
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'roleid'   => 2,
            'idvilla'  => $req->villaid,
        ]);

        return back()->with('success_register', 'Berhasil membuat Akun Admin');
    }

    public function addVillaForm()
    {
        if (Auth::check()) {
            return view('layouts.admin', [
                'content'  => 'Admin.tambah_villa',
            ]);
        }
        return redirect()->route('admin.index');
    }

    public function addCalendarForm($id)
    {
        if (!Auth::check()) return redirect()->route('admin.index');

        $villa = Villa::with('reservations')->findOrFail($id);

        return view('layouts.admin', [
            'villa_id'   => $id,
            'nama_villa' => $villa->nama_villa,
            'data'       => [
                'villa_id'      => $villa->villa_id,
                'nama'          => $villa->nama_villa,
                'tanggal_cico'  => $villa->reservations->pluck('check_in_date'),
            ],
            'content'   => 'Admin.tambah_kalender',
            'sbactive'  => 2
        ]);
    }

    public function deleteCalendarDate(Request $req)
    {
        Villa::deleteCalendarEntry($req->villa_id, $req->delete_date);
        $msg = session()->has('success') ? 'Date deleted successfully.' : 'Failed to delete date.';
        return back()->with($msg);
    }

    public function removeBookingDate($id, Request $req)
    {
        if (!Auth::check()) return redirect()->route('admin.index');

        $success = Villa::deleteBookingDateById($id);
        return redirect()->route('admin.hapusKalender', ['id' => $req->villa_id])
                         ->with($success ? 'success' : 'error', $success ? 'Tanggal berhasil dihapus.' : 'Gagal menghapus tanggal.');
    }

    public function hapusKalenderForm($id)
    {
        if (!Auth::check()) return redirect()->route('admin.index');

        $villa = Villa::with('reservations')->findOrFail($id);

        return view('layouts.admin', [
            'villa_id'   => $id,
            'nama_villa' => $villa->nama_villa,
            'data'       => [
                'villa_id'     => $villa->villa_id,
                'nama'         => $villa->nama_villa,
                'tanggal_cico' => $villa->reservations->pluck('check_in_date'),
            ],
            'content'   => 'Admin.hapus_kalender',
            'sbactive'  => 2
        ]);
    }

    public function deleteCalendarList($id)
    {
        if (!Auth::check()) return redirect()->route('admin.index');

        $villa = Villa::findOrFail($id);

        return view('layouts.admin', [
            'villa_id'     => $id,
            'nama_villa'   => $villa->nama_villa,
            'datatanggal'  => $villa->data_pmb, // adapt sesuai kolom
            'content'      => 'Admin.delete_calendar',
            'sbactive'     => 2
        ]);
    }

    public function myCalendar($datas)
    {
        return view('layouts.calendar', ['datedata' => $datas]);
    }

    public function infotanggal()
    {
        $allVillas = Villa::all();
        $vgadata = [];

        foreach ($allVillas as $datavilla) {
            $detailvilla = json_decode($datavilla->detail_villa, true);
            $datashow = [
                "orang" => $datavilla->kapasitas_villa,
                "kamar" => $detailvilla['jumlah_kamar'] ?? 0,
                "bed" => $detailvilla['tempat_tidur'] ?? 0,
                "bath" => $detailvilla['kamar_mandi'] ?? 0,
                "park" => $detailvilla['parkir_mobil'] ?? 0
            ];

            $reservDate = $datavilla->reservations->pluck('check_in_date')->toArray();

            $getTanggal = $datavilla->tanggalVga()->first();
            $tanggalIframe = $getTanggal ? $getTanggal->data : '';

            $vgadata[$datavilla->id] = [
                "image" => $datavilla->images_villa,
                "nama" => $datavilla->nama_villa,
                "detail" => $datashow,
                "reserv" => $reservDate,
                "getTanggal" => $tanggalIframe
            ];
        }

        return view('layouts.admin', [
            'sbactive' => 4,
            'vgadata' => $vgadata,
            'content' => 'admin.kalender_semua_villa'
        ]);
    }

    public function deleteVilla(Request $request)
    {
        $villaId = $request->input('id');
        Villa::destroy($villaId);
        Session::flash('success', 'Berhasil Menghapus Villa!');
        return redirect()->route('admin.dataVilla');
    }

    public function tambahVilla(Request $request)
    {
        $namaVilla = $request->input('villa');

        $list_price = [
            'minggu_kamis' => $request->input('mk'),
            'jumat' => $request->input('jmt'),
            'sabtu_weeekend' => $request->input('sw'),
        ];

        $cek = VillaModels::where('nama_villa', $namaVilla)->first();
        if ($cek) {
            Session::flash('error', 'Villa sudah ada!');
            return redirect()->route('admin.index');
        } else {
            $villa = VillaModels::create([
                'nama_villa' => $namaVilla,
                'price_villa' => json_encode($list_price)
            ]);
            Session::flash('success_register', 'Berhasil membuat Villa');
            return redirect()->route('admin.index');
        }
    }

    public function dataVilla()
    {
        if (Auth::check()) {
            $villas = VillaModels::getAll(); // tampilkan semua, abaikan role

            return view('layouts.admin', [
                'villa' => $villas,
                'content' => 'Admin.data_villa',    
            ]);
        }
        return view('Admin.login');
    }


    public function calendarVilla()
    {
        if (Auth::guard('admin')->check()) {
            if (Session::get('role_id') == 1) {
                $datas = Villa::where('status', 1)->get();
                $vgadata = [];

                foreach ($datas as $datad) {
                    $date = $datad->reservations->pluck('check_in_date')->toArray();

                    $vgadata[] = [
                        "villa_id" => $datad->id,
                        "nama" => $datad->nama_villa,
                        "jumlah_reserv" => $date
                    ];
                }

                return view('layouts.admin', [
                    'sbactive' => 2,
                    'villa' => $vgadata,
                    'content' => 'admin.kalender_villa'
                ]);
            }
        }
        return view('admin.login');
    }

    public function updateVilla(Request $request)
    {
        $id = $request->input('id');
        $datavilla = Villa::findOrFail($id);

        return view('layouts.admin', [
            'datavilla' => $datavilla,
            'content' => 'admin.edit_villa',
            'id' => $id
        ]);
    }

    public function updateVillas(Request $request)
    {
        if (!Session::has('is_login')) {
            return view('layouts.admin', ['content' => 'admin.login']);
        }

        $id = $request->input('id');
        $datavilla = Villa::findOrFail($id);

        $facility = $request->input('fas');
        $list_price = [
            'minggu_kamis' => $request->input('mk'),
            'jumat' => $request->input('jmt'),
            'sabtu_weeekend' => $request->input('sw')
        ];

        $detail = [
            'jumlah_kamar' => $request->input('kmr'),
            'tempat_tidur' => $request->input('tmptdr'),
            'kamar_mandi' => $request->input('kmrmnd'),
            'parkir_mobil' => $request->input('pkr'),
            'tambahan' => $request->input('tmbhn')
        ];

        $datavilla->update([
            'deskripsi' => $request->input('desc'),
            'kapasitas_villa' => $request->input('kap'),
            'fasilitas' => json_encode($facility),
            'detail_villa' => json_encode($detail),
            'harga' => json_encode($list_price),
            'images_villa' => $request->input('image')
        ]);

        return view('layouts.admin', [
            'datavilla' => $datavilla,
            'content' => 'admin.edit_villa',
            'id' => $id
        ]);
    }

    public function updateImage($id)
    {

        $villa = VillaModels::find($id);
        if ($villa) {
            return view('layouts.admin', [
                'datavilla' => $villa,
                'content' => 'Admin.upload_foto',
            ]);
        } else {
            return view('Admin.login'); // atau bisa redirect()->route('login');
        }
    }
    
    

    public function updateImages(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:villa,villa_id',
            'images' => 'required|array|max:30',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $villa = VillaModels::find($request->id);
        if (!$villa) {
            return redirect()->route('admin.dataVilla')->with('error', 'Villa tidak ditemukan.');
        }

        $images = [];
        if (!empty($villa->images_villa)) {
            $decoded = json_decode($villa->images_villa, true);
            $images = is_array($decoded) ? $decoded : [];
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $originalName = $file->getClientOriginalName();
                $savePath = public_path('images/' . $originalName);

                try {
                    ImageManager::make($file->getRealPath())
                        ->encode('jpg', 85)
                        ->save($savePath);

                    array_unshift($images, ['image' => $originalName]);
                } catch (\Exception $e) {
                    \Log::error("Gagal menyimpan gambar ({$originalName}): " . $e->getMessage());
                }
            }
        }

        $villa->images_villa = json_encode($images);
        $villa->save();

        return redirect()->route('admin.updateImageForm', $villa->villa_id)
            ->with('success', 'Gambar berhasil diperbarui.');
    }


    public function addCalendars(Request $request)
    {
        if (Session::get('is_login')) {
            $villaId = $request->input('villa_id');
            $newDates = json_decode($request->input('datenew'), true);

            foreach ($newDates as $date) {
                Calendar::create([
                    'villa_id' => $villaId,
                    'check_in' => $date['check_in'],
                    'check_out' => $date['check_out'],
                ]);
            }

            Session::forget('new_dates');
            Session::flash('succes_insert', 'Berhasil menambah tanggal booking!');
            return redirect()->route('admin.addCalendar', ['id' => $villaId]);
        }

        return view('layouts.login', ['content' => 'app.login']);
    }

    public function deleteCalendars(Request $request)
    {
        if (Session::get('is_login')) {
            $villaId = $request->input('villa_id');
            $newDates = json_decode($request->input('datenew'), true);

            // Misal fungsi update tanggal di Calendar model
            Calendar::updateDates($newDates, $villaId);

            Session::flash('success_register', 'Berhasil menambah tanggal booking!');

            $roleId = Session::get('role_id');
            $vgadata = [];

            $datas = $roleId == 1
                ? Calendar::withActiveVillas()
                : Calendar::withActiveVillasById($villaId);

            foreach ($datas as $data) {
                $detail = json_decode($data->villa->detail_villa, true);

                $vgadata[] = [
                    'villa_id' => $data->villa_id,
                    'image' => $data->villa->images_villa,
                    'nama' => $data->villa->nama_villa,
                    'data' => $data->data,
                    'tanggal' => json_decode($data->data_pmb, true),
                    'detail' => [
                        'orang' => $data->villa->kapasitas_villa,
                        'kamar' => $detail['jumlah_kamar'] ?? 0,
                        'bed' => $detail['tempat_tidur'] ?? 0,
                        'bath' => $detail['kamar_mandi'] ?? 0,
                        'park' => $detail['parkir_mobil'] ?? 0,
                    ]
                ];
            }

            return view('layouts.admin.login', [
                'content' => 'app.calendarvilla',
                'villa' => $vgadata
            ]);
        }

        return view('layouts.admin.login', ['content' => 'app.login']);
    }

    public function logout()
    {
        Session::forget(['username', 'nama', 'is_login']);
        return redirect()->route('admin.login');
    }
}
