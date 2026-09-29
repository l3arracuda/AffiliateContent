<?php

use App\Http\Controllers\AffiliateCopyController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageDownloadController;
use App\Http\Controllers\MarketWatchController;
use App\Http\Controllers\ProductController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/market-watch', [MarketWatchController::class, 'index'])->name('market-watch.index');
Route::get('/products', [MarketWatchController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/{product}/affiliate-copy', AffiliateCopyController::class)->name('products.affiliate-copy');
Route::get('/products/{product}/images/download-all', [ImageDownloadController::class, 'all'])->name('products.images.download-all');
Route::get('/products/{product}/images/{image}/download', [ImageDownloadController::class, 'one'])->name('products.images.download');
Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
Route::get('/contents/create', [ContentController::class, 'create'])->name('contents.create');
Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
Route::get('/pages', fn () => view('pages.index', ['pages' => Page::withCount('contents')->get()]))->name('pages.index');
Route::get('/settings', fn () => view('settings'))->name('settings');
