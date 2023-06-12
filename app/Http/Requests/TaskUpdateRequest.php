<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TaskUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            "title" => "max:64",
            "completed" => "integer|gte:0|lte:1",
            "username" => "max:64",
        ];
    }

    public function messages()
    {
        return [
            "title.max" => "Title maximum size is 64 characters",
            "completed.integer" => "Field 'completed' must be an integer between 0 and 1",
            "completed.gte" => "Field 'completed' must be an integer between 0 and 1",
            "completed.lte" => "Field 'completed' must be an integer between 0 and 1",
            "username.max" => "Username maximum size is 64 characters",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["Errors" => $validator->errors()], 400));
    }
}
