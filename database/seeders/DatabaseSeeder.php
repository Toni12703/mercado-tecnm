<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\Imagen;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Categorías reales tipo Mercado Libre
        $categorias = collect([
            Categoria::create(['nombre' => 'Electrónica']),
            Categoria::create(['nombre' => 'Ropa y Calzado']),
            Categoria::create(['nombre' => 'Hogar y Cocina']),
            Categoria::create(['nombre' => 'Juguetes y Niños']),
            Categoria::create(['nombre' => 'Ofertas']),
        ]);

        $nombresCompradores = [
            'Luis Hernández', 'Ana Pérez', 'Carlos Ramírez', 'María López', 'José Martínez',
            'Laura Sánchez', 'Fernando Gómez', 'Sofía Castro', 'Daniel Vargas', 'Patricia Díaz',
            'Ricardo Torres', 'Alejandra Moreno', 'Iván Ríos', 'Gabriela León', 'Óscar Navarro',
            'Verónica Ruiz', 'Eduardo Mendoza', 'Claudia Aguirre', 'Rafael Ortega', 'Mónica Pineda',
            'Miguel Silva', 'Lucía Treviño', 'Jorge Acosta', 'Paola Méndez', 'Arturo Salinas',
            'Julieta Domínguez', 'Alonso Reyes', 'Natalia Romero', 'Hugo Cordero', 'Karina Varela',
            'Mauricio Bravo', 'Liliana Esquivel', 'Tomás Villanueva', 'Daniela Rocha', 'Pablo Estrada',
            'Camila Serrano', 'Raúl Camacho', 'Brenda Castillo', 'Andrés Lozano', 'Ximena Calderón',
            'Marco Beltrán', 'Melissa Cuevas', 'Julián Fuentes', 'Elena Peña', 'Cristian Del Valle',
            'Fátima Beltrán', 'Samuel Arellano', 'Rebeca Peralta', 'Diego Villaseñor', 'Diana Rentería',
            'Ángel Carreón', 'Yesenia Cano', 'Kevin Llamas', 'Martha Juárez', 'Gerardo Ayala',
            'Irene Cedillo', 'Esteban Gaitán', 'Silvia Tamez', 'David Barragán', 'Maricela Prado',
            'Axel Fierro', 'Bianca Luna', 'Isaac Olea', 'Flor Cordero', 'Jonathan Castañeda',
            'Valeria Rosales', 'Emilio Galván', 'Nancy Fierro', 'Sebastián Araujo', 'Lupita Báez'
        ];


        foreach ($nombresCompradores as $i => $nombre) {
            Usuario::factory()->create([
                'name' => $nombre,
                'email' => 'comprador' . ($i + 1) . '@gmail.com',
                'role' => 'cliente-comprador',
            ]);
        }

        $nombresVendedores = [
            'Juan Torres', 'Andrea Ríos', 'Diego Márquez', 'Carla Valencia', 'Ramón Zúñiga',
            'Isabel Guzmán', 'Alan Vega', 'Lucero Peña', 'Rodrigo Salgado', 'Daniela Sáenz',
            'Cristina Bautista', 'Erick Barrera', 'Rosa Dávila', 'Joaquín Solano', 'Tania Godoy',
            'Luis Miguel Chávez', 'Itzel Medina', 'Jesús Bustamante', 'Liliana Coronado', 'Saúl Pérez',
            'Mariana Ibarra', 'Álvaro Fuentes', 'Elisa Olvera', 'Noé Castro', 'Abril Carrillo',
            'Bruno Padilla', 'Romina Guerrero', 'Mateo Yáñez', 'Estefanía Del Ángel', 'Bastián Ruiz'
        ];

        $descripciones = [
            'Audífonos inalámbricos' => 'Audífonos Bluetooth con micrófono, ideales para llamadas y música.',
            'Smartwatch Xiaomi' => 'Reloj inteligente con monitor de ritmo cardíaco y notificaciones.',
            'Power Bank' => 'Batería portátil de 10,000 mAh compatible con USB y USB-C.',
            'Bocina Bluetooth' => 'Bocina recargable con conexión inalámbrica y sonido envolvente.',
            'Tenis Adidas' => 'Tenis deportivos originales Adidas para correr o uso diario.',
            'Camisa de mezclilla' => 'Camisa casual de mezclilla para hombre, color azul oscuro.',
            'Sudadera Nike' => 'Sudadera con capucha Nike, cómoda para climas frescos.',
            'Jeans para dama' => 'Pantalón de mezclilla ajustado para mujer, corte moderno.',
            'Licuadora Oster' => 'Licuadora de vidrio con motor potente y 3 velocidades.',
            'Juego de sartenes' => 'Set de sartenes antiadherentes para cocina saludable.',
            'Funda para sofá' => 'Funda elástica para proteger y decorar tu sofá.',
            'Cafetera eléctrica' => 'Cafetera automática con capacidad de 12 tazas.',
            'Muñeca Barbie' => 'Muñeca original Barbie con accesorios incluidos.',
            'Lego Classic' => 'Set de piezas Lego para construcción creativa.',
            'Pelota de fútbol' => 'Balón de fútbol tamaño oficial para entrenamientos.',
            'Rompecabezas 1000 piezas' => 'Rompecabezas de paisaje con 1000 piezas resistentes.',
            'Combo de utensilios' => 'Set de cocina con espátulas, cucharas y pinzas.',
            'Playera básica' => 'Camiseta de algodón unisex en varios colores.',
            'Kit de herramientas' => 'Kit básico de herramientas para el hogar con maletín.',
            'Cargador USB-C' => 'Cargador rápido compatible con dispositivos Android y laptops.'
        ];

        $compradores = Usuario::where('role', 'cliente-comprador')->get();

        foreach ($nombresVendedores as $i => $nombre) {
            $vendedor = Usuario::factory()->create([
                'name' => $nombre,
                'email' => 'vendedor' . ($i + 1) . '@gmail.com',
                'role' => 'cliente-vendedor',
            ]);

            $nombresProductos = [
                'Electrónica' => ['Audífonos inalámbricos', 'Smartwatch Xiaomi', 'Power Bank', 'Bocina Bluetooth'],
                'Ropa y Calzado' => ['Tenis Adidas', 'Camisa de mezclilla', 'Sudadera Nike', 'Jeans para dama'],
                'Hogar y Cocina' => ['Licuadora Oster', 'Juego de sartenes', 'Funda para sofá', 'Cafetera eléctrica'],
                'Juguetes y Niños' => ['Muñeca Barbie', 'Lego Classic', 'Pelota de fútbol', 'Rompecabezas 1000 piezas'],
                'Ofertas' => ['Combo de utensilios', 'Playera básica', 'Kit de herramientas', 'Cargador USB-C']
            ];

            for ($j = 0; $j < 3; $j++) {
                $categoria = $categorias->random();
                $categoriaNombre = $categoria->nombre;
                $nombreProducto = fake()->randomElement($nombresProductos[$categoriaNombre] ?? ['Producto Genérico']);
                $descripcion = $descripciones[$nombreProducto] ?? 'Producto de buena calidad a excelente precio.';

                $producto = Producto::factory()->create([
                    'id_user' => $vendedor->id_user,
                    'nombre' => $nombreProducto,
                    'descripcion' => $descripcion,
                ]);

                $producto->categorias()->attach($categorias->random(rand(1, 3))->pluck('id'));

                Imagen::factory(rand(1, 2))->create([
                    'producto_id' => $producto->id,
                ]);

                Venta::factory(rand(0, 2))->create([
                    'producto_id' => $producto->id,
                    'comprador_id' => $compradores->random()->id_user,
                    'estado' => 'pendiente',
                ]);
            }
        }
    }
}
