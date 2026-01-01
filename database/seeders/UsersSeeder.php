<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => 'Admin',
            'manajer_gudang' => 'Manajer Gudang',
            'staff_gudang' => 'Staff Gudang',
        ];

        foreach ($roles as $roleKey => $roleLabel) {

            // 1 ACTIVE
            User::updateOrCreate(
                ['email' => strtolower(str_replace(' ', '', $roleLabel)) . '_active@stockify.com'],
                [
                    'name' => $roleLabel . ' Active',
                    'password' => Hash::make('password'),
                    'role' => $roleKey,
                    'approval_status' => 'active',
                ]
            );

            // 1 REJECTED
            User::updateOrCreate(
                ['email' => strtolower(str_replace(' ', '', $roleLabel)) . '_rejected@stockify.com'],
                [
                    'name' => $roleLabel . ' Rejected',
                    'password' => Hash::make('password'),
                    'role' => $roleKey,
                    'approval_status' => 'rejected',
                ]
            );

            // 5 PENDING
            for ($i = 1; $i <= 5; $i++) {
                User::updateOrCreate(
                    ['email' => strtolower(str_replace(' ', '', $roleLabel)) . "_pending{$i}@stockify.com"],
                    [
                        'name' => "{$roleLabel} Pending {$i}",
                        'password' => Hash::make('password'),
                        'role' => $roleKey,
                        'approval_status' => 'pending',
                    ]
                );
            }
        }
    }
}
