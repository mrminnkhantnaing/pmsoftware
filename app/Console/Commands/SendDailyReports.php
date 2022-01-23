<?php

namespace App\Console\Commands;

use App\Mail\DailyReport;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:dailyreports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email for daily reports of transactions, paybalances and cardreceipts.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = Setting::query()
                    ->where('id', 1)
                    ->first();

        Mail::to($settings->company_email)
            ->cc('tkdsoftware.pm@gmail.com')
            ->queue(new DailyReport());
    }
}
