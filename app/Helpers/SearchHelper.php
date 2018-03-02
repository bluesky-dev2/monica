<?php

namespace App\Helpers;

use Auth;
use App\Contact;

class SearchHelper
{
    /**
     * Search contacts by the given query.
     *
     * @param  string $query
     * @param  int $limitPerPage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchContacts($query, $limitPerPage, $order)
    {
        $needle = $query;
        $accountId = auth()->user()->account->id;

        if (preg_match('/(.{1,})[:](.{1,})/', $needle, $matches)) {
            $search_field = $matches[1];
            $search_term = $matches[2];

            $field = ContactFieldType::where('name', 'LIKE', $search_field)->first();

            $field_id = $field->id;

            $results = Contact::whereHas('contactFields', function ($query) use ($field_id, $search_term) {
                $query->where([
                    ['data', 'like', "$search_term%"],
                    ['contact_field_type_id', $field_id],
                ]);
            })->paginate($limitPerPage);
        } else {
            $results = Contact::search($needle, $accountId, $limitPerPage, $order, 'and is_partial=0');
        }

        return $results;
    }
}
