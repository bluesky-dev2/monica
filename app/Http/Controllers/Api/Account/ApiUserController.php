<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\Settings\Term;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Account\User\User as UserResource;

class ApiUserController extends ApiController
{
    /**
     * Get the detail of the authenticated user.
     *
     * @param Request $request
     *
     * @return UserResource
     */
    public function show(Request $request): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Get the state of a specific term for the user.
     *
     * @param Request $request
     * @param int $termId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, $termId)
    {
        $userCompliance = auth()->user()->getStatusForCompliance($termId);

        if (! $userCompliance) {
            return $this->respondNotFound();
        }

        return $this->respond([
            'data' => $userCompliance,
        ]);
    }

    /**
     * Get all the policies ever signed by the authenticated user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function compliance(Request $request)
    {
        $terms = auth()->user()->getAllCompliances();

        return $this->respond([
            'data' => $terms,
        ]);
    }

    /**
     * Sign the latest policy for the authenticated user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip_address' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->respondValidatorFailed($validator);
        }

        // Create the contact
        try {
            $term = auth()->user()->acceptPolicy($request->input('ip_address'));
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        $userCompliance = auth()->user()->getStatusForCompliance($term->id);

        return $this->respond([
            'data' => $userCompliance,
        ]);
    }
}
