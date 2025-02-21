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
        Schema::table('transferred_items', function (Blueprint $table) {
            $table->string('position_intended_transfer')->nullable()->after('name_designation');
            $table->string('position_intended_office')->nullable()->after('designated_office_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transferred_items', function (Blueprint $table) {
            $table->dropColumn('position_intended_transfer');
            $table->dropColumn('position_intended_office');
        });
    }
};
