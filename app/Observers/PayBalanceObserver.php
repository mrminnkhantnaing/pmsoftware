<?php

namespace App\Observers;

use App\Models\PayBalance;
use Illuminate\Support\Facades\Cache;

class PayBalanceObserver
{
    /**
     * Handle the PayBalance "created" event.
     *
     * @param  \App\Models\PayBalance  $payBalance
     * @return void
     */
    public function created(PayBalance $payBalance)
    {
        // Clear cache
        Cache::forget('paybalances-index');
    }

    /**
     * Handle the PayBalance "updated" event.
     *
     * @param  \App\Models\PayBalance  $payBalance
     * @return void
     */
    public function updated(PayBalance $payBalance)
    {
        // Clear cache
        Cache::forget('paybalances-index');
    }

    /**
     * Handle the PayBalance "deleted" event.
     *
     * @param  \App\Models\PayBalance  $payBalance
     * @return void
     */
    public function deleted(PayBalance $payBalance)
    {
        // Clear cache
        Cache::forget('paybalances-index');
    }

    /**
     * Handle the PayBalance "restored" event.
     *
     * @param  \App\Models\PayBalance  $payBalance
     * @return void
     */
    public function restored(PayBalance $payBalance)
    {
        //
    }

    /**
     * Handle the PayBalance "force deleted" event.
     *
     * @param  \App\Models\PayBalance  $payBalance
     * @return void
     */
    public function forceDeleted(PayBalance $payBalance)
    {
        //
    }
}
