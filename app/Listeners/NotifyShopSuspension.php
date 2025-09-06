<?php

namespace App\Listeners;

use App\Events\ShopSuspended;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyShopSuspension implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ShopSuspended $event): void
    {
        // Log the suspension for audit purposes
        Log::info('Shop suspended', [
            'shop_id' => $event->shop->id,
            'shop_name' => $event->shop->name,
            'seller_id' => $event->shop->user_id,
            'seller_name' => $event->shop->user->name,
            'reason' => $event->reason,
            'suspended_by' => $event->suspendedBy ? $event->suspendedBy->id : null,
            'suspended_at' => now(),
        ]);

        // Here you can add additional logic like:
        // - Send email notification to seller
        // - Send notification to admin team
        // - Update external systems
        // - Send webhook notifications
        
        // Example: Send email to seller (uncomment when mail is configured)
        /*
        Mail::to($event->shop->user->email)->send(
            new ShopSuspendedMail($event->shop, $event->reason)
        );
        */
        
        // Example: Notify admin team via Slack or other channels
        // Notification::route('slack', config('services.slack.webhook'))
        //     ->notify(new ShopSuspendedNotification($event->shop, $event->reason));
    }
}
