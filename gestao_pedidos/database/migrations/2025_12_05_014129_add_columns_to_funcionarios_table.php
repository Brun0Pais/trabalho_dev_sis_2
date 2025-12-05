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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $columns = ['ativo', 'dataAdmissao', 'cargo', 'telefone', 'cpf', 'email', 'nome'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('funcionarios', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
