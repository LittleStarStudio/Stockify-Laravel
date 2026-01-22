<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        //CRUD TABLE
        // 5 = ACTIVE (LENGKAP)
        for ($i = 1; $i <= 5; $i++) {
            Category::updateOrCreate(
                ['name' => "Product Category {$i}"],
                [
                    'description' => "Deskripsi kategori aktif lengkap {$i}",
                    'is_active'   => true,
                ]
            );
        }

        // 5 = ACTIVE (TANPA DESCRIPTION)
        for ($i = 6; $i <= 10; $i++) {
            Category::updateOrCreate(
                ['name' => "Product Category {$i}"],
                [
                    'description' => null,
                    'is_active'   => true,
                ]
            );
        }

        // 5 = INACTIVE (LENGKAP)
        for ($i = 11; $i <= 15; $i++) {
            Category::updateOrCreate(
                ['name' => "Product Category {$i}"],
                [
                    'description' => "Deskripsi kategori inactive lengkap {$i}",
                    'is_active'   => false,
                ]
            );
        }

        // 5 = INACTIVE (TANPA DESCRIPTION)
        for ($i = 16; $i <= 20; $i++) {
            Category::updateOrCreate(
                ['name' => "Product Category {$i}"],
                [
                    'description' => null,
                    'is_active'   => false,
                ]
            );
        }

        // BIN TABLE
        // 1 = ACTIVE (LENGKAP)
        Category::updateOrCreate(
            ['name' => "Product Category Bin"],
            [
                'description' => "Deskripsi category bin active lengkap",
                'is_active'   => true,
                'deleted_at' => $now,
            ]
        );

        // 1 = ACTIVE (TANPA DESCRIPTION)
        Category::updateOrCreate(
            ['name' => "Product Category Bin"],
            [
                'description' => null,
                'is_active'   => true,
                'deleted_at' => $now,
            ]
        );

        // 1 = INACTIVE (LENGKAP)
        Category::updateOrCreate(
            ['name' => "Product Category Bin"],
            [
                'description' => "Deskripsi category bin inactive lengkap",
                'is_active'   => false,
                'deleted_at' => $now,
            ]
        );

        // 1 = INACTIVE (TANPA DESCRIPTION)
        Category::updateOrCreate(
            ['name' => "Product Category Bin"],
            [
                'description' => null,
                'is_active'   => false,
                'deleted_at' => $now,
            ]
        );
    }
}
