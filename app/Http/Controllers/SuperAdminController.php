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
        $datas = Vila::getAll();
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



}