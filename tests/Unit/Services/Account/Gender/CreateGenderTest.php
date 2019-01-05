<?php

namespace Tests\Unit\Services\Account\Gender;

use Tests\TestCase;
use App\Models\Contact\Gender;
use App\Models\Account\Account;
use App\Exceptions\MissingParameterException;
use App\Services\Account\Gender\CreateGender;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateGenderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_stores_a_gender()
    {
        $account = factory(Account::class)->create([]);

        $request = [
            'account_id' => $account->id,
            'name' => 'man',
        ];

        $genderService = new CreateGender;
        $gender = $genderService->execute($request);

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'account_id' => $account->id,
            'name' => 'man',
        ]);

        $this->assertInstanceOf(
            Gender::class,
            $gender
        );
    }

    public function test_it_fails_if_wrong_parameters_are_given()
    {
        $account = factory(Account::class)->create([]);

        $request = [
            'name' => 'man',
        ];

        $this->expectException(MissingParameterException::class);
        (new CreateGender)->execute($request);
    }
}
