<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $data;

    public function __construct(string $type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = '';

        switch ($this->type) {
            case 'kyc_approved':
                $message = 'Pengajuan KYC kamu diterima ✅';
                break;

            case 'kyc_rejected':
                $message = 'Pengajuan KYC kamu ditolak ❌';
                if (! empty($this->data['rejection_reason'])) {
                    $message .= ' (Alasan: ' . $this->data['rejection_reason'] . ')';
                }
                break;

            case 'order_new':
                $message = 'Kamu mendapatkan order baru 🛒';
                break;

            case 'order_shipped':
                $message = 'Order sudah dikirim 🚚';
                break;

            case 'order_delivered':
                $message = 'Order sudah sampai 📦';
                break;

            case 'order_finished':
                $message = 'Order sudah selesai ✅';
                break;

            default:
                $message = 'Notifikasi seller: ' . $this->type;
        }

        $formattedType = ucwords(str_replace('_', ' ', $this->type));

        return [
            'message' => $message,
            'data'    => $this->data,
            'type'    => $this->type,
            'formatted_type'    => $formattedType,
        ];
    }
}
