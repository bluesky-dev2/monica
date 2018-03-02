<?php

namespace App;

use DB;
use Carbon\Carbon;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number_of_invitations_sent',
        'api_key',
        'default_time_reminder_is_sent',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_access_to_paid_version_for_free' => 'boolean',
    ];

    /**
     * Create a new account and associate a new User.
     *
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @return this
     */
    public static function createDefault($first_name, $last_name, $email, $password)
    {
        // create new account
        $account = new self;
        $account->api_key = str_random(30);
        $account->created_at = Carbon::now();
        $account->save();

        $account->populateDefaultFields($account);

        // create the first user for this account
        User::createDefault($account->id, $first_name, $last_name, $email, $password);

        return $account;
    }

    /**
     * Populates all the default column that should be there when a new account
     * is created or reset.
     */
    public static function populateDefaultFields($account)
    {
        $account->populateContactFieldTypeTable();
        $account->populateDefaultGendersTable();
        $account->populateDefaultReminderRulesTable();
    }

    /**
     * Get the activity records associated with the account.
     *
     * @return HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the contact records associated with the account.
     *
     * @return HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the invitations associated with the account.
     *
     * @return HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Get the debt records associated with the account.
     *
     * @return HasMany
     */
    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    /**
     * Get the gift records associated with the account.
     *
     * @return HasMany
     */
    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }

    /**
     * Get the event records associated with the account.
     *
     * @return HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the note records associated with the account.
     *
     * @return HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the reminder records associated with the account.
     *
     * @return HasMany
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    /**
     * Get the task records associated with the account.
     *
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the user records associated with the account.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the offspring records associated with the account.
     *
     * @return HasMany
     */
    public function offpsrings()
    {
        return $this->hasMany(Offspring::class);
    }

    /**
     * Get the progenitor records associated with the account.
     *
     * @return HasMany
     */
    public function progenitors()
    {
        return $this->hasMany(Progenitor::class);
    }

    /**
     * Get the relationship records associated with the account.
     *
     * @return HasMany
     */
    public function relationships()
    {
        return $this->hasMany(Relationship::class);
    }

    /**
     * Get the activity statistics record associated with the account.
     *
     * @return HasMany
     */
    public function activityStatistics()
    {
        return $this->hasMany(ActivityStatistic::class);
    }

    /**
     * Get the task records associated with the account.
     *
     * @return HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Get the import jobs records associated with the account.
     *
     * @return HasMany
     */
    public function importjobs()
    {
        return $this->hasMany(ImportJob::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the import job reports records associated with the account.
     *
     * @return HasMany
     */
    public function importjobreports()
    {
        return $this->hasMany(ImportJobReport::class);
    }

    /**
     * Get the tags records associated with the account.
     *
     * @return HasMany
     */
    public function tags()
    {
        return $this->hasMany('App\Tag')->orderBy('name', 'asc');
    }

    /**
     * Get the calls records associated with the account.
     *
     * @return HasMany
     */
    public function calls()
    {
        return $this->hasMany(Call::class)->orderBy('called_at', 'desc');
    }

    /**
     * Get the Contact Field types records associated with the account.
     *
     * @return HasMany
     */
    public function contactFieldTypes()
    {
        return $this->hasMany('App\ContactFieldType');
    }

    /**
     * Get the Contact Field records associated with the contact.
     *
     * @return HasMany
     */
    public function contactFields()
    {
        return $this->hasMany('App\ContactField');
    }

    /**
     * Get the Journal Entries records associated with the account.
     *
     * @return HasMany
     */
    public function journalEntries()
    {
        return $this->hasMany('App\JournalEntry')->orderBy('date', 'desc');
    }

    /**
     * Get the Days records associated with the account.
     *
     * @return HasMany
     */
    public function days()
    {
        return $this->hasMany('App\Day');
    }

    /**
     * Get the Genders records associated with the account.
     *
     * @return HasMany
     */
    public function genders()
    {
        return $this->hasMany('App\Gender');
    }

    /**
     * Get the Reminder Rules records associated with the account.
     *
     * @return HasMany
     */
    public function reminderRules()
    {
        return $this->hasMany('App\ReminderRule');
    }

    /**
     * Get the Notifications records associated with the account.
     *
     * @return HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Get the default time reminder is sent.
     *
     * @param  string  $value
     * @return string
     */
    public function getDefaultTimeReminderIsSentAttribute($value)
    {
        return $value;
    }

    /**
     * Set the default time a reminder is sent.
     *
     * @param  string  $value
     * @return void
     */
    public function setDefaultTimeReminderIsSentAttribute($value)
    {
        $this->attributes['default_time_reminder_is_sent'] = $value;
    }

    /**
     * Check if the account can be downgraded, based on a set of rules.
     *
     * @return this
     */
    public function canDowngrade()
    {
        $canDowngrade = true;
        $numberOfUsers = $this->users()->count();
        $numberPendingInvitations = $this->invitations()->count();

        // number of users in the account should be == 1
        if ($numberOfUsers > 1) {
            $canDowngrade = false;
        }

        // there should not be any pending user invitations
        if ($numberPendingInvitations > 0) {
            $canDowngrade = false;
        }

        return $canDowngrade;
    }

    /**
     * Check if the account is currently subscribed to a plan.
     *
     * @return bool $isSubscribed
     */
    public function isSubscribed()
    {
        if ($this->has_access_to_paid_version_for_free) {
            return true;
        }

        $isSubscribed = false;

        if ($this->subscribed(config('monica.paid_plan_monthly_friendly_name'))) {
            $isSubscribed = true;
        }

        if ($this->subscribed(config('monica.paid_plan_annual_friendly_name'))) {
            $isSubscribed = true;
        }

        return $isSubscribed;
    }

    /**
     * Check if the account has invoices linked to this account.
     * This was created because Laravel Cashier doesn't know how to properly
     * handled the case when a user doesn't have invoices yet. This sucks balls.
     *
     * @return bool
     */
    public function hasInvoices()
    {
        $query = DB::table('subscriptions')->where('account_id', $this->id)->count();
        if ($query > 0) {
            return true;
        }

        return false;
    }

    /**
     * Get the next billing date for the account.
     *
     * @return string $timestamp
     */
    public function getNextBillingDate()
    {
        // Weird method to get the next billing date from Laravel Cashier
        // see https://stackoverflow.com/questions/41576568/get-next-billing-date-from-laravel-cashier
        $timestamp = $this->asStripeCustomer()['subscriptions']
                            ->data[0]['current_period_end'];

        return \App\Helpers\DateHelper::getShortDate($timestamp);
    }

    /**
     * Indicates whether the current account has limitations with her current
     * plan.
     *
     * @return bool
     */
    public function hasLimitations()
    {
        if ($this->has_access_to_paid_version_for_free) {
            return false;
        }

        if (! config('monica.requires_subscription')) {
            return false;
        }

        if ($this->isSubscribed()) {
            return false;
        }

        return true;
    }

    /**
     * Get the timezone of the user. In case an account has multiple timezones,
     * takes the first it finds.
     * @return string
     */
    public function timezone()
    {
        $timezone = '';

        foreach ($this->users as $user) {
            $timezone = $user->timezone;
            break;
        }

        return $timezone;
    }

    /**
     * Populates the Contact Field Types table right after an account is
     * created.
     */
    public function populateContactFieldTypeTable($ignoreMigratedTable = false)
    {
        $defaultContactFieldTypes = DB::table('default_contact_field_types')->get();

        foreach ($defaultContactFieldTypes as $defaultContactFieldType) {
            if (! $ignoreMigratedTable || $defaultContactFieldType->migrated == 0) {
                $contactFieldType = ContactFieldType::create([
                    'account_id' => $this->id,
                    'name' => $defaultContactFieldType->name,
                    'fontawesome_icon' => (is_null($defaultContactFieldType->fontawesome_icon) ? null : $defaultContactFieldType->fontawesome_icon),
                    'protocol' => (is_null($defaultContactFieldType->protocol) ? null : $defaultContactFieldType->protocol),
                    'delible' => $defaultContactFieldType->delible,
                    'type' => (is_null($defaultContactFieldType->type) ? null : $defaultContactFieldType->type),
                ]);
            }
        }
    }

    /**
     * Populates the default genders in a new account.
     *
     * @return void
     */
    public function populateDefaultGendersTable()
    {
        Gender::create(['name' => trans('app.gender_male'), 'account_id' => $this->id]);
        Gender::create(['name' => trans('app.gender_female'), 'account_id' => $this->id]);
        Gender::create(['name' => trans('app.gender_none'), 'account_id' => $this->id]);
    }

    /**
     * Populates the default reminder rules in a new account.
     *
     * @return void
     */
    public function populateDefaultReminderRulesTable()
    {
        ReminderRule::create(['number_of_days_before' => 7, 'account_id' => $this->id, 'active' => 1]);
        ReminderRule::create(['number_of_days_before' => 30, 'account_id' => $this->id, 'active' => 1]);
    }

    /**
     * Get the reminders for the month given in parameter.
     * - 0 means current month
     * - 1 means month+1
     * - 2 means month+2...
     * @param  int    $month
     */
    public function getRemindersForMonth(int $month)
    {
        $startOfMonth = \Carbon\Carbon::now()->addMonthsNoOverflow($month)->startOfMonth();
        $endInThreeMonths = \Carbon\Carbon::now()->addMonthsNoOverflow($month)->endOfMonth();

        return auth()->user()->account->reminders()
                     ->whereBetween('next_expected_date', [$startOfMonth, $endInThreeMonths])
                     ->orderBy('next_expected_date', 'asc')
                     ->get();
    }

    /**
     * Get the id of the plan the account is subscribed to.
     *
     * @return string
     */
    public function getSubscribedPlanId()
    {
        $plan = $this->subscriptions()->first();

        return $plan->stripe_plan;
    }

    /**
     * Get the friendly name of the plan the account is subscribed to.
     *
     * @return string
     */
    public function getSubscribedPlanName()
    {
        $plan = $this->subscriptions()->first();

        return $plan->name;
    }

    /**
     * Replaces a specific gender of all the contacts in the account with another
     * gender.
     *
     * @param  Gender $genderToDelete
     * @param  Gender $genderToReplaceWith
     * @return bool
     */
    public function replaceGender(Gender $genderToDelete, Gender $genderToReplaceWith)
    {
        Contact::where('account_id', $this->id)
                    ->where('gender_id', $genderToDelete->id)
                    ->update(['gender_id' => $genderToReplaceWith->id]);

        return true;
    }
}
