<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RevenueRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'weeks' => ['sometimes', 'integer', 'min:1', 'max:104'],
        ];
    }
}
