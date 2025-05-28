<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(),
            'comprador_id' => Usuario::factory(),
            'imagen_ticket' => 'tickets/fake.jpg',
            'estado' => $this->faker->randomElement(['pendiente', 'validada']),
        ];
    }
}
