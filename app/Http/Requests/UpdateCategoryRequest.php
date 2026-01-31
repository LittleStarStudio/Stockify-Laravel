<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:categories,name,'.$this->category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

}
