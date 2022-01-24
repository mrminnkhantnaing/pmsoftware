<?php

use App\Mail\DailyReport;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false
]);

// Sending Routes
// Route::get('/greeting', function () {
//     $settings = Setting::where('id', 1)->first();
//     Mail::to('mr.minnkhantnaing@gmail.com')
//             ->send(new DailyReport($settings));
// });

Route::group(['middleware' => 'auth'], function() {
    // Dashboard
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users', App\Http\Controllers\Users\UserController::class)->except(['show', 'create', 'edit']);

    Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function() {
        Route::get('/new-tenants', [\App\Http\Controllers\DashboardController::class, 'newTenants'])->name('newTenants');
        Route::get('/available-partitions', [\App\Http\Controllers\DashboardController::class, 'availablePartitions'])->name('availablePartitions');
        Route::get('/partitions-on-notice', [\App\Http\Controllers\DashboardController::class, 'PartitionsOnNotice'])->name('PartitionsOnNotice');
        Route::get('/invoices-to-be-paid-within-7-days', [\App\Http\Controllers\DashboardController::class, 'invoicesToBePaidWithin7Days'])->name('invoicesToBePaidWithin7Days');
        Route::get('/dued-invoices', [\App\Http\Controllers\DashboardController::class, 'duedInvoices'])->name('duedInvoices');
        Route::get('/todays-invoices', [\App\Http\Controllers\DashboardController::class, 'todaysInvoices'])->name('todaysInvoices');
        Route::get('/to-pay-balances', [\App\Http\Controllers\DashboardController::class, 'toPayBalances'])->name('toPayBalances');

        // Operations Parts
        Route::get('/buildings/floors/flats/{id}', [\App\Http\Controllers\DashboardController::class, 'flatsShow'])->name('flatsShow');

        Route::get('/buildings/floors/{id}', [\App\Http\Controllers\DashboardController::class, 'floorsShow'])->name('floorsShow');

        Route::get('/buildings', [\App\Http\Controllers\DashboardController::class, 'buildingsIndex'])->name('buildingsIndex');
        Route::get('/buildings/{slug}', [\App\Http\Controllers\DashboardController::class, 'buildingsShow'])->name('buildingsShow');

    });

    // Analytics
    Route::group(['prefix' => '/analytics', 'as' => 'analytics.'], function() {
        Route::get('/', [\App\Http\Controllers\AnalyticController::class, 'index'])->name('index');
        Route::get('/tenants', [\App\Http\Controllers\AnalyticController::class, 'tenants'])->name('tenants');
        Route::get('/new-tenants', [\App\Http\Controllers\AnalyticController::class, 'newTenants'])->name('newTenants');
        Route::get('/active-tenants', [\App\Http\Controllers\AnalyticController::class, 'activeTenants'])->name('activeTenants');
    });

    // Settings
    Route::group(['prefix' => '/settings', 'as' => 'settings.', 'middleware' => ['permission:manage settings']], function() {
        Route::get('/general', [\App\Http\Controllers\SettingController::class, 'general'])->name('general');
        Route::post('/general-update', [\App\Http\Controllers\SettingController::class, 'updateGeneral'])->name('updateGeneral');
        Route::get('/invoice', [\App\Http\Controllers\SettingController::class, 'invoice'])->name('invoice');
        Route::post('/invoice-update', [\App\Http\Controllers\SettingController::class, 'updateInvoice'])->name('updateInvoice');
    });

    // Invoices Management
    Route::group(['prefix' => '/invoices', 'as' => 'invoices.'], function() {
        // Card Receipts
        Route::group(['prefix' => '/cards', 'as' => 'cards.'], function() {
            Route::get('/', [\App\Http\Controllers\Operations\CardReceiptController::class, 'index'])->name('index');
            Route::get('/add-new', [\App\Http\Controllers\Operations\CardReceiptController::class, 'create'])->middleware('permission:create cardreceipts')->name('create');
            Route::post('/store', [\App\Http\Controllers\Operations\CardReceiptController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Operations\CardReceiptController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [\App\Http\Controllers\Operations\CardReceiptController::class, 'edit'])->middleware('permission:edit cardreceipts')->name('edit');
            Route::post('/update/{id}', [\App\Http\Controllers\Operations\CardReceiptController::class, 'update'])->middleware('permission:edit cardreceipts')->name('update');
            Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\CardReceiptController::class, 'destroy'])->middleware('permission:delete cardreceipts')->name('destroy');

            // Export Paybalance
            Route::post('/export', [\App\Http\Controllers\Operations\CardReceiptController::class, 'export'])->name('export');

            // Print Card Receipts
            Route::get('/{id}/print', [\App\Http\Controllers\Operations\PrintController::class, 'printCardReceipts'])->name('print');
        });

        // Invoices & Transactions
        Route::group(['prefix' => '/transactions'], function() {

            // Invoice Routes
            Route::get('/', [\App\Http\Controllers\Operations\TransactionController::class, 'index'])->name('index');
            Route::get('/add-new', [\App\Http\Controllers\Operations\TransactionController::class, 'create'])->middleware('permission:create invoices')->name('create');
            Route::post('/store', [\App\Http\Controllers\Operations\TransactionController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Operations\TransactionController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [\App\Http\Controllers\Operations\TransactionController::class, 'edit'])->middleware('permission:edit invoices')->name('edit');
            Route::post('/update/{id}', [\App\Http\Controllers\Operations\TransactionController::class, 'update'])->middleware('permission:edit invoices')->name('update');
            Route::post('/update/{id}/notice', [\App\Http\Controllers\Operations\TransactionController::class, 'updateNotice'])->name('updateNotice');
            Route::post('/update/{id}/moved', [\App\Http\Controllers\Operations\TransactionController::class, 'updateMoved'])->name('updateMoved');
            Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\TransactionController::class, 'destroy'])->middleware('permission:delete invoices')->name('destroy');

            // Export Invoices
            Route::post('/export', [\App\Http\Controllers\Operations\TransactionController::class, 'export'])->name('export');

            // Print Invoices
            Route::get('/{id}/print', [\App\Http\Controllers\Operations\PrintController::class, 'printInvoices'])->name('print');
        });

        // Pay Balance
        Route::group(['prefix' => '/pay-balance', 'as' => 'balance.'], function() {
            // PayBalance Routes
            Route::get('/', [\App\Http\Controllers\Operations\PayBalanceController::class, 'index'])->name('index');
            Route::get('/add-new', [\App\Http\Controllers\Operations\PayBalanceController::class, 'create'])->middleware('permission:create paybalances')->name('create');
            Route::post('/store', [\App\Http\Controllers\Operations\PayBalanceController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Operations\PayBalanceController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [\App\Http\Controllers\Operations\PayBalanceController::class, 'edit'])->middleware('permission:edit paybalances')->name('edit');
            Route::post('/update/{id}', [\App\Http\Controllers\Operations\PayBalanceController::class, 'update'])->middleware('permission:edit paybalances')->name('update');
            Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\PayBalanceController::class, 'destroy'])->middleware('permission:delete paybalances')->name('destroy');

            // Export Paybalance
            Route::post('/export', [\App\Http\Controllers\Operations\PayBalanceController::class, 'export'])->name('export');

            // Print PayBalance
            Route::get('/{id}/print', [\App\Http\Controllers\Operations\PrintController::class, 'printPayBalance'])->name('print');
        });
    });

    // Tenants Management
    Route::group(['prefix' => '/tenants', 'as' => 'tenants.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\TenantController::class, 'index'])->name('index');
        Route::get('/add-new', [\App\Http\Controllers\Operations\TenantController::class, 'create'])->middleware('permission:create tenants')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\TenantController::class, 'store'])->name('store');
        Route::get('/{slug}', [\App\Http\Controllers\Operations\TenantController::class, 'show'])->name('show');
        Route::get('/edit/{slug}', [\App\Http\Controllers\Operations\TenantController::class, 'edit'])->middleware('permission:edit tenants')->name('edit');
        Route::post('/update/{slug}', [\App\Http\Controllers\Operations\TenantController::class, 'update'])->middleware('permission:edit tenants')->name('update');
        Route::post('/destroy/{slug}', [\App\Http\Controllers\Operations\TenantController::class, 'destroy'])->middleware('permission:delete tenants')->name('destroy');
    });

    // Referrers Management
    Route::group(['prefix' => '/referrers', 'as' => 'referrers.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\ReferrerController::class, 'index'])->name('index');
        Route::get('/add-new', [\App\Http\Controllers\Operations\ReferrerController::class, 'create'])->middleware('permission:create referrers')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\ReferrerController::class, 'store'])->name('store');
        Route::get('/{slug}', [\App\Http\Controllers\Operations\ReferrerController::class, 'show'])->name('show');
        Route::get('/edit/{slug}', [\App\Http\Controllers\Operations\ReferrerController::class, 'edit'])->middleware('permission:edit referrers')->name('edit');
        Route::post('/update/{slug}', [\App\Http\Controllers\Operations\ReferrerController::class, 'update'])->middleware('permission:edit referrers')->name('update');
        Route::post('/destroy/{slug}', [\App\Http\Controllers\Operations\ReferrerController::class, 'destroy'])->middleware('permission:delete referrers')->name('destroy');
    });

    // Notes Management
    Route::resource('notes', \App\Http\Controllers\Operations\NoteController::class);

    // Cards Management
    Route::group(['prefix' => '/cards', 'as' => 'cards.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\CardController::class, 'index'])->name('index');
        Route::get('/lost', [\App\Http\Controllers\Operations\CardController::class, 'lostCards'])->name('lostCards');
        Route::get('/available', [\App\Http\Controllers\Operations\CardController::class, 'availableCards'])->name('availableCards');
        Route::get('/active', [\App\Http\Controllers\Operations\CardController::class, 'activeCards'])->name('activeCards');
        Route::get('/add-new', [\App\Http\Controllers\Operations\CardController::class, 'create'])->middleware('permission:create cards')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\CardController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Operations\CardController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\Operations\CardController::class, 'edit'])->middleware('permission:edit cards')->name('edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Operations\CardController::class, 'update'])->middleware('permission:edit cards')->name('update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\CardController::class, 'destroy'])->middleware('permission:delete cards')->name('destroy');
    });

    // Partitions Management
    Route::group(['prefix' => 'buildings/floors/flats/partitions', 'as' => 'partitions.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\PartitionController::class, 'index'])->name('index');
        Route::get('/add-new', [\App\Http\Controllers\Operations\PartitionController::class, 'create'])->middleware('permission:create partitions')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\PartitionController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Operations\PartitionController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\Operations\PartitionController::class, 'edit'])->middleware('permission:edit partitions')->name('edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Operations\PartitionController::class, 'update'])->middleware('permission:edit partitions')->name('update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\PartitionController::class, 'destroy'])->middleware('permission:delete partitions')->name('destroy');
    });

    // Flats Management
    Route::group(['prefix' => '/buildings/floors/flats', 'as' => 'flats.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\FlatController::class, 'index'])->name('index');
        Route::get('/add-new', [\App\Http\Controllers\Operations\FlatController::class, 'create'])->middleware('permission:create flats')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\FlatController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Operations\FlatController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\Operations\FlatController::class, 'edit'])->middleware('permission:edit flats')->name('edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Operations\FlatController::class, 'update'])->middleware('permission:edit flats')->name('update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\FlatController::class, 'destroy'])->middleware('permission:delete flats')->name('destroy');
    });

    // Floors Management
    Route::group(['prefix' => '/buildings/floors', 'as' => 'floors.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\FloorController::class, 'index'])->name('index');
        Route::get('/add-new', [\App\Http\Controllers\Operations\FloorController::class, 'create'])->middleware('permission:create floors')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\FloorController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Operations\FloorController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\Operations\FloorController::class, 'edit'])->middleware('permission:edit floors')->name('edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Operations\FloorController::class, 'update'])->middleware('permission:edit floors')->name('update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Operations\FloorController::class, 'destroy'])->middleware('permission:delete floors')->name('destroy');
    });

    // Building Management
    Route::group(['prefix' => '/buildings', 'as' => 'buildings.'], function() {
        Route::get('/', [\App\Http\Controllers\Operations\BuildingController::class, 'index'])->name('index');
        Route::get('/add-new', [\App\Http\Controllers\Operations\BuildingController::class, 'create'])->middleware('permission:create buildings')->name('create');
        Route::post('/store', [\App\Http\Controllers\Operations\BuildingController::class, 'store'])->name('store');
        Route::get('/{slug}', [\App\Http\Controllers\Operations\BuildingController::class, 'show'])->name('show');
        Route::get('/edit/{slug}', [\App\Http\Controllers\Operations\BuildingController::class, 'edit'])->middleware('permission:edit buildings')->name('edit');
        Route::post('/update/{slug}', [\App\Http\Controllers\Operations\BuildingController::class, 'update'])->middleware('permission:edit buildings')->name('update');
        Route::post('/destroy/{slug}', [\App\Http\Controllers\Operations\BuildingController::class, 'destroy'])->middleware('permission:delete buildings')->name('destroy');
    });

    // Profile Management
    Route::group(['prefix' => '/{username}', 'as' => 'profile.'], function() {
        Route::get('/', [App\Http\Controllers\Auth\ProfileController::class, 'index'])->name('show');
        Route::post('/update', [App\Http\Controllers\Auth\ProfileController::class, 'update'])->name('update');
        Route::post('/update-password', [App\Http\Controllers\Auth\ProfileController::class, 'updatePassword'])->name('updatePassword');
    });


    Route::post('/send-invoice/{id}', [App\Http\Controllers\Operations\SendInvoiceController::class, 'sendInvoice'])->name('sendInvoice');
    Route::post('/send-receipt/{id}', [App\Http\Controllers\Operations\SendInvoiceController::class, 'sendReceipt'])->name('sendReceipt');

    // Ajax Routes
    Route::group(['prefix' => '/ajax'], function() {
        Route::get('/building/floor/{building_id}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectFloorsFromBuilding']);
        Route::get('/building/floor/flat/{floor_id}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectflatsFromFloor']);
        Route::get('/building/floor/flat/partition/{flat_id}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectPartitionsFromFlat']);
        Route::get('/building/floor/flat/partition/bedspace/{partition_id}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectBedspacesFromFloor']);
        Route::get('/tenants/{idorpassport}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectTenantFromIdOrPassport']);
        Route::get('/cards/{code}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectCardFromCode']);
        Route::get('/settings', [\App\Http\Controllers\Operations\AjaxController::class, 'fetchSettings']);
        Route::get('/invoices/transactions/{invoice_no}', [\App\Http\Controllers\Operations\AjaxController::class, 'selectInvoiceFromInvoiceNumber']);
    });
});
