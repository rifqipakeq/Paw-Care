<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\FundraisingiPhaseController;
use App\Http\Controllers\FundraisingiWithdrawalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/category/{category}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{fundraising:slug}', [FrontController::class, 'details'])->name('front.details');

Route::get('/support/{fundraising:slug}', [FrontController::class, 'support'])->name('front.support');

Route::get('/checkout/{fundraising:slug}/{totalAmountDonation}', [FrontController::class, 'checkout'])->name('front.checkout');

Route::post('/checkout/store/{fundraising:slug}/{totalAmountDonation}', [FrontController::class, 'store'])->name('front.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard',[DashboardController::class, 'index'])
    ->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function(){

        Route::resource('categories',CategoryController::class)
        ->middleware('role:owner');

        Route::resource('donaturs',DonaturController::class)
        ->middleware('role:owner');

        Route::resource('fundraisers',FundraiserController::class)
        ->middleware('role:owner')->except('index');

        Route::get('fundraisers',[FundraiserController::class, 'index'])
        ->name('fundraisers.index');

        Route::resource('fundraising_withdrawals',FundraisingiWithdrawalController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising_withdrawals/request/{fundraising}',[FundraisingiWithdrawalController::class, 'store'])
        ->middleware('role:fundraiser')
        ->name('fundraising_withdrawals.store');

        Route::resource('fundraising_phases',FundraisingiPhaseController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising_phases/update/{fundraising}',[FundraisingiPhaseController::class, 'store'])
        ->middleware('role:fundraiser')
        ->name('fundraising_phases.store');

        Route::resource('fundraisings',FundraisingController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraisings/active/{fundraising}',[FundraisingController::class, 'activate_fundraising'])
        ->middleware('role:owner')
        ->name('fundraising_withdrawals.activate_fundraising');

        Route::post('/fundraiser/apply',[DashboardController::class, 'apply_fundraiser'])
        ->name('fundraiser.apply');

        Route::get('/my-withdrawals',[DashboardController::class, 'my_withdrawals'])
        ->name('my-withdrawals');

        Route::get('/my-withdrawals/details/{fundraisingiWithdrawal}',[DashboardController::class, 'my_withdrawals_details'])
        ->name('my-withdrawals.details');

    });

});

require __DIR__.'/auth.php';
