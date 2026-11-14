<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodoPago extends Model
{
    protected $table = 'metodos_pago';
    protected $fillable = ['name', 'details', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'payment_method_id');
    }
}
