<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VilaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index'])->name('index'); // Tambahkan ini
Route::get('/filterVillas', [UserController::class, 'filterVillas'])->name('filterVillas'); // Tambahkan ini
Route::get('/list', [UserController::class, 'list'])->name('list'); // Tambahkan ini
Route::get('/kontak', [UserController::class, 'kontak'])->name('kontak'); // Tambahkan ini
Route::get('/tentang', [UserController::class, 'tentang'])->name('tentang'); // Tambahkan ini
Route::get('/detail/{villaId}/{villaName?}', [UserController::class, 'detail'])->name('user.detail');

Route::get('/login', [VilaController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [VilaController::class, 'prosesLogin']);
Route::post('/logout', [VilaController::class, 'logout'])->name('logout');


// Hanya admin & superadmin
Route::middleware(['auth', 'isadmin'])->group(function () {
    Route::get('/dashboard', [VilaController::class, 'index'])->name('dashboard');
        Route::get('/master', function () {
        return view('layout.master');
    });

    Route::get('/calendar', [VilaController::class, 'calendarVilla'])->name('calendarVilla');
    Route::get('/tambah/{vila_id}', [VilaController::class, 'tambahTanggal'])->name('vila.tambahTanggal');
    Route::post('/tambah', [VilaController::class, 'storeTanggal'])->name('vila.storeTanggal');
    Route::get('/listtanggal', [VilaController::class, 'listTanggal'])->name('listTanggal');
    Route::get('/tanggalonly/{vila_id}', [VilaController::class, 'tanggalOnly'])->name('vila.tanggalOnly');
    Route::post('/tanggalonly', [VilaController::class, 'storeTanggalOnly'])->name('vila.storeTanggalOnly');
    Route::delete('/destroy/{id}', [VilaController::class, 'destroyTanggal'])->name('vila.destroyTanggal');
    Route::delete('/vila/hapus-tanggal/{id}', [VilaController::class, 'destroyTanggalOnly'])->name('vila.destroyTanggalOnly');
    Route::get('/infotanggal', [VilaController::class, 'calendar'])->name('vila.calendar');
    Route::get('/calendar/{encodedData}', [VilaController::class, 'show'])->name('calendar.show');
    Route::patch('/vila/update-status/{id}', [VilaController::class, 'updateStatus'])->name('vila.updateStatus');
    Route::patch('/vila/{id}/pelunasan', [VilaController::class, 'pelunasan'])->name('vila.pelunasan');
    Route::patch('/vila/cicil/{id}', [VilaController::class, 'cicil'])->name('vila.cicil');
    Route::patch('/vila/{id}/batal', [VilaController::class, 'batal'])->name('vila.batal');
    Route::patch('/vila/pindah/{id}', [VilaController::class, 'pindah'])->name('vila.pindah');
    Route::get('/invoice/{id}', [VilaController::class, 'cetakInvoice'])->name('vila.invoice');
    Route::get('/invoice/pdf/{id}', [VilaController::class, 'cetakInvoicePDF'])->name('vila.cetakInvoicePDF');

    // CRUD Villa
    Route::resource('vila', VilaController::class);
});

// Hanya superadmin
Route::middleware(['auth', 'issuperadmin'])->group(function () {
    Route::get('/datavilla', [SuperAdminController::class, 'dataVilla'])->name('dataVilla');
    Route::get('/detailtanggal/{vila_id}', [SuperAdminController::class, 'detailVilla'])->name('detailVilla');
    Route::get('/datausers', [SuperAdminController::class, 'index'])->name('superadmin.index');
    Route::post('/datausers', [SuperAdminController::class, 'store'])->name('superadmin.store');
    Route::get('/dataadmin', [SuperAdminController::class, 'dataAdmin'])->name('dataAdmin');
});

