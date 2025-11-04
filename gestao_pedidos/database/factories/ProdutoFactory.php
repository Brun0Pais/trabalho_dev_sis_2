<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->words(3, true),
            'descricao' => $this->faker->sentence(),
            'ingredientesPrincipais' => $this->faker->words(5, true),
            'precoUnidade' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
