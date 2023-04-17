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

Route::get('/',function(){
    return redirect()->route('loan.form');
});

Route::get('/loan',[LoanOptionController::class,'loan'])->name('loan.form');
Route::get('/credit',[LoanOptionController::class,'credit'])->name('credit.form');
Route::post('/calcule/loan',[LoanOptionController::class,'loan_calcule'])->name('loan_calcule');
Route::post('/calcule/credit',[LoanOptionController::class,'credit_calcule'])->name('credit_calcule');
