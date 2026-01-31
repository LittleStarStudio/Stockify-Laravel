<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with(['category','supplier'])
            ->get()
            ->map(function($p){
                return [
                    $p->sku,
                    $p->name,
                    $p->category->name ?? '-',
                    $p->supplier->name ?? '-',
                    $p->purchase_price,
                    $p->selling_price,
                    $p->current_stock,
                    $p->minimum_stock,
                    $p->is_active ? 'ACTIVE' : 'INACTIVE',
                    $p->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'SKU','Name','Category','Supplier',
            'Purchase Price','Selling Price',
            'Current Stock','Min Stock',
            'Status','Created At'
        ];
    }
}
