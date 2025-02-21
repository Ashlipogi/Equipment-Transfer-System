<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transferred_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('transfer_to')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('transferred_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferred_items');
    }
};
