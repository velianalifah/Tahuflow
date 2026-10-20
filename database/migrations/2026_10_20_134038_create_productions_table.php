<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->date('date');
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->decimal('qty_produced', 12, 2);
            $table->decimal('qty_failed', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
