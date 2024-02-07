<?php

namespace App\Http\Requests;

use App\Traits\ValidationExceptionHandlerTrait;
use Illuminate\Foundation\Http\FormRequest;

class UsersListRequest extends FormRequest
{
    use ValidationExceptionHandlerTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'page' => 'integer|min:1',
            'offset' => 'integer|min:0',
            'count' => 'integer|max:100|min:1',
        ];
    }
}
