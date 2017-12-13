<?php

namespace App\Console\Commands;

use App\User;
use App\Contact;
use Illuminate\Console\Command;

class ImportCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv {user : email or id of a user} {file : path to the CSV file} {--format=google}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports CSV in Google format to user account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (is_int($this->argument('user'))) {
            $user = User::find($this->argument('user'));
        } else {
            $user = User::where('email', $this->argument('user'))->first();
        }

        if (! file_exists($file)) {
            $this->error('You need to provide a valid file path.');

            return -1;
        }

        if (! $user) {
            $this->error('You need to provide a valid User ID or email address!');

            return -1;
        }

        $this->info("Importing CSV file $file to user {$user->id}");

        $row = 0;
        $imported = 0;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $row++;

                // don't import the columns
                if ($row == 1) {
                    continue;
                }

                $contact = new Contact();
                $contact->account_id = $user->id;

                // if first & last name do not exist skip row
                if (empty($data[1]) && empty($data[3])) {
                    continue;
                }

                if (! empty($data[1])) {
                    $contact->first_name = $data[1];    // Given Name
                }

                if (! empty($data[2])) {
                    $contact->middle_name = $data[2];   // Additional Name
                }

                if (! empty($data[3])) {
                    $contact->last_name = $data[3];     // Family Name
                }

                if (! empty($data[28])) {
                    $contact->email = $data[28];        // Email 1 Value
                }

                if (! empty($data[42])) {
                    $contact->phone_number = $data[42]; // Phone 1 Value
                }

                if (! empty($data[49])) {
                    $contact->street = $data[49];       // address 1 street
                }

                if (! empty($data[50])) {
                    $contact->city = $data[50];         // address 1 city
                }
                if (! empty($data[52])) {
                    $contact->province = $data[52];     // address 1 region (state)
                }

                if (! empty($data[53])) {
                    $contact->postal_code = $data[53];  // address 1 postal code (zip) 53
                }
                if (! empty($data[66])) {
                    $contact->job = $data[66];          // organization 1 name 66
                }

                // can't have empty email
                if (empty($contact->email)) {
                    $contact->email = null;
                }

                $contact->save();
                $contact->setAvatarColor();

                if (! empty($data[14])) {
                    $birthdate = date('Y-m-d', strtotime($data[14]));

                    $specialDate = $contact->setSpecialDate('birthdate', $birthdate->format('Y'), $birthdate->format('m'), $birthdate->format('d'));
                    $newReminder = $specialDate->setReminder('year', 1, trans('people.people_add_birthday_reminder', ['name' => $contact->first_name]));
                }

                $imported++;
            }
            fclose($handle);
        }

        $this->info("Imported {$imported} Contacts");
    }
}
