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
        if (!Schema::hasTable('funcionarios')) {
            Schema::create('funcionarios', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('email')->unique();
                $table->string('cpf', 14)->unique();
                $table->string('telefone')->nullable();
                $table->string('cargo')->nullable();
                $table->date('dataAdmissao')->nullable();
                $table->boolean('ativo')->default(true);
                $table->timestamps();
            });
        } else {
            // Se a tabela já existe, apenas adicionar colunas que faltam
            Schema::table('funcionarios', function (Blueprint $table) {
                if (!Schema::hasColumn('funcionarios', 'nome')) {
                    $table->string('nome')->after('id');
                }
                if (!Schema::hasColumn('funcionarios', 'email')) {
                    $table->string('email')->unique()->after('nome');
                }
                if (!Schema::hasColumn('funcionarios', 'cpf')) {
                    $table->string('cpf', 14)->unique()->after('email');
                }
                if (!Schema::hasColumn('funcionarios', 'telefone')) {
                    $table->string('telefone')->nullable()->after('cpf');
                }
                if (!Schema::hasColumn('funcionarios', 'cargo')) {
                    $table->string('cargo')->nullable()->after('telefone');
                }
                if (!Schema::hasColumn('funcionarios', 'dataAdmissao')) {
                    $table->date('dataAdmissao')->nullable()->after('cargo');
                }
                if (!Schema::hasColumn('funcionarios', 'ativo')) {
                    $table->boolean('ativo')->default(true)->after('dataAdmissao');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
