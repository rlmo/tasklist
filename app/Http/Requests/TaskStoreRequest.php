<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TaskStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            "title" => "required|max:64",
            "description" => "required",
            "completed" => "required|integer|gte:0|lte:1",
            "username" => "required|max:64",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "Field 'title' is required",
            "title.max" => "Title maximum size is 64 characters",
            "description.required" => "Field 'description' is required",
            "completed.required" => "Field 'completed' is required",
            "completed.integer" => "Field 'completed' must be an integer between 0 and 1",
            "completed.gte" => "Field 'completed' must be an integer between 0 and 1",
            "completed.lte" => "Field 'completed' must be an integer between 0 and 1",
            "username.required" => "Field 'username' is required",
            "username.max" => "Username maximum size is 64 characters",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["Errors" => $validator->errors()], 400));
    }
}
