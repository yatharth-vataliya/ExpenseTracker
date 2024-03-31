<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumns('transactions', ['total'])) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('total')->storedAs('(item_count / 100 * item_price / 100) * 100')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('transactions', ['total'])) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->integer('total')->storedAs('item_count * item_price')->change();
            });
        }
    }
};
