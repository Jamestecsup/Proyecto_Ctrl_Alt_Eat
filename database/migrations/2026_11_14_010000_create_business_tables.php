<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('establecimientos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tax_id', 11)->unique();
            $table->string('address');
            $table->string('phone', 30);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('details')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categorias')->restrictOnDelete();
            $table->foreignId('establishment_id')->constrained('establecimientos')->restrictOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('stock');
            $table->decimal('regular_price', 8, 2);
            $table->decimal('sale_price', 8, 2);
            $table->dateTime('pickup_until');
            $table->string('image')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('offer_id')->constrained('ofertas')->restrictOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained('metodos_pago')->nullOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('total', 8, 2);
            $table->string('status')->default('reservado');
            $table->string('pickup_code')->nullable()->unique();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('review', 300)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
        Schema::dropIfExists('ofertas');
        Schema::dropIfExists('metodos_pago');
        Schema::dropIfExists('establecimientos');
        Schema::dropIfExists('categorias');
    }
};
