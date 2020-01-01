<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Journal\Day;
use App\Models\Settings\Term;
use App\Models\Account\Account;
use App\Models\Contact\Reminder;
use App\Models\Settings\Currency;
use App\Services\User\CreateUser;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    private function createUser($account_id, $first_name, $last_name, $email, $password)
    {
        return app(CreateUser::class)->execute([
            'account_id' => $account_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    /** @test */
    public function it_belongs_to_account()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);

        $this->assertTrue($user->account()->exists());
    }

    /** @test */
    public function it_belongs_to_many_terms()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $term = factory(Term::class)->create();
        $user->terms()->sync([$term->id => ['account_id' => $account->id]]);

        $user = factory(User::class)->create(['account_id' => $account->id]);
        $term = factory(Term::class)->create();
        $user->terms()->sync([$term->id => ['account_id' => $account->id]]);

        $this->assertTrue($user->terms()->exists());
    }

    /** @test */
    public function it_updates_the_view_preferences()
    {
        $user = factory(User::class)->create();
        $user->contacts_sort_order = 'firstnameAZ';

        $this->assertEquals(
            $user->contacts_sort_order == 'lastnameAZ',
            $user->updateContactViewPreference('lastnameAZ')
        );
    }

    /** @test */
    public function name_accessor_returns_name_in_the_user_preferred_way()
    {
        $user = new User;
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->name_order = 'firstname_lastname';

        $this->assertEquals(
            $user->name,
            'John Doe'
        );

        $user->name_order = 'lastname_firstname';

        $this->assertEquals(
            $user->name,
            'Doe John'
        );
    }

    /** @test */
    public function it_gets_the_right_metric_symbol()
    {
        $user = new User;
        $user->metric = 'fahrenheit';

        $this->assertEquals(
            'F',
            $user->getMetricSymbol()
        );

        $user->metric = 'celsius';
        $this->assertEquals(
            'C',
            $user->getMetricSymbol()
        );
    }

    /** @test */
    public function you_can_vote_if_you_havent_voted_yet_today()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);

        $this->assertFalse($user->hasAlreadyRatedToday());
    }

    /** @test */
    public function you_cant_vote_if_you_have_already_voted_today()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $day = factory(Day::class)->create([
            'account_id' => $account->id,
            'date' => now(),
        ]);

        $this->assertTrue($user->hasAlreadyRatedToday());
    }

    /** @test */
    public function it_gets_2fa_secret_attribute()
    {
        $user = new User;

        $this->assertNull($user->getGoogle2faSecretAttribute(null));

        $string = 'pass1234';

        $this->assertEquals(
            $string,
            $user->getGoogle2faSecretAttribute(encrypt($string))
        );
    }

    /** @test */
    public function it_gets_fluid_layout()
    {
        $user = new User;
        $user->fluid_container = true;

        $this->assertEquals(
            'container-fluid',
            $user->getFluidLayout()
        );

        $user->fluid_container = false;

        $this->assertEquals(
            'container',
            $user->getFluidLayout()
        );
    }

    /** @test */
    public function it_gets_the_locale()
    {
        $user = new User;
        $user->locale = 'en';

        $this->assertEquals(
            'en',
            $user->locale
        );
    }

    /** @test */
    public function user_should_not_be_reminded_because_dates_are_different()
    {
        Carbon::setTestNow(Carbon::create(2017, 1, 1));
        $account = factory(Account::class)->create();
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $reminder = factory(Reminder::class)->create([
            'account_id' => $account->id,
            'initial_date' => '2018-02-01',
        ]);

        $this->assertFalse($user->isTheRightTimeToBeReminded($reminder->initial_date));
    }

    /** @test */
    public function user_should_not_be_reminded_because_hours_are_different()
    {
        Carbon::setTestNow(Carbon::create(2017, 1, 1, 7, 0, 0));
        $account = factory(Account::class)->create(['default_time_reminder_is_sent' => '08:00']);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $reminder = factory(Reminder::class)->create([
            'account_id' => $account->id,
            'initial_date' => '2017-01-01',
        ]);

        $this->assertFalse($user->isTheRightTimeToBeReminded($reminder->initial_date));
    }

    /** @test */
    public function user_should_not_be_reminded_because_timezone_is_different()
    {
        Carbon::setTestNow(Carbon::create(2017, 1, 1, 7, 0, 0, 'Europe/Berlin'));
        $account = factory(Account::class)->create(['default_time_reminder_is_sent' => '07:00']);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $reminder = factory(Reminder::class)->create([
            'account_id' => $account->id,
            'initial_date' => '2017-01-01',
        ]);

        $this->assertFalse($user->isTheRightTimeToBeReminded($reminder->initial_date));
    }

    /** @test */
    public function user_should_be_reminded()
    {
        Carbon::setTestNow(Carbon::create(2017, 1, 1, 7, 32, 12));
        $account = factory(Account::class)->create(['default_time_reminder_is_sent' => '07:00']);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $reminder = factory(Reminder::class)->create([
            'account_id' => $account->id,
            'initial_date' => '2017-01-01',
        ]);

        $this->assertTrue($user->isTheRightTimeToBeReminded($reminder->initial_date));
    }

    /** @test */
    public function it_indicates_user_is_compliant()
    {
        $term = factory(Term::class)->create([]);
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);

        $user->terms()->syncWithoutDetaching([$term->id => ['account_id' => $account->id]]);

        $this->assertTrue($user->isPolicyCompliant());
    }

    /** @test */
    public function it_indicates_user_is_not_compliant()
    {
        $term = factory(Term::class)->create([]);
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);

        $user->terms()->syncWithoutDetaching([$term->id => ['account_id' => $account->id]]);

        // need to sleep, otherwise the creation date of the two terms are
        // identical
        sleep(1);
        $term2 = factory(Term::class)->create([]);

        $this->assertFalse($user->isPolicyCompliant());
    }

    /** @test */
    public function it_accepts_the_laterms_and_privacy()
    {
        $term = factory(Term::class)->create([]);
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $ipAddress = '12.12.12.12';

        $user->acceptPolicy($ipAddress);

        $this->assertDatabaseHas('term_user', [
            'user_id' => $user->id,
            'account_id' => $account->id,
            'term_id' => $term->id,
            'ip_address' => $ipAddress,
        ]);
    }

    /** @test */
    public function it_gets_status_for_a_specific_compliance()
    {
        $user = factory(User::class)->create([]);
        $this->assertFalse($user->getStatusForCompliance(123));

        $term = factory(Term::class)->create([]);
        $user->terms()->sync([$term->id => ['account_id' => $user->account_id]]);

        $array = $user->getStatusForCompliance($term->id);
        $this->assertArrayHasKey('signed', $array);
    }

    /** @test */
    public function it_gets_all_the_signed_compliances_of_the_user()
    {
        $user = factory(User::class)->create([]);
        $term = factory(Term::class)->create([]);
        $user->terms()->syncWithoutDetaching([$term->id => ['account_id' => $user->account_id]]);

        $term2 = factory(Term::class)->create([]);
        $user->terms()->syncWithoutDetaching([$term2->id => ['account_id' => $user->account_id]]);
        $collection = $user->getAllCompliances();

        $this->assertEquals(
            2,
            $collection->count()
        );
    }

    /** @test */
    public function it_gets_name_order_for_a_form()
    {
        $user = factory(User::class)->create([]);
        $user->name_order = 'firstname_lastname';
        $this->assertEquals(
            'firstname',
            $user->getNameOrderForForms()
        );

        $user->name_order = 'firstname_lastname_nickname';
        $this->assertEquals(
            'firstname',
            $user->getNameOrderForForms()
        );

        $user->name_order = 'firstname_nickname_lastname';
        $this->assertEquals(
            'firstname',
            $user->getNameOrderForForms()
        );

        $user->name_order = 'lastname_firstname';
        $this->assertEquals(
            'lastname',
            $user->getNameOrderForForms()
        );

        $user->name_order = 'lastname_firstname_nickname';
        $this->assertEquals(
            'lastname',
            $user->getNameOrderForForms()
        );

        $user->name_order = 'lastname_nickname_firstname';
        $this->assertEquals(
            'lastname',
            $user->getNameOrderForForms()
        );
    }

    /** @test */
    public function it_creates_default_user_en()
    {
        App::setLocale('en');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'USD')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'en',
            'timezone' => 'America/Chicago',
            'currency_id' => $currency->id,
            'temperature_scale' => 'fahrenheit',
        ]);
    }

    /** @test */
    public function it_creates_default_user_fr()
    {
        App::setLocale('fr');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'EUR')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'fr',
            'timezone' => 'Europe/Paris',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_cs()
    {
        App::setLocale('cs');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'CZK')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'cs',
            'timezone' => 'Europe/Prague',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_de()
    {
        App::setLocale('de');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'EUR')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'de',
            'timezone' => 'Europe/Berlin',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_es()
    {
        App::setLocale('es');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'EUR')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'es',
            'timezone' => 'Europe/Madrid',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_he()
    {
        App::setLocale('he');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'ILS')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'he',
            'timezone' => 'Asia/Jerusalem',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_it()
    {
        App::setLocale('it');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'EUR')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_nl()
    {
        App::setLocale('nl');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'EUR')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'nl',
            'timezone' => 'Europe/Amsterdam',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_pt()
    {
        App::setLocale('pt');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'EUR')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'pt',
            'timezone' => 'Europe/Lisbon',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_ru()
    {
        App::setLocale('ru');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'RUB')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'ru',
            'timezone' => 'Europe/Moscow',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }

    /** @test */
    public function it_creates_default_user_zh()
    {
        App::setLocale('zh');

        $account = factory(Account::class)->create([]);
        $user = $this->createUser($account->id, 'John', 'Doe', 'john@doe.com', 'password');
        $currency = Currency::where('iso', 'CNY')->first();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'locale' => 'zh',
            'timezone' => 'Asia/Shanghai',
            'currency_id' => $currency->id,
            'temperature_scale' => 'celsius',
        ]);
    }
}
