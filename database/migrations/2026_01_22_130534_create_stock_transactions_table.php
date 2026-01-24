<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            
            $table->enum('type', ['IN', 'OUT']);
            $table->integer('quantity');

            $table->date('date');

            $table->enum('status', [
                'PENDING',
                'RECEIVED',
                'REJECTED',
                'ISSUED'
            ])->default('PENDING');

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
