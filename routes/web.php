<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false
]);

Route::group(['middleware' => 'auth'], function() {

    Route::resource('/users', App\Http\Controllers\Users\UserController::class)->except(['show', 'create', 'edit']);

    // Dashboard
    Route::controller(\App\Http\Controllers\DashboardController::class)->group(function() {
        Route::get('/', 'index')->name('dashboard');

        Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function() {
            Route::get('/new-tenants', 'newTenants')->name('newTenants');
            Route::get('/available-partitions', 'availablePartitions')->name('availablePartitions');
            Route::get('/partitions-on-notice', 'PartitionsOnNotice')->name('PartitionsOnNotice');
            Route::get('/invoices-to-be-paid-within-7-days', 'invoicesToBePaidWithin7Days')->name('invoicesToBePaidWithin7Days');
            Route::get('/dued-invoices', 'duedInvoices')->name('duedInvoices');
            Route::get('/todays-invoices', 'todaysInvoices')->name('todaysInvoices');
            Route::get('/to-pay-balances', 'toPayBalances')->name('toPayBalances');
            Route::get('/reservations', 'reservations')->name('reservations');

            // Operations Parts
            Route::get('/buildings/floors/flats/{id}', 'flatsShow')->name('flatsShow');
            Route::get('/buildings/floors/{id}', 'floorsShow')->name('floorsShow');
            Route::get('/buildings', 'buildingsIndex')->name('buildingsIndex');
            Route::get('/buildings/{slug}', 'buildingsShow')->name('buildingsShow');
        });
    });

    // Analytics
    Route::group(['controller' => \App\Http\Controllers\AnalyticController::class, 'prefix' => '/analytics', 'as' => 'analytics.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/tenants', 'tenants')->name('tenants');
        Route::get('/new-tenants', 'newTenants')->name('newTenants');
        Route::get('/active-tenants', 'activeTenants')->name('activeTenants');
    });

    // Settings
    Route::group(['controller' => \App\Http\Controllers\SettingController::class, 'prefix' => '/settings', 'as' => 'settings.', 'middleware' => ['permission:manage settings']], function() {
        Route::get('/general', 'general')->name('general');
        Route::post('/general-update', 'updateGeneral')->name('updateGeneral');
        Route::get('/invoice', 'invoice')->name('invoice');
        Route::post('/invoice-update', 'updateInvoice')->name('updateInvoice');
    });

    // Invoices Management
    Route::group(['prefix' => '/invoices', 'as' => 'invoices.'], function() {
        // Card Receipts
        Route::group(['controller' => \App\Http\Controllers\Operations\CardReceiptController::class, 'prefix' => '/cards', 'as' => 'cards.'], function() {
            Route::get('/', 'index')->name('index');
            Route::get('/add-new', 'create')->middleware('permission:create cardreceipts')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/edit/{id}', 'edit')->middleware('permission:edit cardreceipts')->name('edit');
            Route::post('/update/{id}', 'update')->middleware('permission:edit cardreceipts')->name('update');
            Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete cardreceipts')->name('destroy');

            // Export Paybalance
            Route::post('/export', 'export')->name('export');

            // Print Card Receipts
            Route::get('/{id}/print', [\App\Http\Controllers\Operations\PrintController::class, 'printCardReceipts'])->name('print');
        });

        // Invoices & Transactions
        Route::group(['controller' => \App\Http\Controllers\Operations\TransactionController::class, 'prefix' => '/transactions'], function() {

            // Invoice Routes
            Route::get('/', 'index')->name('index');
            Route::get('/add-new', 'create')->middleware('permission:create invoices')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/edit/{id}', 'edit')->middleware('permission:edit invoices')->name('edit');
            Route::post('/update/{id}', 'update')->middleware('permission:edit invoices')->name('update');
            Route::post('/update/{id}/notice', 'updateNotice')->name('updateNotice');
            Route::post('/update/{id}/moved', 'updateMoved')->name('updateMoved');
            Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete invoices')->name('destroy');

            // Export Invoices
            Route::post('/export', 'export')->name('export');

            // Print Invoices
            Route::get('/{id}/print', [\App\Http\Controllers\Operations\PrintController::class, 'printInvoices'])->name('print');
        });

        // Pay Balance
        Route::group(['controller' => \App\Http\Controllers\Operations\PayBalanceController::class, 'prefix' => '/pay-balance', 'as' => 'balance.'], function() {
            // PayBalance Routes
            Route::get('/', 'index')->name('index');
            Route::get('/add-new', 'create')->middleware('permission:create paybalances')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/edit/{id}', 'edit')->middleware('permission:edit paybalances')->name('edit');
            Route::post('/update/{id}', 'update')->middleware('permission:edit paybalances')->name('update');
            Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete paybalances')->name('destroy');

            // Export Paybalance
            Route::post('/export', 'export')->name('export');

            // Print PayBalance
            Route::get('/{id}/print', [\App\Http\Controllers\Operations\PrintController::class, 'printPayBalance'])->name('print');
        });
    });

    // Tenants Management
    Route::group(['controller' => \App\Http\Controllers\Operations\TenantController::class, 'prefix' => '/tenants', 'as' => 'tenants.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/add-new', 'create')->middleware('permission:create tenants')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/edit/{slug}', 'edit')->middleware('permission:edit tenants')->name('edit');
        Route::post('/update/{slug}', 'update')->middleware('permission:edit tenants')->name('update');
        Route::post('/destroy/{slug}', 'destroy')->middleware('permission:delete tenants')->name('destroy');
    });

    // Referrers Management
    Route::group(['controller' => \App\Http\Controllers\Operations\ReferrerController::class, 'prefix' => '/referrers', 'as' => 'referrers.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/add-new', 'create')->middleware('permission:create referrers')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/edit/{slug}', 'edit')->middleware('permission:edit referrers')->name('edit');
        Route::post('/update/{slug}', 'update')->middleware('permission:edit referrers')->name('update');
        Route::post('/destroy/{slug}', 'destroy')->middleware('permission:delete referrers')->name('destroy');
    });

    // Notes Management
    Route::resource('notes', \App\Http\Controllers\Operations\NoteController::class);

    // Cards Management
    Route::group(['controller' => \App\Http\Controllers\Operations\CardController::class, 'prefix' => '/cards', 'as' => 'cards.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/lost', 'lostCards')->name('lostCards');
        Route::get('/available', 'availableCards')->name('availableCards');
        Route::get('/active', 'activeCards')->name('activeCards');
        Route::get('/add-new', 'create')->middleware('permission:create cards')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->middleware('permission:edit cards')->name('edit');
        Route::post('/update/{id}', 'update')->middleware('permission:edit cards')->name('update');
        Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete cards')->name('destroy');
    });

    // Partitions Management
    Route::group(['controller' => \App\Http\Controllers\Operations\PartitionController::class, 'prefix' => 'buildings/floors/flats/partitions', 'as' => 'partitions.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/add-new', 'create')->middleware('permission:create partitions')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->middleware('permission:edit partitions')->name('edit');
        Route::post('/update/{id}', 'update')->middleware('permission:edit partitions')->name('update');
        Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete partitions')->name('destroy');
    });

    // Flats Management
    Route::group(['controller' => \App\Http\Controllers\Operations\FlatController::class, 'prefix' => '/buildings/floors/flats', 'as' => 'flats.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/add-new', 'create')->middleware('permission:create flats')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->middleware('permission:edit flats')->name('edit');
        Route::post('/update/{id}', 'update')->middleware('permission:edit flats')->name('update');
        Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete flats')->name('destroy');
    });

    // Floors Management
    Route::group(['controller' => \App\Http\Controllers\Operations\FloorController::class, 'prefix' => '/buildings/floors', 'as' => 'floors.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/add-new', 'create')->middleware('permission:create floors')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->middleware('permission:edit floors')->name('edit');
        Route::post('/update/{id}', 'update')->middleware('permission:edit floors')->name('update');
        Route::post('/destroy/{id}', 'destroy')->middleware('permission:delete floors')->name('destroy');
    });

    // Building Management
    Route::group(['controller' => \App\Http\Controllers\Operations\BuildingController::class, 'prefix' => '/buildings', 'as' => 'buildings.'], function() {
        Route::get('/', 'index')->name('index');
        Route::get('/add-new', 'create')->middleware('permission:create buildings')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/edit/{slug}', 'edit')->middleware('permission:edit buildings')->name('edit');
        Route::post('/update/{slug}', 'update')->middleware('permission:edit buildings')->name('update');
        Route::post('/destroy/{slug}', 'destroy')->middleware('permission:delete buildings')->name('destroy');
    });

    // Profile Management
    Route::group(['controller' => App\Http\Controllers\Auth\ProfileController::class, 'prefix' => '/{username}', 'as' => 'profile.'], function() {
        Route::get('/', 'index')->name('show');
        Route::post('/update', 'update')->name('update');
        Route::post('/update-password', 'updatePassword')->name('updatePassword');
    });

    Route::group(['controller' => App\Http\Controllers\Operations\SendInvoiceController::class], function() {
        Route::post('/send-invoice/{id}', 'sendInvoice')->name('sendInvoice');
        Route::post('/send-receipt/{id}', 'sendReceipt')->name('sendReceipt');
    });


    // Ajax Routes
    Route::group(['controller' => \App\Http\Controllers\Operations\AjaxController::class, 'prefix' => '/ajax'], function() {
        Route::get('/building/floor/{building_id}', 'selectFloorsFromBuilding');
        Route::get('/building/floor/flat/{floor_id}', 'selectflatsFromFloor');
        Route::get('/building/floor/flat/partition/{flat_id}', 'selectPartitionsFromFlat');
        Route::get('/building/floor/flat/partition/bedspace/{partition_id}', 'selectBedspacesFromFloor');
        Route::get('/tenants/{idorpassport}', 'selectTenantFromIdOrPassport');
        Route::get('/cards/{code}', 'selectCardFromCode');
        Route::get('/settings', 'fetchSettings');
        Route::get('/invoices/transactions/{invoice_no}', 'selectInvoiceFromInvoiceNumber');
    });
});
