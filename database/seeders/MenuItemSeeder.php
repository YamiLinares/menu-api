<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Bruschetta mediterránea', 'Pan de masa madre, tomate heirloom, albahaca y aceite de oliva.', 9.50, 'entradas', true],
            ['Tartar de atún rojo', 'Atún fresco, aguacate, cítricos y sésamo tostado.', 16.00, 'entradas', true],
            ['Croquetas de yuca', 'Yuca cremosa, queso ahumado y alioli de chipotle.', 10.00, 'entradas', true],
            ['Ceviche de coco', 'Pescado blanco, leche de coco, lima y cilantro fresco.', 14.50, 'entradas', true],
            ['Risotto de hongos', 'Arroz arborio, setas silvestres, parmesano y aceite de trufa.', 19.50, 'platos-fuertes', true],
            ['Salmón al limón', 'Salmón a la plancha, vegetales de temporada y mantequilla de limón.', 24.00, 'platos-fuertes', true],
            ['Lomo en salsa de vino', 'Lomo de res, reducción de vino tinto y puré de camote.', 28.00, 'platos-fuertes', true],
            ['Pollo al mole verde', 'Pollo de corral, mole de pepitoria y arroz con hierbas.', 21.00, 'platos-fuertes', true],
            ['Pasta de mariscos', 'Pasta fresca, camarones, mejillones y salsa de azafrán.', 25.50, 'platos-fuertes', false],
            ['Ensalada de quinoa', 'Quinoa, aguacate, vegetales asados y vinagreta de naranja.', 15.00, 'ensaladas', true],
            ['Ensalada de burrata', 'Burrata, tomates de estación, durazno y reducción balsámica.', 17.50, 'ensaladas', true],
            ['Ensalada de hojas verdes', 'Hojas tiernas, pera, nueces caramelizadas y queso azul.', 14.00, 'ensaladas', true],
            ['Tarta de chocolate', 'Chocolate oscuro, sal marina y crema batida.', 9.00, 'postres', true],
            ['Cheesecake de frutos rojos', 'Cheesecake artesanal con compota de frutos rojos.', 8.50, 'postres', true],
            ['Flan de café', 'Flan de vainilla, café de altura y caramelo.', 8.00, 'postres', true],
            ['Limonada de hierbabuena', 'Limón recién exprimido, hierbabuena y un toque de jengibre.', 5.50, 'bebidas', true],
            ['Horchata de almendra', 'Bebida artesanal de arroz y almendra con canela.', 5.00, 'bebidas', true],
            ['Té frío de hibisco', 'Infusión de hibisco, cítricos y miel local.', 4.50, 'bebidas', false],
        ];

        foreach ($items as [$name, $description, $price, $category, $isAvailable]) {
            MenuItem::updateOrCreate(['name' => $name], compact('description', 'price', 'category') + ['is_available' => $isAvailable]);
        }
    }
}
