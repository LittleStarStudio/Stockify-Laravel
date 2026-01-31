<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->foreignId('approved_by')
                ->nullable()
                ->after('user_id')
                ->constrained('users');
        });
    }

    public function down()
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
        });
    }

};
