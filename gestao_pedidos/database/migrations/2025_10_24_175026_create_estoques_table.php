<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->integer('quantidadeDisponivel')->default(0);
            $table->timestamps();
            $table->date('dataEntrada')->nullable();
            $table->date('datasaida')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
