<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Contact\Contact;
use App\Models\Contact\Reminder;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Services\Contact\Reminder\CreateReminder;
use App\Services\Contact\Reminder\UpdateReminder;
use App\Services\Contact\Reminder\DestroyReminder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Reminder\Reminder as ReminderResource;

class ApiReminderController extends ApiController
{
    /**
     * Get the list of reminders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $reminders = auth()->user()->account->reminders()
                ->orderBy($this->sort, $this->sortDirection)
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return ReminderResource::collection($reminders);
    }

    /**
     * Get the detail of a given reminder.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $reminderId)
    {
        try {
            $reminder = Reminder::where('account_id', auth()->user()->account_id)
                ->where('id', $reminderId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new ReminderResource($reminder);
    }

    /**
     * Store the reminder.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $reminder = app(CreateReminder::class)->execute(
                $request->all()
                    +
                    [
                    'account_id' => auth()->user()->account->id,
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return new ReminderResource($reminder);
    }

    /**
     * Update the reminder.
     * @param  Request $request
     * @param  int $reminderId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $reminderId)
    {
        try {
            $reminder = app(UpdateReminder::class)->execute(
                $request->all()
                    +
                    [
                    'account_id' => auth()->user()->account->id,
                    'reminder_id' => $reminderId,
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return new ReminderResource($reminder);
    }

    /**
     * Delete a reminder.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $reminderId)
    {
        try {
            app(DestroyReminder::class)->execute([
                'account_id' => auth()->user()->account->id,
                'reminder_id' => $reminderId,
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return $this->respondObjectDeleted((int) $reminderId);
    }

    /**
     * Get the list of reminders for the given contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function reminders(Request $request, $contactId)
    {
        try {
            $contact = Contact::where('account_id', auth()->user()->account_id)
                ->where('id', $contactId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        $reminders = $contact->reminders()
                ->orderBy($this->sort, $this->sortDirection)
                ->paginate($this->getLimitPerPage());

        return ReminderResource::collection($reminders);
    }
}
