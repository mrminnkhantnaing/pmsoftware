<?php

namespace App\Providers;

use App\Observers\CardObserver;
use App\Observers\CardReceiptObserver;
use App\Observers\PayBalanceObserver;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Transaction::observe(TransactionObserver::class); // Observe transaction class
        \App\Models\PayBalance::observe(PayBalanceObserver::class); // Observe paybalance class
        \App\Models\CardReceipt::observe(CardReceiptObserver::class); // Observe card receipt class
        \App\Models\Card::observe(CardObserver::class); // Observe card class
    }
}
