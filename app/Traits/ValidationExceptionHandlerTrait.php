<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

trait ValidationExceptionHandlerTrait
{
    protected function failedValidation(Validator $validator)
    {
        if (Route::currentRouteName() == 'store') {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag);
        }
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'fails' => $validator->errors(),
        ], 422));
    }
}
