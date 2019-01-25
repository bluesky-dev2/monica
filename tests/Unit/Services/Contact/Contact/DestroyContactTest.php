<?php

namespace Tests\Unit\Services\Contact\Contact;

use Tests\TestCase;
use App\Models\Account\Account;
use App\Models\Contact\Contact;
use Illuminate\Validation\ValidationException;
use App\Services\Contact\Contact\DestroyContact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyContactTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_destroys_a_contact()
    {
        $contact = factory(Contact::class)->create([]);

        $request = [
            'account_id' => $contact->account_id,
            'contact_id' => $contact->id,
        ];

        $contactService = new DestroyContact;
        $bool = $contactService->execute($request);

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_it_fails_if_wrong_parameters_are_given()
    {
        $contact = factory(Contact::class)->create([]);

        $request = [
            'account_id' => $contact->account_id,
        ];

        $this->expectException(ValidationException::class);

        app(DestroyContact::class)->execute($request);
    }

    public function test_it_throws_an_exception_if_contact_doesnt_exist()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([]);

        $request = [
            'account_id' => $account->id,
            'contact_id' => $contact->id,
        ];

        $this->expectException(ModelNotFoundException::class);
        app(DestroyContact::class)->execute($request);
    }
}
