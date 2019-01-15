<?php

namespace App\Models\Contact;

use App\Models\User\User;
use App\Helpers\MailHelper;
use App\Models\Account\Account;
use App\Notifications\UserNotified;
use App\Notifications\UserReminded;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ModelBindingHasherWithContact as Model;

/**
 * @property Account $account
 * @property Contact $contact
 */
class ReminderOutbox extends Model
{
    protected $table = 'reminder_outbox';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'planned_date',
    ];

    /**
     * Get the account record associated with the reminder.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the reminder record associated with the reminder.
     *
     * @return BelongsTo
     */
    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }

    /**
     * Get the user record associated with the reminder.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log the message that has been sent to the user.
     *
     * @param Notification $message
     * @return void
     */
    public function logSent($message)
    {
        $reminderSent = new ReminderSent;
        $reminderSent->account_id = $this->account_id;
        $reminderSent->reminder_id = $this->reminder_id;
        $reminderSent->user_id = $this->user_id;
        $reminderSent->planned_date = $this->planned_date;
        $reminderSent->sent_date = now();
        $reminderSent->frequency_type = is_null($this->reminder) ? null : $this->reminder->frequency_type;
        $reminderSent->frequency_number = is_null($this->reminder) ? null : $this->reminder->frequency_number;
        $reminderSent->html_content = MailHelper::emailView($message, $this->user);

        if ($message instanceof UserNotified) {
            $reminderSent->nature = 'notification';
        }

        if ($message instanceof UserReminded) {
            $reminderSent->nature = 'reminder';
        }
        $reminderSent->save();
    }
}
