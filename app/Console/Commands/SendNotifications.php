<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Notification;
use Illuminate\Console\Command;
use App\Jobs\Notification\ScheduleNotification;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications about reminders';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = Notification::where('trigger_date', '<', Carbon::now()->addDays(2))
                                ->orderBy('trigger_date', 'asc')->get();

        foreach ($notifications as $notification) {
            if (! $notification->contact) {
                $notification->delete();
                continue;
            }

            ScheduleNotification::dispatch($notification);
        }
    }
}
