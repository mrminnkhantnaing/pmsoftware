<?php

namespace App\Observers;

use App\Models\Partition;
use Illuminate\Support\Facades\Cache;

class PartitionObserver
{
    /**
     * Handle the Partition "created" event.
     *
     * @param  \App\Models\Partition  $partition
     * @return void
     */
    public function created(Partition $partition)
    {
        // Clear cache
        Cache::forget('partitions-index');
    }

    /**
     * Handle the Partition "updated" event.
     *
     * @param  \App\Models\Partition  $partition
     * @return void
     */
    public function updated(Partition $partition)
    {
        // Clear cache
        Cache::forget('partitions-index');
    }

    /**
     * Handle the Partition "deleted" event.
     *
     * @param  \App\Models\Partition  $partition
     * @return void
     */
    public function deleted(Partition $partition)
    {
        // Clear cache
        Cache::forget('partitions-index');
    }

    /**
     * Handle the Partition "restored" event.
     *
     * @param  \App\Models\Partition  $partition
     * @return void
     */
    public function restored(Partition $partition)
    {
        //
    }

    /**
     * Handle the Partition "force deleted" event.
     *
     * @param  \App\Models\Partition  $partition
     * @return void
     */
    public function forceDeleted(Partition $partition)
    {
        //
    }
}
