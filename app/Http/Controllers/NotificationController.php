<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminNotification;
use App\Notifications\BuyerNotification;
use App\Notifications\SellerNotification;

class NotificationController extends Controller
{
    public function index(Request $request, string $type)
    {
        $user = auth()->user();

        $notifications = $user->notifications()
            ->where('type', $this->mapTypeToNotificationClass($type))
            ->orderByRaw('read_at IS NULL DESC')
            ->latest()
            ->paginate(10);

        $view = match ($type) {
            'admin'  => 'admin.notifications.index',
            'seller' => 'seller.notifications.index',
        };

        return view($view, compact('notifications', 'type'));
    }

    public function markAsRead(Request $request, string $id)
    {
        $user = auth()->user();

        $notification = $user->notifications()->findOrFail($id);

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notifikasi sudah ditandai sebagai dibaca');
    }

    private function mapTypeToNotificationClass(string $type): string
    {
        return match ($type) {
            'admin'  => AdminNotification::class,
            'seller' => SellerNotification::class,
            'buyer'  => BuyerNotification::class,
        };
    }
}
