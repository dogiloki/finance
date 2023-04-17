<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanOptionController;

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

Route::get('/',[LoanOptionController::class,'index'])->name('loan_option.index');
Route::post('/loan_calcule',[LoanOptionController::class,'loan_calcule'])->name('loan_calcule');
Route::post('/credit_calcule',[LoanOptionController::class,'credit_calcule'])->name('credit_calcule');
