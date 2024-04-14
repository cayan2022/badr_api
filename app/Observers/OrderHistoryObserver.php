<?php

namespace App\Observers;

use App\Models\OrderHistory;

class OrderHistoryObserver
{
    /**
     * Handle the OrderHistory "created" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function created(OrderHistory $orderHistory)
    {
        $orderHistory->order()->update(['status_id'=>$orderHistory->substatus->status->id]);
    }

    /**
     * Handle the OrderHistory "updated" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function updated(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Handle the OrderHistory "deleted" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function deleted(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Handle the OrderHistory "restored" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function restored(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Handle the OrderHistory "force deleted" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function forceDeleted(OrderHistory $orderHistory)
    {
        //
    }
}
