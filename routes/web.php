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

Route::resource('main', MainController::class);
Route::resource('item', ItemController::class);
Route::resource('main', App\Http\Controllers\MainController::class);
Route::get('main/create', [MainController::class, 'create'])->name('main.create');
Route::get('main/edit/{id}', [MainController::class, 'edit'])->name('main.edit');
Route::get('main/destroy/{id}', [MainController::class, 'destroy'])->name('main.destroy');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


