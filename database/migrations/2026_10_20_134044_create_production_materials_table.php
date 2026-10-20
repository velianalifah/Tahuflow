<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_id')->constrained()->cascadeOnDelete();
            $table->foreignId('raw_material_id')->constrained()->restrictOnDelete();
            $table->decimal('qty_used', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_materials');
    }
};
