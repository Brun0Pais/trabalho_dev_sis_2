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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->date('dataEntrega')->nullable()->after('dataPedido');
            $table->string('localEntrega')->nullable()->after('dataEntrega');
            $table->string('statusPagamento')->default('pendente')->after('localEntrega');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['dataEntrega', 'localEntrega', 'statusPagamento']);
        });
    }
};
