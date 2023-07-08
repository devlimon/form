<?php

namespace App\Http\Requests;

use App\Rules\SymbolValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckFormData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_symbol' => ['required',new SymbolValidationRule],
            'start_date' => 'required|date|before_or_equal:now|before_or_equal:end_date',
            'end_date' => 'required|date|before_or_equal:now|after_or_equal:start_date',
            'email' => 'required|email:rfc,dns',
        ];

    }
}
