<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_transactions', function (Blueprint $table) {

            $table->integer('system_stock')->nullable();
            $table->integer('physical_stock')->nullable();
            $table->string('source')->default('TRANSACTION'); 
            
        });
    }


    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropColumn('system_stock');
            $table->dropColumn('physical_stock');
            $table->dropColumn('source');
        });
    }

};
