<?php

namespace Tests\Unit\Services\Contact\Conversation;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Account\Account;
use Illuminate\Support\Facades\DB;
use App\Exceptions\MissingParameterException;
use App\Services\Auth\Population\PopulateModulesTable;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopulateModulesTableTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_fails_if_wrong_parameters_are_given()
    {
        $request = [
            'account_id' => 1,
        ];

        $this->expectException(\Exception::class);

        $populateModulesService = new PopulateModulesTable;
        $populateModulesService->execute($request);

        $request = [
            'migrate_existing_data' => false,
        ];

        $this->expectException(MissingParameterException::class);

        $populateModulesService = new PopulateModulesTable;
        $populateModulesService->execute($request);
    }

    public function test_it_populate_modules_tables()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create([
            'account_id' => $account->id,
        ]);

        DB::table('default_contact_modules')
            ->where('key', 'work_education')
            ->update(['migrated' => 0]);

        $request = [
            'account_id' => $account->id,
            'migrate_existing_data' => 1,
        ];

        $populateModulesService = new PopulateModulesTable;
        $populateModulesService->execute($request);

        // by defauult there is 17 columns in the default table.
        // therefore, we need 17 entries for the new account.
        $this->assertEquals(
            17,
            DB::table('modules')->where('account_id', $account->id)->get()->count()
        );

        // make sure tables have been set to migrated = 1
        $this->assertDatabaseMissing('default_contact_modules', [
            'migrated' => 0,
        ]);
    }

    public function test_it_only_populates_module_tables_partially()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create([
            'account_id' => $account->id,
        ]);

        DB::table('default_contact_modules')
            ->update(['migrated' => 0]);

        DB::table('default_contact_modules')
            ->where('key', 'love_relationships')
            ->update(['migrated' => 1]);

        // we will only migrate the ones that haven't been populated yet
        $request = [
            'account_id' => $account->id,
            'migrate_existing_data' => 0,
        ];

        $populateModulesService = new PopulateModulesTable;
        $populateModulesService->execute($request);

        // by defauult there is 17 columns in the default table.
        // therefore, we need 16 entries for the new account.
        $this->assertEquals(
            16,
            DB::table('modules')->where('account_id', $account->id)->get()->count()
        );
    }
}
