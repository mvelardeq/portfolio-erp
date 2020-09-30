<?php

namespace App\Models\Seguridad;

use App\Models\Admin\Ascenso_trabajador;
use App\Models\Admin\Obs_trabajador;
use App\Models\Admin\Periodo_trabajador;
use App\Models\Admin\Rol;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Trabajador extends Authenticatable
{
    protected $remeber_token = false;
    protected $table = 'trabajador';
    protected $fillable = ['usuario', 'password', 'primer_nombre', 'segundo_nombre','primer_apellido','segundo_apellido', 'correo', 'dni', 'direccion','celular', 'fecha_nacimiento','foto', 'botas', 'overol',];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'trabajador_rol');
    }

    public function observaciones()
    {
        return $this->HasMany(Obs_trabajador::class);
    }

    public function periodos()
    {
        return $this->HasMany(Periodo_trabajador::class);
    }

    public function ascensos()
    {
        return $this->HasMany(Ascenso_trabajador::class);
    }

    public function setSession($roles)
    {
        Session::put([
            'usuario' => $this->usuario,
            'trabajador_id' => $this->id,
            'nombre_trabajador' => $this->primer_nombre." ".$this->primer_apellido,
            // 'foto' => $this->foto
        ]);
        if (count($roles) == 1) {
            Session::put(
                [
                    'rol_id' => $roles[0]['id'],
                    'rol_nombre' => $roles[0]['nombre'],
                ]
            );
        }else {
            Session::put('roles', $roles);
        }
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public static function setFoto($foto, $actual = false){
        if ($foto) {
            if ($actual) {
                Storage::disk('public')->delete("imagenes/fotosTrabajadores/$actual");
            }
            $imageName = Str::random(14) . '.jpg';
            $imagen = Image::make($foto)->encode('jpg', 75);
        $imagen->resize(600, 800, function ($constraint) {
                $constraint->upsize();
            });
            Storage::disk('public')->put("imagenes/fotosTrabajadores/$imageName", $imagen->stream());
            return $imageName;
        } else {
            return false;
        }
    }
}
