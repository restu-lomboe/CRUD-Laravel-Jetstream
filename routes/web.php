<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ChartController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware' =>['auth:sanctum', 'verified']], function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
    Route::get('/invoice/{no_order}', [KasirController::class, 'invoice'])->name('invoice');
    Route::get('/struk/{no_order}', [KasirController::class, 'struk'])->name('struk');

    //charts controller
    Route::get('/charts', [ChartController::class, 'index'])->name('charts');

});
