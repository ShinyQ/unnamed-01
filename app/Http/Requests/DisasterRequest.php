<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Api;

class DisasterRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'name' => ['required', 'string'],
                'region' => ['required', 'string'],
                'city' => ['required', 'string'],
                'description' => ['required', 'string'],
                'datetime' => ['required'],
                'status' => ['required', 'string'],
                'type' => ['required', 'string'],
            ];
        } else if ($this->isMethod('put')) {
            return [
                'name' => [],
                'region' => [],
                'city' => [],
                'description' => [],
                'datetime' => [],
                'status' => [],
                'type' => [],
            ];
        }
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, Api::apiRespond(400, $validator->errors()->all()));
    }
}
