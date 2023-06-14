<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Equipo extends Model
{
    protected $table="equipo";
    protected $fillable = ['obra_id', 'empresa_id', 'oe', 'velocidad', 'paradas', 'carga', 'marca', 'modelo', 'accesos', 'cuarto_maquina', 'numero_equipo', 'plano'];
    protected $guarded = ['id'];

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public static function setPlane($plane, $actual = false){
        if ($plane) {
            if ($actual) {
                cloudinary()->destroy($actual);
            }
            $result = cloudinary()->upload(
                $plane->getRealPath(),
                [
                    'transformation' => [
                        'gravity' => 'auto',
                        'width' => 800,
                        'height' => 800,
                        'crop' => 'crop',
                    ],
                    'folder' => 'files/planes/'
                ]
            )->getSecurePath();
            return $result;
        } else {
            return false;
        }
    }
}
