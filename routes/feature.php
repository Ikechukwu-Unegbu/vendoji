<?php

use App\Http\Controllers\Admin\BanktransferController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\ReferralController;
use Illuminate\Support\Facades\Route;

//Newsletter
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter');



Route::group(['middleware' => 'auth'], function() {

    Route::post('dashboard/wallet/coin-transfer', [\App\Http\Controllers\Wallet\WalletController::class, 'coinTransfer'])->name('wallet.coin.transfer');

    Route::get('panel/management', [\App\Http\Controllers\Admin\AdminController::class, 'management'])->name('panel.admins');

    Route::post('panel/management/{user:id}/appoint', [\App\Http\Controllers\Admin\AdminController::class, 'appointUser'])->name('panel.admins.appoint');
    Route::post('panel/management/{user:id}/revoke', [\App\Http\Controllers\Admin\AdminController::class, 'revokeUser'])->name('panel.admins.revoke');

    Route::get('panel/locations', [\App\Http\Controllers\Admin\AdminController::class, 'userLocations'])->name('panel.user.location.index');
    Route::post('panel/search/wallet/user', [\App\Http\Controllers\Admin\WalletController::class, 'search'])->name('panel.wallet.user');

    Route::post('panel/user/wallet/create', [\App\Http\Controllers\Admin\WalletController::class, 'adminCreateWalletForUser'])->name('panel.admin.wallet.create');

    //Notifications
    Route::get('dashboard/notifications', [\App\Http\Controllers\Public\NotificationController::class, 'index'])->name('user.notification.index');
    Route::get('dashboard/notifications/{notification:id}/show', [\App\Http\Controllers\Public\NotificationController::class, 'show'])->name('user.notification.show');

    Route::get('dashboard/notifications', [\App\Http\Controllers\Public\NotificationController::class, 'index'])->name('user.notification.index');
    Route::post('dashboard/notifications/read', [\App\Http\Controllers\Public\NotificationController::class, 'markNotification'])->name('user.notification.read');
    Route::post('dashboard/notifications/delete', [\App\Http\Controllers\Public\NotificationController::class, 'destroyNotification'])->name('user.notification.delete');

    Route::get('panel/settings/wallets', [\App\Http\Controllers\Admin\SettingsController::class,  'masterWallets'])->name('panel.admin.settings.wallet');
    Route::post('panel/settings/wallet/transfer', [\App\Http\Controllers\Admin\SettingsController::class,  'masterCoinTransfer'])->name('panel.admin.wallet.transfer');
    Route::get('/panel/wallet/search',  [\App\Http\Controllers\Admin\SettingsController::class, 'userWalletSearch'])->name('panel.admin.walletadddress.search');

    Route::post('panel/bank-transfer/{transfer:id}', [BanktransferController::class, 'amountToCreditUserCreditRequest'])->name('panel.admin.amounttocredit.store');
    Route::post('panel/bank-transfer/credit/approval/{transfer:id}', [BanktransferController::class, 'approvalUserCreditRequest'])->name('panel.admin.credit.approval');
    Route::post('panel/bank-transfer/debit/approval/{transfer:id}', [BanktransferController::class, 'approvalUserDebitRequest'])->name('panel.admin.debit.approval');

    Route::get('panel/newsletters', [NewsletterController::class, 'index'])->name('panel.admin.newsletter.index');

    Route::post('panel/faq/store', [ExtraController::class, 'storeFaq'])->name('panel.admin.faq.create');

    Route::post('panel/faq/category/{faqcategory:id}/edit', [ExtraController::class, 'editFaqCategory'])->name('panel.admin.faqcategory.edit');
    Route::post('panel/faq/category/{faqcategory:id}/delete', [ExtraController::class, 'destroyFaqCategory'])->name('panel.admin.faqcategory.delete');

    Route::get('panel/homesettings', [HomeSettingsController::class, 'index'])->name('panel.admin.homesettings.index');
    Route::post('panel/homesettings/contact/update', [HomeSettingsController::class, 'contactUpdate'])->name('panel.admin.homesettings.contact.update');
    Route::post('panel/homesettings/logo/update', [HomeSettingsController::class, 'logoUpdate'])->name('panel.admin.homesettings.logo.update');
    Route::post('panel/homesettings/logo/delete', [HomeSettingsController::class, 'logoDestroy'])->name('panel.admin.homesettings.logo.delete');

    Route::post('panel/referral/user/{user:id}/update/code', [ReferralController::class, 'updateRefCode'])->name('panel.admin.refcode.update');
});
