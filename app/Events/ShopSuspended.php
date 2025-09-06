<?php

namespace App\Events;

use App\Models\Shop;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShopSuspended
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shop;
    public $reason;
    public $suspendedBy;

    /**
     * Create a new event instance.
     */
    public function __construct(Shop $shop, string $reason, $suspendedBy = null)
    {
        $this->shop = $shop;
        $this->reason = $reason;
        $this->suspendedBy = $suspendedBy;
    }
}
