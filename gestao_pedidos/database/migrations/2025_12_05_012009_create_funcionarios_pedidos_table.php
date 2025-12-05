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
        if (!Schema::hasTable('funcionarios_pedidos')) {
            Schema::create('funcionarios_pedidos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
                $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
                $table->string('funcao')->nullable(); // Ex: 'preparador', 'entregador', 'atendente'
                $table->timestamps();
                
                // Evitar duplicatas
                $table->unique(['funcionario_id', 'pedido_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios_pedidos');
    }
};
