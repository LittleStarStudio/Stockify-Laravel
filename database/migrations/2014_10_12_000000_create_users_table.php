<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // User Role
            $table->enum('role', ['admin', 'manajer_gudang', 'staff_gudang'])->default('staff_gudang');

            // Untuk system approval
            $table->enum('approval_status', ['pending', 'active', 'rejected'])->default('pending');

            $table->rememberToken();
            $table->timestamps();

            // Untuk Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
