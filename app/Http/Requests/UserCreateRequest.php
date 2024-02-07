<?php

namespace App\Http\Requests;

use App\Traits\ValidationExceptionHandlerTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|string|min:2|max:100',
            'phone' => 'required|string|regex:/^[\+]{0,1}380([0-9]{9})$/',
            'position_id' => 'required|integer|min:1',
            'photo' => [
                'required',
                'dimensions:min_width=70,min_height=70',
                File::types(['jpg', 'jpeg'])->max(5120)
            ],
        ];
    }
}
