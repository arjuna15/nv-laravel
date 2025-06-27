<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/login', [AdminController::class, 'loginProcess'])->name('login');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/create-user', [AdminController::class, 'createUser'])->name('createUser');
    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('storeUser');

    Route::get('/add-villa', [AdminController::class, 'addVillaForm'])->name('addVillaForm');
    Route::post('/tambah-villa', [AdminController::class, 'tambahVilla'])->name('tambahVilla');

    Route::get('/edit-villa/{id}', [AdminController::class, 'updateVilla'])->name('editVilla');
    Route::post('/update-villa', [AdminController::class, 'updateVillas'])->name('updateVillas');

    Route::get('/add-calendar/{id}', [AdminController::class, 'addCalendarForm'])->name('addCalendar');
    Route::post('/add-calendars', [AdminController::class, 'addCalendars'])->name('addCalendars');

    Route::get('/hapus-kalender/{id}', [AdminController::class, 'hapusKalenderForm'])->name('hapusKalender');
    Route::get('/delete-booking-date/{id}', [AdminController::class, 'removeBookingDate'])->name('removeBookingDate');
    Route::get('/delete-calendar-list/{id}', [AdminController::class, 'deleteCalendarList'])->name('deleteCalendarList');

    Route::post('/delete-calendar-date', [AdminController::class, 'deleteCalendarDate'])->name('deleteCalendarDate');
    Route::post('/delete-villa', [AdminController::class, 'deleteVilla'])->name('deleteVilla');

    Route::get('/data-villa', [AdminController::class, 'dataVilla'])->name('dataVilla');

    // Untuk menampilkan form upload (GET)
    Route::get('/upload-foto/{id}', [AdminController::class, 'updateImage'])->name('updateImageForm');

    Route::post('/upload-images', [AdminController::class, 'updateImages'])->name('updateImages');

    Route::get('/calendar-villa', [AdminController::class, 'calendarVilla'])->name('calendarVilla');
});

});

// Halaman Dashboard AdminLTE
Route::get('/master', function () {
    return view('layout.master');
});

// CRUD Villa
Route::resource('vila', VilaController::class);