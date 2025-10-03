<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique()->after('name');
            $table->string('contact_number', 15)->after('email');
            $table->enum('gender', ['male', 'female', 'other'])->after('contact_number');
            $table->timestamp('terms_accepted_at')->nullable()->after('gender');
        });
    }

    // Reverse the migrations
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'contact_number', 'gender', 'terms_accepted_at']);
        });
    }
};