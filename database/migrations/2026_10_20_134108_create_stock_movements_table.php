<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('item_type', ['product', 'raw_material']);
            $table->unsignedBigInteger('item_id');
            $table->enum('type', ['in', 'out']);
            $table->decimal('qty', 12, 2);
            $table->string('reference', 50)->nullable();
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
