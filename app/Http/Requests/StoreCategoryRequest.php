<?php

namespace App\Http\Requests;

use App\Rules\Filter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('categories.create');
    }


    public function rules(): array
    {
        return [
            'name'=>['required','min:2','max:255',Rule::unique('categories','name'), new Filter(['sex','ass','fuck'])],
            'image'=>'required|image|max:1048576|mimes:jpg,jpeg,gif,png',
            'parent_id'=>'nullable|int|exists:categories,id',
            'description'=>'required|min:2|max:255',
            'status'=>'required|in:active,archived',
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This input field is required!',
            'unique'=>'This category already exists!',
        ];
    }
}
