<?php

namespace Tests\Unit\Services\Contact\Conversation;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Contact\Message;
use App\Models\Contact\Conversation;
use App\Services\Contact\Conversation\UpdateMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateMessageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_updates_a_conversation()
    {
        $conversation = factory(Conversation::class)->create([]);

        $message = factory(Message::class)->create([
            'conversation_id' => $conversation->id,
            'account_id' => $conversation->account->id,
            'contact_id' => $conversation->contact->id,
            'content' => 'tititi',
            'written_at' => '2009-01-01',
            'written_by_me' => false,
        ]);

        $request = [
            'account_id' => $conversation->account->id,
            'contact_id' => $conversation->contact->id,
            'conversation_id' => $conversation->id,
            'message_id' => $message->id,
            'written_at' => Carbon::now(),
            'written_by_me' => true,
            'content' => 'lorem',
        ];

        $messageService = new UpdateMessage;
        $message = $messageService->execute($request);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'account_id' => $conversation->account->id,
            'contact_id' => $conversation->contact->id,
            'conversation_id' => $conversation->id,
            'written_by_me' => true,
            'content' => 'lorem',
        ]);

        $this->assertInstanceOf(
            Message::class,
            $message
        );
    }

    public function test_it_fails_if_wrong_parameters_are_given()
    {
        $request = [
            'account_id' => 1,
            'conversation_id' => 2,
            'message_id' => 3,
            'written_at' => Carbon::now(),
            'written_by_me' => true,
            'content' => 'lorem',
        ];

        $this->expectException(\Exception::class);

        $updateMessage = new UpdateMessage;
        $conversation = $updateMessage->execute($request);
    }

    public function test_it_throws_an_exception_if_message_does_not_exist()
    {
        $message = factory(Message::class)->create([]);

        $request = [
            'account_id' => 123,
            'contact_id' => 123,
            'conversation_id' => 123,
            'message_id' => $message->id,
            'written_at' => Carbon::now(),
            'written_by_me' => true,
            'content' => 'lorem',
        ];

        $this->expectException(ModelNotFoundException::class);

        $updateMessage = new UpdateMessage;
        $conversation = $updateMessage->execute($request);
    }
}
