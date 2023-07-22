<?php

use App\Http\Controllers\BarangKeluar as ControllersBarangKeluar;
use App\Http\Controllers\BarangMasuk as ControllersBarangMasuk;
use App\Http\Controllers\CustomAuth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanBarang;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\User;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
/* Route Auth default Laravel */
// Auth::routes();

// Route::resource('main', MainController::class);
// Route::resource('main', App\Http\Controllers\MainController::class);
Route::resource('register', RegisterController::class);

Route::get('/', function () {
   return redirect(route('custom.login'));
})->name('/');

Route::get('/login', [CustomAuth::class, 'login'])->name('custom.login');
Route::post('/post-login', [CustomAuth::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [CustomAuth::class, 'customLogout'])->name('custom.logout');


Route::prefix('barang')->middleware(['auth', 'cekRole'])->group(function () {

    Route::get('/', [MainController::class, 'index'])->name('main.index');
    Route::get('/create', [MainController::class, 'create'])->name('main.create');
    Route::get('/edit/{id}', [MainController::class, 'edit'])->name('main.edit');
    Route::post('/store', [MainController::class, 'store'])->name('main.store');
    Route::put('/update/{id}', [MainController::class, 'update'])->name('main.update');
    Route::get('/destroy/{id}', [MainController::class, 'destroy'])->name('main.destroy');
    Route::get('/ajax', [MainController::class, 'ajax'])->name('main.ajax');

});

Route::prefix('stock')->middleware(['auth', 'cekRole'])->group(function () {

    Route::get('/', [StokController::class, 'index'])->name('stock.index');
    Route::get('/create', [StokController::class, 'create'])->name('stock.create');
    Route::get('/edit/{id}', [StokController::class, 'edit'])->name('stock.edit');
    Route::post('/store', [StokController::class, 'store'])->name('stock.store');
    Route::post('/update/{id}', [StokController::class, 'update'])->name('stock.update');
    Route::get('/destroy/{id}', [StokController::class, 'destroy'])->name('stock.destroy');
    Route::get('/ajax', [StokController::class, 'ajax'])->name('stock.ajax');

});

Route::prefix('barang-masuk')->middleware(['auth', 'cekRole'])->group(function () {

    Route::get('/', [ControllersBarangMasuk::class, 'index'])->name('barangMasuk');
    Route::get('/create', [ControllersBarangMasuk::class, 'create'])->name('barangMasuk.create');
    Route::get('/edit/{id}', [ControllersBarangMasuk::class, 'edit'])->name('barangMasuk.edit');
    Route::post('/store', [ControllersBarangMasuk::class, 'store'])->name('barangMasuk.store');
    Route::post('/update/{id}', [ControllersBarangMasuk::class, 'update'])->name('barangMasuk.update');
    Route::get('/destroy/{id}', [ControllersBarangMasuk::class, 'destroy'])->name('barangMasuk.destroy');
    Route::get('/ajax', [ControllersBarangMasuk::class, 'ajax'])->name('barangMasuk.ajax');
    Route::get('/export', [ControllersBarangMasuk::class, 'export'])->name('barangMasuk.export');

});

Route::prefix('barang-keluar')->middleware(['auth', 'cekRole'])->group(function () {

    Route::get('/', [ControllersBarangKeluar::class, 'index'])->name('barangKeluar');
    Route::get('/create', [ControllersBarangKeluar::class, 'create'])->name('barangKeluar.create');
    Route::get('/edit/{id}', [ControllersBarangKeluar::class, 'edit'])->name('barangKeluar.edit');
    Route::post('/store', [ControllersBarangKeluar::class, 'store'])->name('barangKeluar.store');
    Route::post('/update/{id}', [ControllersBarangKeluar::class, 'update'])->name('barangKeluar.update');
    Route::get('/destroy/{id}', [ControllersBarangKeluar::class, 'destroy'])->name('barangKeluar.destroy');
    Route::get('/ajax', [ControllersBarangKeluar::class, 'ajax'])->name('barangKeluar.ajax');

});

Route::prefix('user')->middleware(['auth', 'ownerRole'])->group(function () {

    Route::get('/', [User::class, 'index'])->name('user');
    Route::get('/create', [User::class, 'create'])->name('user.create');
    Route::get('/edit/{id}', [User::class, 'edit'])->name('user.edit');
    Route::post('/store', [User::class, 'store'])->name('user.store');
    Route::post('/update/{id}', [User::class, 'update'])->name('user.update');
    Route::get('/destroy/{id}', [User::class, 'destroy'])->name('user.destroy');
    Route::get('/ajax', [User::class, 'ajax'])->name('user.ajax');

});

Route::prefix('laporan')->middleware(['auth', 'cekRole'])->group(function () {

    Route::get('/barang-masuk', [LaporanBarang::class, 'barangMasuk'])->name('laporan.barangMasuk');
    Route::get('/barang-masuk/ajax', [LaporanBarang::class, 'barangMasukAjax'])->name('laporan.barangMasuk.ajax');
    Route::get('/barang/keluar-masuk/ajax', [LaporanBarang::class, 'barangKeluarMasukAjax'])->name('laporan.barangKeluarMasuk.ajax');
    Route::get('/export', [LaporanBarang::class, 'export'])->name('laporan.export');

});

Route::get('/home', [HomeController::class, 'index'])->name('home');


