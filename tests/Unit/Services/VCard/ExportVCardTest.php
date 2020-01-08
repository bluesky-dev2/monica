<?php

namespace Tests\Unit\Services\VCard;

use Tests\TestCase;
use App\Models\Contact\Tag;
use Tests\Api\DAV\CardEtag;
use App\Models\Contact\Gender;
use App\Models\Account\Account;
use App\Models\Contact\Address;
use App\Models\Contact\Contact;
use Sabre\VObject\Component\VCard;
use App\Services\VCard\ExportVCard;
use App\Models\Contact\ContactField;
use Sabre\VObject\PHPUnitAssertions;
use App\Models\Contact\ContactFieldType;
use App\Services\Contact\Tag\AssociateTag;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExportVCardTest extends TestCase
{
    use DatabaseTransactions,
        PHPUnitAssertions,
        CardEtag;

    /** @var int */
    const defaultPropsCount = 3;

    /** @test */
    public function vcard_add_names()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
        ]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportNames', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 2,
            $vCard->children()
        );
        $this->assertStringContainsString('FN:John Doe', $vCard->serialize());
        $this->assertStringContainsString('N:Doe;John;;;', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_nickname()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'nickname' => 'the nickname',
        ]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportNames', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 3,
            $vCard->children()
        );
        $this->assertStringContainsString('FN:John Doe', $vCard->serialize());
        $this->assertStringContainsString('N:Doe;John;;;', $vCard->serialize());
        $this->assertStringContainsString('NICKNAME:the nickname', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_gender()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
        ]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportGender', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('GENDER:M', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_gender_female()
    {
        $account = factory(Account::class)->create();
        $gender = factory(Gender::class)->create([
            'account_id' => $account->id,
            'type' => 'F',
            'name' => 'Female',
        ]);
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'gender_id' => $gender->id,
        ]);
        $vCard = new VCard();

        $exportVCard = new ExportVCard();
        $this->invokePrivateMethod($exportVCard, 'exportGender', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('GENDER:F', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_gender_unknown()
    {
        $account = factory(Account::class)->create();
        $gender = factory(Gender::class)->create([
            'account_id' => $account->id,
            'type' => 'U',
        ]);
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'gender_id' => $gender->id,
        ]);
        $vCard = new VCard();

        $exportVCard = new ExportVCard();
        $this->invokePrivateMethod($exportVCard, 'exportGender', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('GENDER:U', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_gender_type_null()
    {
        $account = factory(Account::class)->create();
        $gender = factory(Gender::class)->create([
            'account_id' => $account->id,
            'type' => null,
            'name' => 'Something',
        ]);
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'gender_id' => $gender->id,
        ]);
        $vCard = new VCard();

        $exportVCard = new ExportVCard();
        $this->invokePrivateMethod($exportVCard, 'exportGender', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('GENDER:O', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_gender_type_null_male()
    {
        $account = factory(Account::class)->create();
        $gender = factory(Gender::class)->create([
            'account_id' => $account->id,
            'type' => null,
            'name' => 'Male',
        ]);
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'gender_id' => $gender->id,
        ]);
        $vCard = new VCard();

        $exportVCard = new ExportVCard();
        $this->invokePrivateMethod($exportVCard, 'exportGender', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('GENDER:O', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_gender_type_null_female()
    {
        $account = factory(Account::class)->create();
        $gender = factory(Gender::class)->create([
            'account_id' => $account->id,
            'type' => null,
            'name' => 'Woman',
        ]);
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'gender_id' => $gender->id,
        ]);
        $vCard = new VCard();

        $exportVCard = new ExportVCard();
        $this->invokePrivateMethod($exportVCard, 'exportGender', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('GENDER:F', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_photo()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $vCard = new VCard();

        $contact->avatar_source = 'gravatar';
        $contact->avatar_gravatar_url = 'gravatar';

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportPhoto', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('PHOTO;VALUE=URI:gravatar', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_work_org()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'company' => 'the company',
        ]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportWorkInformation', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('ORG:the company', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_work_title()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'job' => 'job position',
        ]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportWorkInformation', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('TITLE:job position', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_work_information()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
            'company' => 'the company',
            'job' => 'job position',
        ]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportWorkInformation', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 2,
            $vCard->children()
        );
        $this->assertStringContainsString('ORG:the company', $vCard->serialize());
        $this->assertStringContainsString('TITLE:job position', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_birthday()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $contact->setSpecialDate('birthdate', 2000, 10, 5);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportBirthday', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('BDAY:20001005', $vCard->serialize());
    }

    /** @test */
    public function vcard_add_contact_fields_empty()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportContactFields', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount,
            $vCard->children()
        );
    }

    /** @test */
    public function vcard_add_contact_fields()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $vCard = new VCard();

        $contactFieldType = factory(ContactFieldType::class)->create(['account_id' => $account->id]);
        $contactField = factory(ContactField::class)->create([
            'contact_id' => $contact->id,
            'account_id' => $account->id,
            'contact_field_type_id' => $contactFieldType->id,
        ]);

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportContactFields', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString('EMAIL:john@doe.com', $vCard->serialize());
    }

    /**
     * @test
     * @dataProvider socialProfileProvider
     */
    public function vcard_add_social_profile($name, $type, $data, $result)
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $vCard = new VCard();

        $contactFieldType = factory(ContactFieldType::class)->create([
            'account_id' => $account->id,
            'name' => $name,
            'type' => $type,
        ]);
        factory(ContactField::class)->create([
            'contact_id' => $contact->id,
            'account_id' => $account->id,
            'contact_field_type_id' => $contactFieldType->id,
            'data' => $data,
        ]);

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportContactFields', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 1,
            $vCard->children()
        );
        $this->assertStringContainsString($result, $vCard->serialize());
    }

    public function socialProfileProvider()
    {
        return [
            ['Facebook', 'Facebook', 'test', 'SOCIALPROFILE;TYPE=facebook:https://www.facebook.com/test'],
            ['Twitter', 'Twitter', 'test', 'SOCIALPROFILE;TYPE=twitter:https://twitter.com/test'],
            ['Whatsapp', 'Whatsapp', 'test', 'SOCIALPROFILE;TYPE=whatsapp:https://wa.me/test'],
            ['Telegram', 'Telegram', 'test', 'SOCIALPROFILE;TYPE=telegram:http://t.me/test'],
            ['LinkedIn', 'LinkedIn', 'test', 'SOCIALPROFILE;TYPE=linkedin:http://www.linkedin.com/in/test'],
        ];
    }

    /** @test */
    public function vcard_add_addresses_empty()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $vCard = new VCard();

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportAddress', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount,
            $vCard->children()
        );
    }

    /** @test */
    public function vcard_add_addresses()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);
        $vCard = new VCard();

        $address = factory(Address::class)->create([
            'contact_id' => $contact->id,
            'name' => 'Home',
            'account_id' => $account->id,
        ]);

        $address = factory(Address::class)->create([
            'contact_id' => $contact->id,
            'name' => 'Home',
            'account_id' => $account->id,
        ]);

        $exportVCard = app(ExportVCard::class);
        $this->invokePrivateMethod($exportVCard, 'exportAddress', [$contact, $vCard]);

        $this->assertCount(
            self::defaultPropsCount + 2,
            $vCard->children()
        );
        $this->assertStringContainsString('ADR:;;12;beverly hills;;90210;US', $vCard->serialize());
        $this->assertStringContainsString('ADR:;;12;beverly hills;;90210;US', $vCard->serialize());
    }

    /** @test */
    public function vcard_prepares_an_almost_empty_vcard()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id])->refresh();

        $exportVCard = app(ExportVCard::class);
        $vCard = $this->invokePrivateMethod($exportVCard, 'export', [$contact]);

        $this->assertCount(
            self::defaultPropsCount + 6,
            $vCard->children()
        );

        $this->assertVObjectEqualsVObject($this->getCard($contact), $vCard);
    }

    /** @test */
    public function vcard_prepares_a_complete_vcard()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create(['account_id' => $account->id]);

        $address = factory(Address::class)->create([
            'contact_id' => $contact->id,
            'name' => 'Home',
            'account_id' => $account->id,
        ]);

        $address = factory(Address::class)->create([
            'contact_id' => $contact->id,
            'name' => 'Home',
            'account_id' => $account->id,
        ]);

        $contactFieldType = factory(ContactFieldType::class)->create(['account_id' => $account->id]);
        $contactField = factory(ContactField::class)->create([
            'contact_id' => $contact->id,
            'account_id' => $account->id,
            'contact_field_type_id' => $contactFieldType->id,
        ]);

        $exportVCard = app(ExportVCard::class);
        $contact = $contact->refresh();
        $vCard = $this->invokePrivateMethod($exportVCard, 'export', [$contact]);

        $this->assertCount(
            self::defaultPropsCount + 9,
            $vCard->children()
        );

        $this->assertVObjectEqualsVObject($this->getCard($contact), $vCard);
    }

    /** @test */
    public function vcard_with_tags()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->create([
            'account_id' => $account->id,
        ]);

        $tag = factory(Tag::class)->create([
            'account_id' => $contact->account_id,
        ]);

        $request = [
            'account_id' => $contact->account->id,
            'contact_id' => $contact->id,
            'name' => $tag->name,
        ];

        app(AssociateTag::class)->execute($request);

        $exportVCard = app(ExportVCard::class);
        $contact = $contact->refresh();
        $vCard = $this->invokePrivateMethod($exportVCard, 'export', [$contact]);

        $this->assertCount(
            self::defaultPropsCount + 7,
            $vCard->children()
        );

        $this->assertVObjectEqualsVObject($this->getCard($contact), $vCard);
    }
}
