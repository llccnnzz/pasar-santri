<?php
namespace App\Notifications;

use App\Models\KycApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    protected $kyc;

    public function __construct(KycApplication $kyc)
    {
        $this->kyc = $kyc;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'KYC baru diajukan oleh ' . $this->kyc['user']['name'],
            'kyc'  => $this->kyc,
            'status'  => $this->kyc['status'],
        ];
    }
}
