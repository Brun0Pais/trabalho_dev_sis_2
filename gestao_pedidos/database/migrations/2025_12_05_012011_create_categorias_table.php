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
        if (!Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->text('descricao')->nullable();
                $table->boolean('ativo')->default(true);
                $table->timestamps();
            });
        } else {
            // Se a tabela já existe, apenas adicionar colunas que faltam
            Schema::table('categorias', function (Blueprint $table) {
                if (!Schema::hasColumn('categorias', 'nome')) {
                    $table->string('nome')->after('id');
                }
                if (!Schema::hasColumn('categorias', 'descricao')) {
                    $table->text('descricao')->nullable()->after('nome');
                }
                if (!Schema::hasColumn('categorias', 'ativo')) {
                    $table->boolean('ativo')->default(true)->after('descricao');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
