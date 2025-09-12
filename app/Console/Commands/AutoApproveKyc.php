<?php

namespace App\Console\Commands;

use App\Models\KycApplication;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoApproveKyc extends Command
{
    protected $signature = 'kyc:auto-approve';

    protected $description = 'Auto approve KYC applications after 3 days of submission';

    public function handle()
    {
        $cutoff = Carbon::now()->subDays(3);

        $applications = KycApplication::pending()
            ->where('created_at', '<=', $cutoff)
            ->get();

        if ($applications->isEmpty()) {
            $this->info('No KYC applications to auto-approve.');
            return 0;
        }

        foreach ($applications as $application) {
            $application->update([
                'status' => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => null,
                'admin_notes' => 'Auto approved by system after 3 days',
            ]);

            $this->info("Auto approved KYC ID: {$application->id}");
        }

        return 0;
    }
}
