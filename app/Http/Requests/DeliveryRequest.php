<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
      public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lng' => ['required', 'numeric'] ,
            'lat' => ['required', 'numeric'],
        ];
    }
}
