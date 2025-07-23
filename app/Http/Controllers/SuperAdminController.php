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
use Carbon\CarbonPeriod;


class SuperAdminController extends Controller
{

    public function detailVilla($id)
    {
        $villa = Vila::findOrFail($id);
        $villas = Vila::all();
        $reservasi = Reservasi::where('vila_id', $id)->get();
        $totalBooking = $reservasi->count();

        // Ambil bulan dari query string, default ke bulan sekarang
        $bulanString = request('month', now()->format('Y-m'));
        $bulan = \Carbon\Carbon::parse($bulanString);

        // Ambil tanggal dari awal sampai akhir bulan yg dipilih
        $startOfMonth = $bulan->copy()->startOfMonth();
        $endOfMonth = $bulan->copy()->endOfMonth();
        $period = \Carbon\CarbonPeriod::create($startOfMonth, $endOfMonth);

        $reservasiByDate = $reservasi->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->check_in_date)->format('Y-m-d');
        });

        $calendarData = [];
        foreach ($period as $date) {
            $formatted = $date->format('Y-m-d');
            $calendarData[] = [
                'tanggal' => $formatted,
                'data' => $reservasiByDate->get($formatted, collect()),
            ];
        }

        return view('superadmin.detailtanggal', compact(
            'villa',
            'villas',
            'calendarData',
            'totalBooking'
        ))->with('bulan', $bulan); // ← agar Blade bisa akses $bulan untuk navigasi
    }


    public function dataVilla()
    {
        // Ambil hanya villa yang is_owner_villa == 'yes'
        $datas = Vila::where('is_owner_villa', 'yes')->get();

        $totalUangMasuk = 0;
        $totalUangMasukBulanIni = 0;
        $today = \Carbon\Carbon::today();
        $currentMonth = $today->format('Y-m');

        $todayBookings = [];
        $monthlySummary = [];

        foreach ($datas as $datad) {
            $allBooking = Reservasi::where('vila_id', $datad->vila_id)->get();

            $datad->total_booking = $allBooking->count();

            // Ambil booking mulai bulan ini ke depan
            $bookingMulaiBulanIni = Reservasi::where('vila_id', $datad->vila_id)
                ->whereDate('check_in_date', '>=', $currentMonth . '-01')
                ->get();

            $datad->total_uang_masuk = $bookingMulaiBulanIni->sum('uang_masuk');
            $totalUangMasuk += $datad->total_uang_masuk;

            // Uang masuk bulan ini
            $bulanIniBooking = Reservasi::where('vila_id', $datad->vila_id)
                ->where('check_in_date', '>=', $currentMonth . '-01')
                ->where('check_in_date', '<=', $today->copy()->endOfMonth()->toDateString())
                ->get();

            $datad->uang_masuk_bulan_ini = $bulanIniBooking->sum('uang_masuk');
            $totalUangMasukBulanIni += $datad->uang_masuk_bulan_ini;

            // Booking hari ini
            $bookingsToday = Reservasi::where('vila_id', $datad->vila_id)
                ->whereDate('created_at', $today->toDateString())
                ->get();

            foreach ($bookingsToday as $b) {
                $todayBookings[] = $b;
            }

            // Rekap bulanan
            foreach ($allBooking as $booking) {
                $bulan = \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m');
                if (!isset($monthlySummary[$bulan])) {
                    $monthlySummary[$bulan] = [
                        'total_booking' => 0,
                        'total_uang_masuk' => 0,
                    ];
                }
                $monthlySummary[$bulan]['total_booking'] += 1;
                $monthlySummary[$bulan]['total_uang_masuk'] += $booking->uang_masuk;
            }
        }

        return view('superadmin.datavillaowner', [
            'villa' => $datas,
            'total_uang_masuk' => $totalUangMasuk,
            'total_uang_masuk_bulan_ini' => $totalUangMasukBulanIni,
            'today_bookings' => $todayBookings,
            'monthly_summary' => $monthlySummary,
        ]);
    }


    public function dataAdmin()
    {
        $today = \Carbon\Carbon::today();
        $adminSummary = [];

        // Ambil semua reservasi yang dibuat bulan ini
        $bulanIniBookings = Reservasi::whereYear('created_at', $today->year)
            ->whereMonth('created_at', $today->month)
            ->get();

        foreach ($bulanIniBookings as $booking) {
            $admin = $booking->nama_admin;

            // Lewati kalau nama_admin kosong
            if (!$admin) continue;

            if (!isset($adminSummary[$admin])) {
                $adminSummary[$admin] = [
                    'total_closing' => 0,
                    'bonus_closing' => 0,
                    'total_uang_masuk' => 0,
                    'hari_closing' => [], // untuk hitung bonus per hari
                ];
            }

            // Hitung total closing
            $adminSummary[$admin]['total_closing'] += 1;

            // Hitung total uang masuk
            $adminSummary[$admin]['total_uang_masuk'] += $booking->uang_masuk;

            // Hitung jumlah closing per hari
            $tanggal = \Carbon\Carbon::parse($booking->created_at)->toDateString();
            if (!isset($adminSummary[$admin]['hari_closing'][$tanggal])) {
                $adminSummary[$admin]['hari_closing'][$tanggal] = 0;
            }
            $adminSummary[$admin]['hari_closing'][$tanggal] += 1;
        }

        // Hitung bonus closing (setiap hari dengan minimal 3 closing, jumlahkan semua di hari itu)
        foreach ($adminSummary as $admin => &$summary) {
            foreach ($summary['hari_closing'] as $jumlahPerHari) {
                if ($jumlahPerHari >= 3) {
                    $summary['bonus_closing'] += $jumlahPerHari; // jumlahkan semua closing hari itu
                }
            }
            unset($summary['hari_closing']); // hapus biar nggak dikirim ke view
        }

        return view('superadmin.dataadmin', [
            'admin_summary' => $adminSummary,
        ]);
    }



    public function index()
    {
        $users = User::all();
        return view('superadmin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,superadmin',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('superadmin.index')->with('success', 'User berhasil ditambahkan.');
    }



}