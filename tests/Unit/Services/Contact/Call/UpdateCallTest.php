<?php

namespace Tests\Unit\Services\Contact\Conversation;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Contact\Call;
use App\Models\Account\Account;
use App\Models\Contact\Contact;
use App\Services\Contact\Call\UpdateCall;
use App\Exceptions\MissingParameterException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateCallTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_updates_a_call()
    {
        $contact = factory(Contact::class)->create([]);
        $call = factory(Call::class)->create([
            'contact_id' => $contact,
            'account_id' => $contact->account->id,
        ]);

        $request = [
            'account_id' => $call->account->id,
            'call_id' => $call->id,
            'called_at' => Carbon::now(),
            'content' => 'this is the content',
        ];

        $callService = new UpdateCall;
        $call = $callService->execute($request);

        $this->assertDatabaseHas('calls', [
            'id' => $call->id,
            'contact_id' => $call->contact->id,
            'account_id' => $call->contact->account->id,
            'content' => 'this is the content',
        ]);

        $this->assertInstanceOf(
            Call::class,
            $call
        );
    }

    public function test_it_updates_a_call_without_the_content()
    {
        $contact = factory(Contact::class)->create([]);
        $call = factory(Call::class)->create([
            'contact_id' => $contact,
            'account_id' => $contact->account->id,
        ]);

        $request = [
            'account_id' => $call->account->id,
            'call_id' => $call->id,
            'called_at' => Carbon::now(),
        ];

        $callService = new UpdateCall;
        $call = $callService->execute($request);

        $this->assertDatabaseHas('calls', [
            'id' => $call->id,
            'contact_id' => $call->contact->id,
            'account_id' => $call->contact->account->id,
            'content' => null,
        ]);
    }

    public function test_it_updates_the_last_call_info()
    {
        $contact = factory(Contact::class)->create([
            'last_talked_to' => '1900-01-01 00:00:00',
        ]);
        $call = factory(Call::class)->create([
            'contact_id' => $contact,
            'account_id' => $contact->account->id,
        ]);

        $date = Carbon::now();

        $request = [
            'account_id' => $call->account->id,
            'call_id' => $call->id,
            'called_at' => Carbon::now(),
        ];

        $callService = new UpdateCall;
        $call = $callService->execute($request);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'last_talked_to' => $date->toDateString(),
        ]);
    }

    public function test_it_doesnt_update_the_last_call_info()
    {
        $contact = factory(Contact::class)->create([
            'last_talked_to' => '2200-01-01 00:00:00',
        ]);
        $call = factory(Call::class)->create([
            'contact_id' => $contact,
            'account_id' => $contact->account->id,
        ]);

        $date = Carbon::now();

        $request = [
            'account_id' => $call->account->id,
            'call_id' => $call->id,
            'called_at' => Carbon::now(),
        ];

        $callService = new UpdateCall;
        $call = $callService->execute($request);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'last_talked_to' => '2200-01-01',
        ]);
    }

    public function test_it_fails_if_wrong_parameters_are_given()
    {
        $contact = factory(Contact::class)->create([]);

        $request = [
            'contact_id' => $contact->id,
            'called_at' => Carbon::now(),
        ];

        $this->expectException(MissingParameterException::class);

        $createConversation = new UpdateCall;
        $call = $createConversation->execute($request);
    }

    public function test_it_throws_an_exception_if_call_is_not_linked_to_account()
    {
        $account = factory(Account::class)->create();
        $call = factory(Call::class)->create();

        $request = [
            'account_id' => $account->id,
            'call_id' => $call->id,
            'called_at' => Carbon::now(),
        ];

        $this->expectException(ModelNotFoundException::class);

        $createConversation = (new UpdateCall)->execute($request);
    }
}
