<?php

use App\Enums\TodoStatus;
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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(TodoStatus::TODO->value);
            $table->string('column_type'); // Tipo de coluna (todo ou done)
            $table->integer('order'); // Ordem dentro da coluna
            $table->timestamps();

            $table->unique(['column_type', 'order']); // Garantir unicidade de order por tipo de coluna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
