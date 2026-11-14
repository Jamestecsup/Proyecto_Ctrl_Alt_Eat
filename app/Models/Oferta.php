<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Oferta extends Model
{
    protected $table = 'ofertas';
    protected $fillable = ['category_id', 'establishment_id', 'name', 'description', 'stock', 'regular_price', 'sale_price', 'pickup_until', 'image', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean', 'pickup_until' => 'datetime', 'regular_price' => 'decimal:2', 'sale_price' => 'decimal:2'];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'category_id');
    }

    public function establecimiento(): BelongsTo
    {
        return $this->belongsTo(Establecimiento::class, 'establishment_id');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'offer_id');
    }
}
