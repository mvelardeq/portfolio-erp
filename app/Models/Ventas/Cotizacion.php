<?php

namespace App\Models\Ventas;

use App\Models\Operaciones\Equipo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Cotizacion extends Model
{
    protected $table="cotizacion";
    protected $fillable = ['equipo_id', 'numero', 'resumen', 'fecha', 'dirigido_a', 'pdf', 'observacion'];
    protected $guarded = ['id'];

    public function lineas_cotizacion()
    {
        return $this->HasMany(Linea_cotizacion::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public static function setQuotation($ruta_pdf, $actual=false){
        // return var_dump($pdf);
        if ($ruta_pdf) {
            if ($actual) {
                cloudinary()->destroy($actual);
            }
            $result = cloudinary()->upload($ruta_pdf,[
                "folder"=>"files/quotation/",
            ])->getSecurePath();
            return $result;
        } else {
            return false;
        }

    }
}
