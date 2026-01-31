<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'nullable',
                'email',
                Rule::unique('suppliers', 'email')
                    ->whereNull('deleted_at')
                    ->ignore($this->supplier->id),
            ],

            'phone' => [
                'nullable',
                'string',
                Rule::unique('suppliers', 'phone')
                    ->whereNull('deleted_at')
                    ->ignore($this->supplier->id),
            ],

            'address' => ['nullable', 'string'],
        ];
    }

}
