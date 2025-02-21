<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained()->onDelete('cascade'); // Foreign key to the parent table
            $table->integer('qty');
            $table->text('description');
            $table->date('date_purchase');
            $table->string('property_no');
            $table->string('classification_no');
            $table->string('unit');
            $table->decimal('total_value', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
