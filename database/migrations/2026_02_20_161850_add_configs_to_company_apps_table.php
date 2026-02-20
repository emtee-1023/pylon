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
        Schema::table('company_apps', function (Blueprint $table) {
            $table->json('branding')->nullable()->after('app_id');
            $table->json('api_config')->nullable()->after('branding');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_apps', function (Blueprint $table) {
            $table->dropColumn('branding');
            $table->dropColumn('api_config');
        });
    }
};
