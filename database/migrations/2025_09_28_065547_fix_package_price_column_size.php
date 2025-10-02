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
        Schema::table('package', function (Blueprint $table) {
            // Change package_price from DECIMAL(8,2) to DECIMAL(12,2)
            // This allows up to 999,999,999.99 (10 digits before decimal)
            $table->decimal('package_price', 12, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package', function (Blueprint $table) {
            // Revert back to original size (though this might cause data loss)
            $table->decimal('package_price', 8, 2)->change();
        });
    }
};
