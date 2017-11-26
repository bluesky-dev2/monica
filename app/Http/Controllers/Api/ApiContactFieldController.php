<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Contact;
use App\ContactField;
use App\ContactFieldType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\ContactField\ContactField as ContactFieldResource;

class ApiContactFieldController extends ApiController
{
    /**
     * Get the detail of a given contactField.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $contactField = ContactField::where('account_id', auth()->user()->account_id)
                ->where('id', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new ContactFieldResource($contactField);
    }

    /**
     * Store the contactField.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validates basic fields to create the entry
        $validator = Validator::make($request->all(), [
            'data' => 'max:255|required',
            'contact_field_type_id' => 'integer|required',
            'contact_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->setErrorCode(32)
                        ->respondWithError($validator->errors()->all());
        }

        try {
            $contact = Contact::where('account_id', auth()->user()->account_id)
                ->where('id', $request->input('contact_id'))
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        try {
            $contactFieldType = ContactFieldType::where('account_id', auth()->user()->account_id)
                ->where('id', $request->input('contact_field_type_id'))
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        try {
            $contactField = ContactField::create(
              $request->all()
              + [
                'account_id' => auth()->user()->account->id,
              ]
            );
        } catch (QueryException $e) {
            return $this->respondNotTheRightParameters();
        }

        return new ContactFieldResource($contactField);
    }

    /**
     * Update the contactField.
     * @param  Request $request
     * @param  int $contactFieldId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contactFieldId)
    {
        try {
            $contactField = ContactField::where('account_id', auth()->user()->account_id)
                ->where('id', $contactFieldId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        // Validates basic fields to create the entry
        $validator = Validator::make($request->all(), [
            'data' => 'max:255|required',
            'contact_field_type_id' => 'integer|required',
            'contact_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->setErrorCode(32)
                        ->respondWithError($validator->errors()->all());
        }

        try {
            $contact = Contact::where('account_id', auth()->user()->account_id)
                ->where('id', $request->input('contact_id'))
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        try {
            $contactField->update($request->all());
        } catch (QueryException $e) {
            return $this->respondNotTheRightParameters();
        }

        return new ContactFieldResource($contactField);
    }

    /**
     * Delete a contactField.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $contactFieldId)
    {
        try {
            $contactField = ContactField::where('account_id', auth()->user()->account_id)
                ->where('id', $contactFieldId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        $contactField->delete();

        return $this->respondObjectDeleted($contactField->id);
    }

    /**
     * Get the list of contact fields for the given contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactFields(Request $request, $contactId)
    {
        try {
            $contact = Contact::where('account_id', auth()->user()->account_id)
                ->where('id', $contactId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        $contactFields = $contact->contactFields()
                ->paginate($this->getLimitPerPage());

        return ContactFieldResource::collection($contactFields);
    }
}
