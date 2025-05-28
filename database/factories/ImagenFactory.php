<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ruta' => 'productos/' . $this->faker->uuid . '.jpg',
            'producto_id' => Producto::factory(),
        ];
    }
}
