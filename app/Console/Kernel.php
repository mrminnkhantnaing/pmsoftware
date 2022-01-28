<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Send daily reports of invoices to the admin email address
        if (App::environment(['production'])) {
            $schedule->command('send:dailyreports')->dailyAt('23:59');
        }

        // In local & staging envs, refresh the application daily
        if (App::environment(['local', 'staging'])) {
            $schedule->command('migrate:fresh --seed')->dailyAt('00:00');
        }

        // Functions of the application
        $schedule->call(function () {
            // Update Expired Transactions' Relations
            $transactions = \App\Models\Transaction::whereDate('end_date', '<', Carbon::now()->toDateString())->where('notice', 1)->where('moved', 0)->get();

            if ($transactions) {
                foreach ($transactions as $transaction) {
                    $transaction->update([
                        'moved' => 1,
                    ]);

                    // Change the partition status
                    $partition = \App\Models\Partition::where('id', $transaction->partition_id)->firstOrFail();
                    $partition->update([
                        'status' => $transaction->moved == 1 ? 'available' : 'occupied',
                    ]);

                    // Change the status of tenant
                    $tenant = \App\Models\Tenant::where('id', $transaction->tenant_id)->firstOrFail();
                    $tenant->update([
                        'status' => $transaction->moved == 1 ? 0 : 1,
                    ]);

                    // Change the card's status if exists
                    if ($tenant->cards) {
                        foreach($tenant->cards as $card) {
                            if ($transaction->moved == 1) {
                                $card->update([
                                    'status' => $card->status == 'active' ? 'undefined' : $card->status,
                                ]);
                            } else {
                                $card->update([
                                    'status' => $card->status == 'undefined' ? 'active' : $card->status,
                                ]);
                            }
                        }
                    }
                }
            }
        })->twiceDaily(1, 13); // Update the statuses twice per day
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
