<?php

namespace App\Core\Http\Requests;

use App\Core\Traits\FormatResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    use FormatResponse;

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, $this->buildResponse($validator)));
    }

    protected function buildResponse($validator)
    {
        $response = $this->formatResponse('error', __('validation.validation_message'), $validator->errors());
        return response($response, 422);
    }
}
