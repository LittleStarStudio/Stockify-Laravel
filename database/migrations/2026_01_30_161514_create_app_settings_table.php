<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('logo')->nullable();
            $table->string('language')->default('English');
            $table->string('version')->default('v1.0.0');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
