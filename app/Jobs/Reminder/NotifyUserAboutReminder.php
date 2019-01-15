<?php

namespace App\Jobs\Reminder;

use Illuminate\Bus\Queueable;
use App\Notifications\UserNotified;
use App\Notifications\UserReminded;
use App\Models\Contact\ReminderOutbox;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class NotifyUserAboutReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reminderOutbox;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ReminderOutbox $reminderOutbox)
    {
        $this->reminderOutbox = $reminderOutbox;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // prepare the notification to be sent
        $message = '';
        if ($this->reminderOutbox->nature == 'reminder') {
            $message = new UserReminded($this->reminderOutbox);
        }

        if ($this->reminderOutbox->nature == 'notification') {
            $message = new UserNotified($this->reminderOutbox);
        }

        // send the notification to this user
        if (! $this->reminderOutbox->user->account->hasLimitations()) {
            Notification::send($this->reminderOutbox->user, $message);
        }

        // create the Reminder Sent object
        $this->reminderOutbox->logSent($message);

        // schedule the next reminder for this user
        if ($this->reminderOutbox->reminder->frequency_type == 'one_time') {
            $this->reminderOutbox->reminder->inactive = true;
            $this->reminderOutbox->reminder->save();
        } else {
            $this->reminderOutbox->reminder->schedule($this->reminderOutbox->user);
        }

        // delete the reminder outbox
        $this->reminderOutbox->delete();
    }
}
