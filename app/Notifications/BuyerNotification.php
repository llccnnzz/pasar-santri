<?php
namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use App\Notifications\BuyerNotification;
use Illuminate\Notifications\Notification;

class BuyerNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $data;

    public function __construct(string $type, Order $order)
    {
        $this->type = $type;
        $this->data = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = '';

        switch ($this->type) {
            case 'order_pending':
                $message = 'Pesanan kamu menunggu pembayaran 💳';
                break;

            case 'order_paid':
                $message = 'Pembayaran pesanan kamu sudah diterima ✅';
                break;

            case 'order_confirmed':
                $message = 'Pesanan kamu sudah dikonfirmasi oleh seller 📦';
                break;

            case 'order_processing':
                $message = 'Pesanan kamu sedang diproses ⚙️';
                break;

            case 'order_shipped':
                $message = 'Pesanan kamu sudah dikirim 🚚';
                break;

            case 'order_delivered':
                $message = 'Pesanan kamu sudah sampai 📬';
                break;

            case 'order_finished':
                $message = 'Pesanan kamu sudah selesai 🎉';
                break;

            case 'order_cancelled ❌':
                $message = 'Pesanan kamu dibatalkan ❌';
                if (! empty($this->data['cancellation_reason'])) {
                    $message .= ' (Alasan: ' . $this->data['cancellation_reason'] . ')';
                }
                break;

            default:
                $message = 'Notifikasi buyer: ' . $this->type;
        }

        $formattedType = ucwords(str_replace('_', ' ', $this->type));

        return [
            'message' => $message,
            'data'    => $this->data,
            'type'    => $this->type,
        ];
    }
}
