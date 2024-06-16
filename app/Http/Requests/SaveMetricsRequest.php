<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaveMetricsRequest extends FormRequest
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
            'accessibility_metric' => 'nullable|numeric|between:0,1',
            'pwa_metric' => 'nullable|numeric|between:0,1',
            'performance_metric' => 'nullable|numeric|between:0,1',
            'seo_metric' => 'nullable|numeric|between:0,1',
            'best_practices_metric' => 'nullable|numeric|between:0,1',
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
