<?php

namespace App\Exports;

use App\Models\StockOpname;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockOpnamesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return StockOpname::with(['items.product','staff','manager'])
            ->get()
            ->flatMap(function($op){
                return $op->items->map(function($item) use ($op){
                    return [
                        $op->date,
                        $item->product->sku,
                        $item->product->name,
                        $item->difference,
                        $op->staff->name,
                        optional($op->manager)->name,
                        $op->status,
                    ];
                });
            });
    }

    public function headings(): array
    {
        return [
            'Opname Date','SKU','Product',
            'Diff',
            'Staff','Manager',
            'Status',
        ];
    }
}
