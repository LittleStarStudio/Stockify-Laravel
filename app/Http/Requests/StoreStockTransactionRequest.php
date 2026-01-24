<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockTransactionRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'type'   => strtoupper($this->type),
            'status' => $this->status ? strtoupper($this->status) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:IN,OUT',
            'quantity'   => 'required|integer|min:1',
            'date'       => 'required|date',
            'status'     => 'nullable|in:PENDING,RECEIVED,REJECTED,ISSUED',
            'notes'      => 'nullable|string'
        ];
    }
}
