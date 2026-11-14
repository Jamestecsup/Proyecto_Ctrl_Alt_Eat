<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['cache_locks', 'cache', 'failed_jobs', 'job_batches', 'jobs', 'password_reset_tokens', 'model_has_permissions', 'model_has_roles', 'role_has_permissions', 'permissions', 'roles', 'sessions'] as $tabla) {
            Schema::dropIfExists($tabla);
        }

        $tablas = [
            'categories' => 'categorias',
            'establishments' => 'establecimientos',
            'payment_methods' => 'metodos_pago',
            'offers' => 'ofertas',
            'reservations' => 'reservas',
            'users' => 'usuarios',
        ];

        foreach ($tablas as $anterior => $nuevo) {
            if (Schema::hasTable($anterior) && ! Schema::hasTable($nuevo)) {
                Schema::rename($anterior, $nuevo);
            }
        }
    }

    public function down(): void
    {
        $tablas = [
            'categorias' => 'categories',
            'establecimientos' => 'establishments',
            'metodos_pago' => 'payment_methods',
            'ofertas' => 'offers',
            'reservas' => 'reservations',
            'usuarios' => 'users',
        ];

        foreach ($tablas as $anterior => $nuevo) {
            if (Schema::hasTable($anterior) && ! Schema::hasTable($nuevo)) {
                Schema::rename($anterior, $nuevo);
            }
        }
    }
};
