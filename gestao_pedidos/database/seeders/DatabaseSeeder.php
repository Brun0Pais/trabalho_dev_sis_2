<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário admin padrão
        Usuario::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'nome' => 'Administrador',
                'cpf' => '00000000000',
                'senha' => Hash::make('admin123'),
                'tipo' => 'admin',
                'telefone' => '(00) 00000-0000',
            ]
        );

        // Criar usuário cliente padrão
        Usuario::firstOrCreate(
            ['email' => 'cliente@cliente.com'],
            [
                'nome' => 'Cliente Teste',
                'cpf' => '11111111111',
                'senha' => Hash::make('cliente123'),
                'tipo' => 'cliente',
                'telefone' => '(00) 11111-1111',
            ]
        );

        $this->call([
            UsuarioSeeder::class,
            ProdutoSeeder::class,
            EstoqueSeeder::class,
            PedidoSeeder::class,
        ]);
    }
}
