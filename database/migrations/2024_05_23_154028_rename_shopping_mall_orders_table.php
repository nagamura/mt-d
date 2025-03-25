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
        Schema::table('shopping_mall_orders', function (Blueprint $table) {
            $table->renameColumn('is_stock_confim', 'is_stock_confirm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shopping_mall_orders', function (Blueprint $table) {
            $table->renameColumn('is_stock_confirm', 'is_stock_confim');
        });
    }
};
