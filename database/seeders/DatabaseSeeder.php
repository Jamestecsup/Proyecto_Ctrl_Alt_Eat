<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Establecimiento;
use App\Models\Oferta;
use App\Models\MetodoPago;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@ctrlalt-eat.test'], ['name' => 'Administración', 'role' => 'administrador', 'password' => Hash::make('Admin123!')]);
        User::firstOrCreate(['email' => 'cliente@ctrlalt-eat.test'], ['name' => 'Cliente Demo', 'role' => 'cliente', 'password' => Hash::make('Cliente123!')]);
        User::firstOrCreate(['email' => 'establecimiento@ctrlalt-eat.test'], ['name' => 'Establecimiento Demo', 'role' => 'establecimiento', 'password' => Hash::make('Establecimiento123!')]);

        $categoriaPanaderia = Categoria::firstOrCreate(['name' => 'Panadería'], ['description' => 'Pan, pasteles y productos horneados']);
        $categoriaComida = Categoria::firstOrCreate(['name' => 'Comida preparada'], ['description' => 'Platos preparados del día']);
        $categoriaFrutas = Categoria::firstOrCreate(['name' => 'Frutas y verduras'], ['description' => 'Frutas y verduras frescas']);
        $categoriaPostres = Categoria::firstOrCreate(['name' => 'Postres'], ['description' => 'Postres y productos dulces']);

        $panaderia = Establecimiento::firstOrCreate(['tax_id' => '20123456789'], ['name' => 'Panadería La Esquina', 'address' => 'Av. Arequipa 1234, Lima', 'phone' => '987654321']);
        $restaurante = Establecimiento::firstOrCreate(['tax_id' => '20123456780'], ['name' => 'Restaurante Verde Lima', 'address' => 'Calle Schell 245, Miraflores', 'phone' => '987654322']);
        $fruteria = Establecimiento::firstOrCreate(['tax_id' => '20123456781'], ['name' => 'Frutería Mercado Fresco', 'address' => 'Av. La Mar 810, Miraflores', 'phone' => '987654323']);
        $cafeteria = Establecimiento::firstOrCreate(['tax_id' => '20123456782'], ['name' => 'Cafetería Dulce Nube', 'address' => 'Jr. Colina 120, Barranco', 'phone' => '987654324']);

        MetodoPago::firstOrCreate(['name' => 'Yape'], ['details' => 'Billetera digital']);
        MetodoPago::firstOrCreate(['name' => 'Tarjeta'], ['details' => 'Débito o crédito']);
        MetodoPago::firstOrCreate(['name' => 'Plin'], ['details' => 'Billetera digital']);

        $horaRecojo = now()->addDays(2)->setTime(20, 0);

        $ofertaPanes = Oferta::firstOrCreate(
            ['name' => 'Pack de panes del día', 'establishment_id' => $panaderia->id],
            ['category_id' => $categoriaPanaderia->id, 'description' => 'Selección de panes integrales y de masa madre horneados hoy.', 'stock' => 8, 'regular_price' => 12.00, 'sale_price' => 5.00, 'pickup_until' => $horaRecojo, 'image' => 'images/offers/bread.jpg', 'active' => true],
        );
        if (!$ofertaPanes->image) $ofertaPanes->update(['image' => 'images/offers/bread.jpg']);

        $ofertaFresas = Oferta::firstOrCreate(
            ['name' => 'Fresas de temporada', 'establishment_id' => $fruteria->id],
            ['category_id' => $categoriaFrutas->id, 'description' => 'Fresas maduras, seleccionadas para disfrutar hoy.', 'stock' => 10, 'regular_price' => 18.00, 'sale_price' => 8.00, 'pickup_until' => $horaRecojo, 'image' => 'images/offers/fruit.jpg', 'active' => true],
        );
        if (!$ofertaFresas->image) $ofertaFresas->update(['image' => 'images/offers/fruit.jpg']);

        $ofertaBowl = Oferta::firstOrCreate(
            ['name' => 'Bowl de almuerzo', 'establishment_id' => $restaurante->id],
            ['category_id' => $categoriaComida->id, 'description' => 'Bowl de pollo y verduras preparado esta mañana.', 'stock' => 6, 'regular_price' => 24.00, 'sale_price' => 11.00, 'pickup_until' => $horaRecojo, 'image' => 'images/offers/salad.jpg', 'active' => true],
        );
        if (!$ofertaBowl->image) $ofertaBowl->update(['image' => 'images/offers/salad.jpg']);

        $ofertaMenu = Oferta::firstOrCreate(
            ['name' => 'Menú casero del día', 'establishment_id' => $restaurante->id],
            ['category_id' => $categoriaComida->id, 'description' => 'Porción de comida casera lista para recoger.', 'stock' => 5, 'regular_price' => 22.00, 'sale_price' => 10.00, 'pickup_until' => $horaRecojo, 'image' => 'images/offers/meal.jpg', 'active' => true],
        );
        if (!$ofertaMenu->image) $ofertaMenu->update(['image' => 'images/offers/meal.jpg']);

        $ofertaVerduras = Oferta::firstOrCreate(
            ['name' => 'Canasta de verduras frescas', 'establishment_id' => $fruteria->id],
            ['category_id' => $categoriaFrutas->id, 'description' => 'Verduras variadas que conservan toda su frescura.', 'stock' => 7, 'regular_price' => 20.00, 'sale_price' => 9.00, 'pickup_until' => $horaRecojo, 'image' => 'images/offers/vegetables.jpg', 'active' => true],
        );
        if (!$ofertaVerduras->image) $ofertaVerduras->update(['image' => 'images/offers/vegetables.jpg']);

        $ofertaGalletas = Oferta::firstOrCreate(
            ['name' => 'Galletas artesanales', 'establishment_id' => $cafeteria->id],
            ['category_id' => $categoriaPostres->id, 'description' => 'Paquete de galletas horneadas en la cafetería.', 'stock' => 4, 'regular_price' => 15.00, 'sale_price' => 6.00, 'pickup_until' => $horaRecojo, 'image' => 'images/offers/bakery.jpg', 'active' => true],
        );
        if (!$ofertaGalletas->image) $ofertaGalletas->update(['image' => 'images/offers/bakery.jpg']);
    }
}
