    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('produtos', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->text('descricao')->nullable();
                $table->string('ingredientesPrincipais')->nullable();
                $table->decimal('precoUnidade', 8, 2);
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('produtos');
        }
    };
