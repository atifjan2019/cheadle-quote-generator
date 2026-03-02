<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
Route::get('/quote/form', [QuoteController::class, 'form'])->name('quotes.form');
Route::post('/quote/save', [QuoteController::class, 'save'])->name('quotes.save');
Route::post('/quote/autosave', [QuoteController::class, 'autosave'])->name('quotes.autosave');
Route::get('/quote/delete', [QuoteController::class, 'destroy'])->name('quotes.delete');
Route::get('/quote/pdf', [QuoteController::class, 'generatePdf'])->name('quotes.pdf');
