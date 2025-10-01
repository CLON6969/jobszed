<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\JobPost;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('jobs:close-expired', function () {
    $count = JobPost::where('status', 'open')
        ->whereDate('application_deadline', '<', Carbon::today())
        ->update(['status' => 'closed']);

    $this->info("✅ {$count} expired job(s) closed.");
})->purpose('Close job posts where the application deadline has passed');
