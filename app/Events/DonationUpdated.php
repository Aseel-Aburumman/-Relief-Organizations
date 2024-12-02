<?php

namespace App\Events;

use App\Models\Donation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationUpdated
{
    use Dispatchable, SerializesModels;

    public $donation;
    public $action; // Action type: 'created', 'updated', or 'deleted'
    public $previousQuantity; // Add this to hold the original quantity

    /**
     * Create a new event instance.
     *
     * @param Donation $donation
     * @param string $action
     * @param int|null $previousQuantity

     */
    public function __construct(Donation $donation, string $action, int $previousQuantity = null)
    {
        $this->donation = $donation;
        $this->action = $action;
        $this->previousQuantity = $previousQuantity;
    }
}
