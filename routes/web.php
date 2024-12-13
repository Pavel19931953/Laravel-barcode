<?php

use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


// routes/web.php



Route::get('/barcodes', [BarcodeController::class, 'index'])->name('barcodes.index');
Route::post('/barcodes/pdf', [BarcodeController::class, 'generatePdf'])->name('barcodes.pdf');
Route::put('/barcodes/{page}/status', [BarcodeController::class, 'updateStatus'])->name('barcodes.updateStatus');
Route::get('/barcodes/{barcode}', [BarcodeController::class, 'show'])->name('barcodes.show'); // Новый маршрут



Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/pdf', [ProductController::class, 'generatePDF'])->name('products.generatePDF');
