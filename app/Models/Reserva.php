<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = ['user_id', 'offer_id', 'payment_method_id', 'quantity', 'total', 'status', 'pickup_code', 'rating', 'review'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function oferta(): BelongsTo
    {
        return $this->belongsTo(Oferta::class, 'offer_id');
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class, 'payment_method_id');
    }
}
