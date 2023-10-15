<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'address.billing.first_name'=> ['required','string','max:255'],
            'address.billing.last_name'=> ['required','string','max:255'],
            'address.billing.email'=> ['required','email','max:255'],
            'address.billing.phone_number'=> ['required','numeric','max:255'],
            'address.billing.city'=>['required','string','max:255'],
        ];
    }
}
