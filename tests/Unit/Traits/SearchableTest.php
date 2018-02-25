<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchableTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testSearchContactsReturnsCollection()
    {
        $contact = factory('App\Contact')->make();
        $searchResults = $contact->search($contact->first_name, $contact->account_id, 10);

        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $searchResults);
    }

    /** @test */
    public function testSearchContactsThroughFirstNameAndResultContainsContact()
    {
        $contact = factory('App\Contact')->create(['first_name' => 'FirstName']);
        $searchResults = $contact->search($contact->first_name, $contact->account_id, 10);

        $this->assertTrue($searchResults->contains($contact));
    }

    /** @test */
    public function testSearchContactsThroughMiddleNameAndResultContainsContact()
    {
        $contact = factory('App\Contact')->create(['middle_name' => 'MiddleName']);
        $searchResults = $contact->search($contact->middle_name, $contact->account_id, 10);

        $this->assertTrue($searchResults->contains($contact));
    }

    /** @test */
    public function testSearchContactsThroughLastNameAndResultContainsContact()
    {
        $contact = factory(\App\Contact::class)->create(['last_name' => 'LastName']);

        $searchResults = $contact->search($contact->last_name, $contact->account_id, 10);

        $this->assertTrue($searchResults->contains($contact));
    }

    /** @test */
    public function testSearchContactsThroughFoodPreferencesAndResultContainsContact()
    {
        $contact = factory(\App\Contact::class)->create(['food_preferencies' => 'Food Preference']);
        $searchResults = $contact->search($contact->food_preferencies, $contact->account_id, 10);

        $this->assertTrue($searchResults->contains($contact));
    }

    /** @test */
    public function testSearchContactsThroughJobAndResultContainsContact()
    {
        $contact = factory(\App\Contact::class)->create(['job' => 'Job']);
        $searchResults = $contact->search($contact->job, $contact->account_id, 10);

        $this->assertTrue($searchResults->contains($contact));
    }

    /** @test */
    public function testSearchContactsThroughCompanyAndResultContainsContact()
    {
        $contact = factory(\App\Contact::class)->create(['company' => 'Company']);
        $searchResults = $contact->search($contact->company, $contact->account_id, 10);

        $this->assertTrue($searchResults->contains($contact));
    }

    /** @test */
    public function testFailingSearchContacts()
    {
        $contact = factory(\App\Contact::class)->create(['first_name' => 'TestShouldFail']);
        $searchResults = $contact->search('TestWillSucceed', $contact->account_id, 10);

        $this->assertFalse($searchResults->contains($contact));
    }
}
