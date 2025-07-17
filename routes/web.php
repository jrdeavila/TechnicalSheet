<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperatingSystemController;
use App\Http\Controllers\OperationSystemController;
use App\Http\Controllers\PeripheralTypeController;
use App\Http\Controllers\TechnicalSheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/technical-sheets/create/{type}', [TechnicalSheetController::class, 'createDevice'])->name('technicalSheet.createDevice');
    Route::resource('technical-sheets', TechnicalSheetController::class)->names('technicalSheet');
    Route::resource('peripheral-types', PeripheralTypeController::class)->names('peripheralType');
    Route::resource('features', FeatureController::class)->names('feature');
    Route::resource('operating-systems', OperationSystemController::class)->names('operatingSystem');
    Route::resource('brands', BrandController::class)
        ->except(['show', 'create', 'edit'])
        ->names('brand');
    Route::resource('users', UserController::class)->names('users');
});
