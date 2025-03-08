<?php

namespace App\Observers;

use App\Models\WithDrawal;

class WithDrawalObserver
{
    /**
     * Handle the WithDrawal "created" event.
     */
    public function created(WithDrawal $withDrawal): void
    {
        //
    }

    /**
     * Handle the WithDrawal "updated" event.
     */
    public function updated(WithDrawal $withDrawal): void
    {
        //
    }

    /**
     * Handle the WithDrawal "deleted" event.
     */
    public function deleted(WithDrawal $withDrawal): void
    {
        //
    }

    /**
     * Handle the WithDrawal "restored" event.
     */
    public function restored(WithDrawal $withDrawal): void
    {
        //
    }

    /**
     * Handle the WithDrawal "force deleted" event.
     */
    public function forceDeleted(WithDrawal $withDrawal): void
    {
        //
    }
}
