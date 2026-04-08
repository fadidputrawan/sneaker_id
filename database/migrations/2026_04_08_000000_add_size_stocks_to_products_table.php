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
        Schema::table('products', function (Blueprint $table) {
            // Add stock columns for each size
            if (!Schema::hasColumn('products', 'stok_39')) {
                $table->integer('stok_39')->default(0)->after('stok');
                $table->integer('stok_40')->default(0)->after('stok_39');
                $table->integer('stok_41')->default(0)->after('stok_40');
                $table->integer('stok_42')->default(0)->after('stok_41');
                $table->integer('stok_43')->default(0)->after('stok_42');
                $table->integer('stok_44')->default(0)->after('stok_43');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'stok_39')) {
                $table->dropColumn(['stok_39', 'stok_40', 'stok_41', 'stok_42', 'stok_43', 'stok_44']);
            }
        });
    }
};
