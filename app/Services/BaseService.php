<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\MissingParameterException;

abstract class BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Validate all documents in an account.
     *
     * @param array $data
     * @return bool
     */
    public function validate(array $data) : bool
    {
        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            throw new MissingParameterException('Missing parameters', $validator->errors()->all());
        }

        return true;
    }

    /**
     * Checks if the value is empty or null.
     *
     * @param mixed $data
     * @param mixed $index
     * @return mixed
     */
    protected function nullOrValue($data, $index)
    {
        if (empty($data[$index])) {
            return;
        }

        return $data[$index] == '' ? null : $data[$index];
    }
}
