<?php

namespace App\Listeners;

use App\Events\DonationUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleDonationUpdate implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param DonationUpdated $event
     * @return void
     */
    public function handle(DonationUpdated $event)
    {
        Log::info('DonationUpdated Event Triggered', [
            'donation_id' => $event->donation->id,
            'action' => $event->action,
            'previousQuantity' => $event->previousQuantity,
            'newQuantity' => $event->donation->quantity,

        ]);


        $donation = $event->donation;
        $need = $donation->need; // The associated need

        switch ($event->action) {
            case 'created':
                // Increment the donated quantity when a donation is created
                $need->increment('donated_quantity', $donation->quantity);
                break;

            case 'updated':
                // Update the donated quantity when a donation is edited
                $previousQuantity = $event->previousQuantity;
                $newQuantity = $donation->quantity;
                $need->donated_quantity = $need->donated_quantity - $previousQuantity + $newQuantity;
                $need->save();
                break;

            case 'deleted':
                // Decrement the donated quantity when a donation is deleted
                $need->decrement('donated_quantity', $donation->quantity);
                break;
        }

        // Update the need's status if fulfilled
        if ($need->donated_quantity >= $need->quantity_needed) {
            $need->update(['status' => 'Fulfilled']);
        } elseif ($need->status === 'Fulfilled' && $need->donated_quantity < $need->quantity_needed) {
            $need->update(['status' => 'Pending']);
        }
    }
}
