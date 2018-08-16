<?php

namespace Tests\Unit\Helpers;

use Tests\FeatureTestCase;
use App\Helpers\SearchHelper;
use App\Models\Contact\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchHelperTest extends FeatureTestCase
{
    use DatabaseTransactions;

    public function test_searching_for_contacts_returns_a_collection_with_pagination()
    {
        $user = $this->signin();

        $contact = factory(Contact::class)->make();
        $searchResults = SearchHelper::searchContacts($contact->first_name, 1, 'created_at');

        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $searchResults);
    }
}
