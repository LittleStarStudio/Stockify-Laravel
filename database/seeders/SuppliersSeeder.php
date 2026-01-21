<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SuppliersSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 5 (DATA LENGKAP)
        for ($i = 1; $i <= 5; $i++) {
            Supplier::updateOrCreate(
                ['email' => "supplier{$i}@stockify.com"],
                [
                    'name' => "Supplier Lengkap {$i}",
                    'address' => "Jl. Industri No. {$i}",
                    'phone' => "08123{$i}56789",
                ]
            );
        }

        // 5 (ADDRESS = NULL)
        for ($i = 6; $i <= 10; $i++) {
            Supplier::updateOrCreate(
                ['email' => "supplier{$i}@stockify.com"],
                [
                    'name' => "Supplier Tanpa Address {$i}",
                    'address' => null,
                    'phone' => "08123{$i}56789",
                ]
            );
        }

        // 5 (PHONE = NULL)
        for ($i = 11; $i <= 15; $i++) {
            Supplier::updateOrCreate(
                ['email' => "supplier{$i}@stockify.com"],
                [
                    'name' => "Supplier Tanpa Phone {$i}",
                    'address' => "Jl. Gudang No. {$i}",
                    'phone' => null,
                ]
            );
        }

        // 5 (EMAIL = NULL)
        for ($i = 16; $i <= 20; $i++) {
            Supplier::updateOrCreate(
                ['name' => "Supplier Tanpa Email {$i}"],
                [
                    'email' => null,
                    'address' => "Jl. Logistik No. {$i}",
                    'phone' => "08199{$i}000",
                ]
            );
        }

        // 5 (SELAIN NAMA = NULL)
        for ($i = 21; $i <= 25; $i++) {
            Supplier::updateOrCreate(
                ['name' => "Supplier Nama Saja {$i}"],
                [
                    'email' => null,
                    'address' => null,
                    'phone' => null,
                ]
            );
        }


        // 2 (LENGKAP DI BIN)
        for ($i = 26; $i <= 27; $i++) {
            Supplier::updateOrCreate(
                ['email' => "supplier{$i}@stockify.com"],
                [
                    'name' => "Supplier Bin Lengkap {$i}",
                    'address' => "Jl. Bin No. {$i}",
                    'phone' => "08999{$i}888",
                    'deleted_at' => $now,
                ]
            );
        }

        // 1 (ADDRESS = NULL DI BIN)
        Supplier::updateOrCreate(
            ['email' => "supplier28@stockify.com"],
            [
                'name' => "Supplier Bin Tanpa Address",
                'address' => null,
                'phone' => "089992888",
                'deleted_at' => $now,
            ]
        );

        // 1 (PHONE = NULL DI BIN)
        Supplier::updateOrCreate(
            ['email' => "supplier29@stockify.com"],
            [
                'name' => "Supplier Bin Tanpa Phone",
                'address' => "Jl. Bin No. 29",
                'phone' => null,
                'deleted_at' => $now,
            ]
        );

        // 1 (EMAIL = NULL DI BIN)
        Supplier::updateOrCreate(
            ['name' => "Supplier Bin Tanpa Email"],
            [
                'email' => null,
                'address' => "Jl. Bin No. 30",
                'phone' => "089993000",
                'deleted_at' => $now,
            ]
        );
    }
}
