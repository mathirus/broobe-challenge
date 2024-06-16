<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindMetricRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:metric_history_runs,id',
        ];
    }
}
