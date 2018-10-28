<?php

namespace App\Services\User;

use App\Models\User\User;
use App\Services\BaseService;
use App\Exceptions\MissingParameterException;

class EmailChange extends BaseService
{
    /**
     * The structure that the method expects to receive as parameter.
     *
     * @var array
     */
    private $structure = [
        'account_id',
        'email',
        'user_id',
    ];

    /**
     * Update email of the user.
     *
     * @param array $data
     * @return User
     */
    public function execute(array $data) : User
    {
        if (! $this->validateDataStructure($data, $this->structure)) {
            throw new MissingParameterException('Missing parameters');
        }

        $user = User::where('account_id', $data['account_id'])
            ->findOrFail($data['user_id']);

        // Change email of the user
        $user->email = $data['email'];

        if (config('monica.signup_double_optin')) {
            // Resend validation token
            $user->email_verified_at = null;
            $user->save();

            $user->sendEmailVerificationNotification();
        } else {
            $user->save();
        }

        return $user;
    }
}
