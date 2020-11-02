<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Model;

class Linea_cotizacion extends Model
{
    protected $table="linea_cotizacion";
    protected $fillable = ['cotizacion_id', 'descripcion', 'subtotal'];
    protected $guarded = ['id'];

    public function equipo()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
}
