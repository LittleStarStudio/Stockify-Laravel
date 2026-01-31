<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::get()->map(function($u){
            return [
                $u->name,
                $u->email,
                $u->role,
                $u->approved ? 'YES' : 'NO',
                $u->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name','Email','Role',
            'Approved','Registered At'
        ];
    }
}
