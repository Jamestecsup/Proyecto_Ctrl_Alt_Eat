<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Establecimiento extends Model
{
    protected $table = 'establishments';
    protected $fillable = ['name', 'tax_id', 'address', 'phone', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    public function ofertas(): HasMany
    {
        return $this->hasMany(Oferta::class, 'establishment_id');
    }
}
