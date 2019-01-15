<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Http\Request;
use App\Helpers\AvatarHelper;
use App\Models\Contact\Contact;
use App\Models\Contact\Reminder;
use App\Http\Controllers\Controller;
use App\Services\Contact\Reminder\CreateReminder;
use App\Services\Contact\Reminder\UpdateReminder;
use App\Services\Contact\Reminder\DestroyReminder;

class RemindersController extends Controller
{
    /**
     * Show the form for creating a new reminder.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function create(Contact $contact)
    {
        return view('people.reminders.add')
            ->withContact($contact)
            ->withAvatar(AvatarHelper::get($contact, 87))
            ->withReminder(new Reminder);
    }

    /**
     * Store a reminder.
     *
     * @param Request $request
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Contact $contact)
    {
        $data = [
            'account_id' => auth()->user()->account->id,
            'contact_id' => $contact->id,
            'initial_date' => $request->get('initial_date'),
            'frequency_type' => $request->get('frequency_type'),
            'frequency_number' => is_null($request->get('frequency_number')) ? 1 : $request->get('frequency_number'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];

        (new CreateReminder)->execute($data);

        return redirect()->route('people.show', $contact)
            ->with('success', trans('people.reminders_create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @param Reminder $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact, Reminder $reminder)
    {
        return view('people.reminders.edit')
            ->withContact($contact)
            ->withAvatar(AvatarHelper::get($contact, 87))
            ->withReminder($reminder);
    }

    /**
     * Update the reminder.
     *
     * @param Request $request
     * @param Contact $contact
     * @param Reminder $reminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact, Reminder $reminder)
    {
        $data = [
            'account_id' => auth()->user()->account->id,
            'contact_id' => $contact->id,
            'reminder_id' => $reminder->id,
            'initial_date' => $request->get('initial_date'),
            'frequency_type' => $request->get('frequency_type'),
            'frequency_number' => is_null($request->get('frequency_number')) ? 1 : $request->get('frequency_number'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];

        (new UpdateReminder)->execute($data);

        return redirect()->route('people.show', $contact)
            ->with('success', trans('people.reminders_update_success'));
    }

    /**
     * Destroy the reminder.
     *
     * @param Request $request
     * @param Contact $contact
     * @param Reminder $reminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Contact $contact, Reminder $reminder)
    {
        $data = [
            'account_id' => $reminder->account->id,
            'reminder_id' => $reminder->id,
        ];

        (new DestroyReminder)->execute($data);

        return redirect()->route('people.show', $contact)
            ->with('success', trans('people.reminders_delete_success'));
    }
}
