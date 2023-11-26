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
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('transaction_type_id')->constrained()->onDelete('CASCADE');
            $table->text('description')->nullable();
            $table->integer('item_count');
            $table->string('item_unit')->nullable();
            $table->integer('item_price');
            $table->integer('total');
            $table->dateTime('transaction_date')->default(now());
            $table->softDeletes();
            $table->dateTime('created_at')->default(now());
            $table->dateTime('updated_at')->nullable();
            // $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            // $table->foreign('transaction_type_id')->references('id')->on('transactions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
