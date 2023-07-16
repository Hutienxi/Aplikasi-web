<?php
use App\Http\Controllers\MainController;
use App\Http\Controllers\ItemController;
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
Auth::routes();

// Route::resource('main', MainController::class);
Route::resource('item', ItemController::class);
// Route::resource('main', App\Http\Controllers\MainController::class);

Route::get('/', function () {
   return redirect(route('login'));
})->name('/');


Route::prefix('main')->middleware(['auth'])->group(function () {

    Route::get('/index', [MainController::class, 'index'])->name('main.index');
    Route::get('/create', [MainController::class, 'create'])->name('main.create');
    Route::get('/edit/{id}', [MainController::class, 'edit'])->name('main.edit');
    Route::post('/store', [MainController::class, 'store'])->name('main.store');
    Route::put('/update/{id}', [MainController::class, 'update'])->name('main.update');
    Route::get('/destroy/{id}', [MainController::class, 'destroy'])->name('main.destroy');
    Route::get('/ajax', [App\Http\Controllers\MainController::class, 'ajax'])->name('main.ajax');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


