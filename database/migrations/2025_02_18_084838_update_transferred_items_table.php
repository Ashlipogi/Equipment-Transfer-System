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
            // First rename the remarks column to name_designation
            $table->renameColumn('remarks', 'name_designation');

            // Then add the new designated_office column
            $table->string('designated_office')->nullable()->after('name_designation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transferred_items', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('name_designation', 'remarks');
            $table->dropColumn('designated_office');
        });
    }
};
