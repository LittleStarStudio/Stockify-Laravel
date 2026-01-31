<?php

namespace App\Exports;

use App\Models\StockTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockTransactionsExport implements FromCollection, WithHeadings
{
    protected $from,$to,$type;

    public function __construct($from,$to,$type=null)
    {
        $this->from = $from;
        $this->to   = $to;
        $this->type = $type;
    }

    public function collection()
    {
        $query = StockTransaction::with(['product','user','approver'])
            ->whereBetween('date', [$this->from, $this->to]);

        if ($this->type) {
            $query->where('type', $this->type);
        }

        return $query->get()->map(function($t){
            return [
                $t->date,
                $t->product->sku,
                $t->product->name,
                $t->type,
                $t->quantity,
                $t->status,
                $t->source,
                $t->user->name,
                optional($t->approver)->name,
                $t->notes
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date','SKU','Product','Type',
            'Qty','Status','Source',
            'User','Approved By',
            'Notes'
        ];
    }
}
