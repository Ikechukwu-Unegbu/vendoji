<?php

use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BanktransferController;
use App\Http\Controllers\Admin\LockController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Public\MiscController;
use App\Http\Controllers\Public\NotificationController;
use App\Http\Controllers\Public\PagesController;
use App\Http\Controllers\Public\UsersController;
use App\Models\V1\Bank\Banktransfer;
use App\Http\Controllers\Wallet\WalletController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PagesController::class, 'index'])->name('public.home');

// Route::post('/newsletter', [MiscController::class, 'storeNewsletter'])->name('newsletter');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
    Route::get('/settings/{username}', [UsersController::class, 'userSetting'])->name('settings');
    Route::get('/profile/{username}', [UsersController::class, 'userProfile'])->name('profile');
    Route::post('/profile/image/{user:id}/delete', [UsersController::class, 'userProfileImage'])->name('profile.image');
    Route::post('/profile/password/{user:id}/update', [UsersController::class, 'userProfilePassword'])->name('profile.password');
    Route::post('profile/{user:id}/update', [UsersController::class, 'userProfileUpdate'])->name('profile.update');
    Route::get('/security', [UsersController::class, 'scurity'])->name('security');
    Route::get('/faq', [PagesController::class, 'faq'])->name('faq');
    Route::get('/contactus', [PagesController::class, 'contactus'])->name('contactus');
    Route::post('/contactus', [MiscController::class, 'contactusStore'])->name('contact.store');
    Route::get('/about', [MiscController::class, 'about'])->name('about.us');


    Route::get('/dashboard/funding', [PaymentController::class, 'fundingIndex'])->name('funding.index');
    //Payment
    Route::post('payment/fiat', [PaymentController::class, 'initiate'])->name('payment.initiate');
    //Wallet
    Route::get('/dashboard/wallets', [WalletController::class, 'walletIndex'])->name('wallets.index');
    Route::post('wallet/create', [WalletController::class, 'newWallet'])->name('wallet.create');

    Route::get('dashboard/withdrawal', [PagesController::class, 'withdrawalIndex'])->name('withdrawal.index');
    Route::post('dashboard/withdrawal/create', [PaymentController::class, 'withdrawalInitialize'])->name('withdrawal.create');
    Route::get('/dashboard/withdrawal/otp/{otp:slug}/trx/{transaction:id}', [PagesController::class, 'otpIndex'])->name('otp.index');
    Route::post('/dashboard/withdrawal/otp/verified/{otp:slug}/trx/{transaction:id}', [PaymentController::class, 'otpVerify'])->name('otp.verified');


    //Charts
    Route::get('btc', [PagesController::class, 'BitCoin'])->name('BitCoin');
    Route::get('usd', [PagesController::class, 'USDCoin'])->name('UsdCoin');




    //fiat based withdrawal.
    Route::get('/debit/offline/{id}', [BanktransferController::class, 'userDebit'])->name('offline.debit');
    Route::get('/debit/finale/{id}', [BanktransferController::class, 'debitFinale'])->name('debit.finale');
    Route::post('/debit/{id}', [BanktransferController::class, 'initDebit'])->name('debit.store');
    Route::get('/credit/offline', [BanktransferController::class, 'userCredit'])->name('credit.offline');
    Route::post('/credit/{id}', [BanktransferController::class, 'initCredit'])->name('credit.store');
    Route::get('credit/finale/{banktransferID}', [BanktransferController::class, 'creditFinale'])->name('credit.finale');


    Route::post('/lock/{id}', [LockController::class, 'lockMyFund'])->name('user.lock');
    Route::post('/cancel/lock/{id}/{lockid}', [LockController::class, 'cancelMyLock'])->name('user.lock.cancel');

});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/feature.php';
