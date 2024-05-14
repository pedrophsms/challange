<?php

namespace Database\Factories;

use App\Models\Transportadora;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transportadora>
 */
class TransportadoraFactory extends Factory
{
    protected $model = Transportadora::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'nome' => fake()->name(),
            'endereco' => fake()->streetAddress(),
            'bairro' => fake()->word(),
            'cidade' => fake()->city(),
            'uf' => fake()->stateAbbr(),
            'limite_credito' => fake()->randomFloat(2, 100, 1000),
            'data_analise_credito' => fake()->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ];
    }
}
