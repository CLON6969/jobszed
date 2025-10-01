<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobPost;
use Carbon\Carbon;

class CloseExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-expired-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close job posts where the application deadline has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $affected = JobPost::where('status', 'open')
            ->whereDate('application_deadline', '<', $today)
            ->update(['status' => 'closed']);

        $this->info("✅ {$affected} job(s) were closed because their application deadline passed.");
    }
}
