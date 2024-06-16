<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FetchMetricsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'url' => 'required|url',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'strategy_id' => 'required|integer|exists:strategies,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}
