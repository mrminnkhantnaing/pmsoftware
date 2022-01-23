<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Facades\Cache;

class CardObserver
{
    /**
     * Handle the Card "created" event.
     *
     * @param  \App\Models\Card  $card
     * @return void
     */
    public function created(Card $card)
    {
        // Clear cache
        Cache::forget('cards-index');
    }

    /**
     * Handle the Card "updated" event.
     *
     * @param  \App\Models\Card  $card
     * @return void
     */
    public function updated(Card $card)
    {
        // Clear cache
        Cache::forget('cards-index');
    }

    /**
     * Handle the Card "deleted" event.
     *
     * @param  \App\Models\Card  $card
     * @return void
     */
    public function deleted(Card $card)
    {
        // Clear cache
        Cache::forget('cards-index');
    }

    /**
     * Handle the Card "restored" event.
     *
     * @param  \App\Models\Card  $card
     * @return void
     */
    public function restored(Card $card)
    {
        //
    }

    /**
     * Handle the Card "force deleted" event.
     *
     * @param  \App\Models\Card  $card
     * @return void
     */
    public function forceDeleted(Card $card)
    {
        //
    }
}
