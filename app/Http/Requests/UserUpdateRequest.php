<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        // Hanya admin yang boleh mengupdate user
        return auth()->check() && auth()->user()->role === 'admin';
    }

    
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',

                // Email harus unik (kecuali untuk user yang sedang diupdate)
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'manajer_gudang',
                    'staff_gudang',
                ]),
            ],

            'approval_status' => [
                'required',
                Rule::in([
                    'active',
                    'rejected',
                ]),
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',    
            ],
        ];
    }

    
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email has already been taken.',

            'role.required' => 'Role is required.',
            'role.in' => 'Selected role is invalid.',

            'approval_status.required' => 'Approval status is required.',
            'approval_status.in' => 'Approval status should be either active or rejected.',

            'avatar.image' => 'Avatar must be an image file.',
            'avatar.mimes' => 'Avatar must be a file of type: jpg, jpeg, png.',
            'avatar.max' => 'Avatar size must not exceed 2MB.',
        ];
    }


    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(

            response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422)
            
        );

    }

}
