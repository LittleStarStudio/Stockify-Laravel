<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppSetting;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        AppSetting::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'Stockify',
                'logo' => null,
                'language' => 'English',
                'version' => 'v1.0.0',
            ]
        );
    }
}
