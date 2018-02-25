<?php

namespace Tests\Unit\Jobs;

use Carbon\Carbon;
use Tests\TestCase;
use App\Jobs\SetNextReminderDate;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SetNextReminderDateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_sets_the_date_of_the_next_reminder()
    {
        Carbon::setTestNow(Carbon::create(2017, 1, 1, 7, 0, 0));

        $account = factory('App\Account')->create([
            'default_time_reminder_is_sent' => '07:00',
        ]);
        $contact = factory('App\Contact')->create(['account_id' => $account->id]);
        $user = factory('App\User')->create([
            'account_id' => $account->id,
            'email' => 'john@doe.com',
        ]);
        $reminderRule = factory('App\ReminderRule')->create([
            'account_id' => $account->id,
            'number_of_days_before' => 7,
            'active' => 1,
        ]);
        $reminderRule = factory('App\ReminderRule')->create([
            'account_id' => $account->id,
            'number_of_days_before' => 30,
            'active' => 1,
        ]);
        $reminder = factory('App\Reminder')->create([
            'account_id' => $account->id,
            'contact_id' => $contact->id,
            'next_expected_date' => '2017-01-01',
            'frequency_type' => 'month',
            'frequency_number' => '1',
        ]);

        dispatch(new SetNextReminderDate($reminder, $user->timezone));

        $this->assertDatabaseHas('reminders', [
            'next_expected_date' => '2017-02-01 00:00:00',
        ]);

        // Also check if two notifications have been created
        $this->assertEquals(
            2,
            $reminder->notifications()->count()
        );
    }

    public function test_it_deletes_the_reminder()
    {
        Carbon::setTestNow(Carbon::create(2017, 1, 1, 7, 0, 0));

        $account = factory('App\Account')->create([
            'default_time_reminder_is_sent' => '07:00',
        ]);
        $contact = factory('App\Contact')->create(['account_id' => $account->id]);
        $user = factory('App\User')->create([
            'account_id' => $account->id,
            'email' => 'john@doe.com',
        ]);
        $reminder = factory('App\Reminder')->create([
            'account_id' => $account->id,
            'contact_id' => $contact->id,
            'next_expected_date' => '2017-01-01',
            'frequency_type' => 'one_time',
        ]);

        $this->assertDatabaseHas('reminders', [
            'id' => $reminder->id,
        ]);

        dispatch(new SetNextReminderDate($reminder, $user->timezone));

        $this->assertDatabaseMissing('reminders', [
            'id' => $reminder->id,
        ]);
    }
}
