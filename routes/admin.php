<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BanktransferController;
use App\Http\Controllers\Admin\ExtraController;

use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Admin\LockController;
use App\Http\Controllers\Admin\ReferralControl;
use App\Http\Controllers\Admin\ReferralController;

use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\UnlockController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Public\UsersController;
use App\Http\Controllers\TestController;
use App\Models\User;
use App\Models\V1\Bank\Banktransfer;
use App\Models\V1\Core\Unlock;
use App\Notifications\email\Welcome;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'admin']], function() {

    Route::get('/panel', [AdminController::class, 'index'])->name('admin');
    Route::get('/panel/users',[AdminController::class, 'usersIndex'])->name('panel.users');
    Route::get('/panel/users/{userid}', [UsersController::class, 'show'])->name('panel.users.show');
    Route::get('/panel/users/block/{id}', [UsersController::class, 'destroyUser'])->name('panel.users.block');

    Route::get('/panel/trx', [AdminController::class, 'trxIndex'])->name('panel.trx', [AdminController::class, 'trxIndex'])->name('trx.index');
    Route::get('/panel/investment', [AdminController::class,'invIndex' ])->name('panel.inv');


    Route::get('panel/search', [SearchController::class, 'admin'])->name('panel.search');

    Route::get('/panel/site/settings', [AdminController::class, 'siteSettings'])->name('panel.site.setting');
    Route::get('/panel/contacus', [ExtraController::class, 'contactus'])->name('panel.contactus');
    Route::get('panel/contact/resolve/{id}', [ExtraController::class, 'contactResolve'])->name('contact.resolve');
    Route::get('panel/contact/pop/resolve/{id}', [ExtraController::class, 'contactResolvePop'])->name('contact.resolve.pop');
    Route::get('/panel/faq', [ExtraController::class, 'faq'])->name('panel.faq');
    Route::get('/panel/faq/category', [ExtraController::class, 'faqcategory'])->name('panel.faq.cate');
    Route::post('/panel/faq/new', [ExtraController::class, 'newFaq'])->name('new.faq.cate');

    Route::post('/panel/faq/update/{id}', [ExtraController::class, 'update'])->name('faq.update');
    Route::get('/panel/faq/del/{id}', [ExtraController::class, 'faqdel'])->name('faq.del');

    Route::get('panel/wallets', [WalletController::class, 'index'])->name('admin.wallet.index');

    Route::get('api/call/wallets', [WalletController::class, 'getWalletBalance'])->name('admin.wallet.balance');
    Route::get('/mail', function(){
        $user = User::find(1);
        // var_dump($user);die;
        Notification::sendNow($user, new Welcome($user));
    });

    //Notifications
    Route::get('panel/notifications', [NotificationController::class, 'index'])->name('admin.notification.index');
    Route::post('panel/notifications/read', [NotificationController::class, 'markNotification'])->name('admin.notification.read');
    Route::post('panel/notifications/delete', [NotificationController::class, 'destroyNotification'])->name('admin.notification.delete');

    Route::get('/panel/lock/index', [LockController::class, 'indexAdminPage'])->name('lock.admin.index');
    Route::post('/panel/lock/store', [LockController::class, 'lockstore'])->name('lock.store');
    Route::get('/panel/lock/deactivate/{id}', [LockController::class, 'lockDeactivate'])->name('lock.deactivate');
    Route::get('/panel/lock/activate/{id}', [LockController::class, 'lockActivate'])->name('lock.activate');
    Route::get('/panel/referral', [ReferralController::class, 'adminIndex'])->name('ref.admin.index');

    Route::post('/panel/ref/rule', [ReferralController::class, 'setRule'])->name('ref.update.rule');

    // Route::get('/panel/wallets', [WalletController::class, 'index']);

    //Admin management routes
    Route::get('/panel/admin', [AdminController::class, 'adminManagementIndex'])->name('admin.index.page');

    //bank transfer
    Route::get('/panel/bank', [BankController::class, 'adminIndex'])->name('panel.bank.index');
    Route::post('/panel/bank', [BankController::class, 'storeBank'])->name('panel.bank.store');
    Route::get('/panel/bank/activate/{id}', [BankController::class, 'activateBank'])->name('panel.bank.activate');
    Route::get('/panel/bank/deactivate/{id}', [BankController::class, 'deactivateBank'])->name('panel.bank.deactivate');

    Route::get('/panel/banktransfer', [BanktransferController::class, 'adminBanktransfer'])->name('banktransfer.index');
    Route::get('/panel/banktransfer/debit', [BanktransferController::class, 'adminBanktransferDebit'])->name('panel.banktransfer.debit');
    Route::get('/panel/banktransfer/credit', [BanktransferController::class, 'adminBanktransferCredit'])->name('panel.banktransfer.credit');

    Route::get('/panel/bank_approve/credit/{userid}/{creditid}', [BanktransferController::class, 'approveCredit'])->name('bankcredit.approve');

    Route::get('/panel/banktransfer/search', [BanktransferController::class, 'banktransferSearch'])->name('panel.banktransfer.search');

    //lockings extra routes
    Route::get('/panel/unlock', [UnlockController::class, 'unlockindex'])->name('panel.unlock');
    Route::get('/pane/wall/unlock/{walletid}', [UnlockController::class, 'unlockWalletForUser'])->name('panel.unlock.wallet');
    Route::get('/panel/earnings', [UnlockController::class, 'adminEarning'])->name('panel.earning');
    Route::post('/panel/earnings/percentage', [UnlockController::class, 'percentageEarning'])->name('panel.earning.percentage');


});
// Route::get('/panel', [AdminController::class, 'index'])->name('admin');
// Route::get('/panel/users',[AdminController::class, 'usersIndex'])->name('panel.users');
// Route::get('/panel/users/{userid}', [UsersController::class, 'show'])->name('panel.users.show');
// Route::get('/panel/users/block/{id}', [UsersController::class, 'destroyUser'])->name('panel.users.block');

// Route::get('/panel/trx', [AdminController::class, 'trxIndex'])->name('panel.trx', [AdminController::class, 'trxIndex'])->name('trx.index');
// Route::get('/panel/investment', [AdminController::class,'invIndex' ])->name('panel.inv');


// Route::get('panel/search', [SearchController::class, 'admin'])->name('panel.search');

// Route::get('/panel/site/settings', [AdminController::class, 'siteSettings'])->name('panel.site.setting');
// Route::get('/panel/contacus', [ExtraController::class, 'contactus'])->name('panel.contactus');
// Route::get('panel/contact/resolve/{id}', [ExtraController::class, 'contactResolve'])->name('contact.resolve');
// Route::get('panel/contact/pop/resolve/{id}', [ExtraController::class, 'contactResolvePop'])->name('contact.resolve.pop');
// Route::get('/panel/faq', [ExtraController::class, 'faq'])->name('panel.faq');
// Route::get('/panel/faq/category', [ExtraController::class, 'faqcategory'])->name('panel.faq.cate');
// Route::post('/panel/faq/new', [ExtraController::class, 'newFaq'])->name('new.faq.cate');

// Route::post('/panel/faq/update/{id}', [ExtraController::class, 'update'])->name('faq.update');
// Route::get('/panel/faq/del/{id}', [ExtraController::class, 'faqdel'])->name('faq.del');

//locking or staking or investing
Route::get('/panel/lock/index', [LockController::class, 'indexAdminPage'])->name('lock.admin.index');
Route::post('/panel/lock/store', [LockController::class, 'lockstore'])->name('lock.store');
Route::get('/panel/lock/deactivate/{id}', [LockController::class, 'lockDeactivate'])->name('lock.deactivate');
Route::get('/panel/lock/activate/{id}', [LockController::class, 'lockActivate'])->name('lock.activate');
Route::get('/panel/referral', [ReferralController::class, 'adminIndex'])->name('ref.admin.index');

Route::post('/panel/ref/rule', [ReferralController::class, 'setRule'])->name('ref.update.rule');





Route::get('send', function(){
    $user = User::where('email', 'iunegbu94@yahoo.com')->first();
    Notification::sendNow($user, new Welcome($user));
});

