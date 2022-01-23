<?php

namespace App\Observers;

use App\Models\CardReceipt;
use Illuminate\Support\Facades\Cache;

class CardReceiptObserver
{
    /**
     * Handle the CardReceipt "created" event.
     *
     * @param  \App\Models\CardReceipt  $cardReceipt
     * @return void
     */
    public function created(CardReceipt $cardReceipt)
    {
        // Clear cache
        Cache::forget('card-receipts-index');
    }

    /**
     * Handle the CardReceipt "updated" event.
     *
     * @param  \App\Models\CardReceipt  $cardReceipt
     * @return void
     */
    public function updated(CardReceipt $cardReceipt)
    {
        // Clear cache
        Cache::forget('card-receipts-index');
    }

    /**
     * Handle the CardReceipt "deleted" event.
     *
     * @param  \App\Models\CardReceipt  $cardReceipt
     * @return void
     */
    public function deleted(CardReceipt $cardReceipt)
    {
        // Clear cache
        Cache::forget('card-receipts-index');
    }

    /**
     * Handle the CardReceipt "restored" event.
     *
     * @param  \App\Models\CardReceipt  $cardReceipt
     * @return void
     */
    public function restored(CardReceipt $cardReceipt)
    {
        //
    }

    /**
     * Handle the CardReceipt "force deleted" event.
     *
     * @param  \App\Models\CardReceipt  $cardReceipt
     * @return void
     */
    public function forceDeleted(CardReceipt $cardReceipt)
    {
        //
    }
}
