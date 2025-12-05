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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            if (Schema::hasColumn('categorias', 'ativo')) {
                $table->dropColumn('ativo');
            }
            if (Schema::hasColumn('categorias', 'descricao')) {
                $table->dropColumn('descricao');
            }
            if (Schema::hasColumn('categorias', 'nome')) {
                $table->dropColumn('nome');
            }
        });
    }
};
