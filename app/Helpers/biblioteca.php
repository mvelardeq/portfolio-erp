<?php

use Illuminate\Support\Str;
use App\Models\Admin\Permiso;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

if (!function_exists('getMenuActivo')) {
    function getMenuActivo($ruta)
    {
        if (request()->is($ruta) || request()->is($ruta . '/*')) {
            return 'active';
        } else {
            return '';
        }
    }
}

if (!function_exists('getMenuOpen')) {
    function getMenuOpen($nombre)
    {
        $n1 = request()->path();
        $nombre2 = Str::lower($nombre);
        $nombre3 = Str::ascii($nombre2);
        if (Str::is('*'.$nombre3.'/*', $n1)) {
            return 'menu-open';
        } else {
            return '';
        }
    }
}

if (!function_exists('getMenuActive')) {
    function getMenuActive($nombre)
    {
        $n1 = request()->path();
        $nombre2 = Str::lower($nombre);
        $nombre3 = Str::ascii($nombre2);
        if (Str::is($nombre3.'/*', $n1)) {
            return 'active';
        } else {
            return '';
        }
    }
}

if (!function_exists('canUser')) {
    function can($permiso, $redirect = true)
    {
        if (session()->get('rol_nombre') == 'administrador') {
            return true;
        } else {
            $rolId = session()->get('rol_id');
            $permisos = cache()->tags('permiso')->rememberForever("permiso.rolid.$rolId", function () {
                return Permiso::whereHas('roles', function ($query) {
                    $query->where('rol_id', session()->get('rol_id'));
                })->get()->pluck('slug')->toArray();
            });
            if (!in_array($permiso, $permisos)) {
                if ($redirect) {
                    if (!request()->ajax())
                        // return redirect()->route('home')->with('mensaje', 'No tienes permisos para esa acción')->send();
                        return back()->withInput()->with('mensaje','No tienes permisos para esa acción')->send();
                    abort(403, 'No tiene permiso');
                } else {
                    return false;
                }
            }
            return true;
        }
    }
}


if (!function_exists('canUser')) {
    function canTrue($permiso, $redirect = true)
    {
        if (session()->get('rol_nombre') == 'administrador') {
            return true;
        } else {
            $rolId = session()->get('rol_id');
            $permisos = cache()->tags('permiso')->rememberForever("permiso.rolid.$rolId", function () {
                return Permiso::whereHas('roles', function ($query) {
                    $query->where('rol_id', session()->get('rol_id'));
                })->get()->pluck('slug')->toArray();
            });
            if (!in_array($permiso, $permisos)) {
                return false;
            }
            return true;
        }
    }
}



if (!function_exists('getPublicIdByUrl')) {
    function getPublicIdByUrl($url)
{
    // Obtener la parte de la ruta de la URL después del dominio de Cloudinary
    $ruta = parse_url($url, PHP_URL_PATH);

    // Eliminar el prefijo "/v{timestamp}/" si está presente
    $ruta = preg_replace('/\/v\d+/', '', $ruta);

    // Eliminar las barras iniciales y finales de la ruta
    $ruta = trim($ruta, '/');

    // Obtener el public ID eliminando los segmentos iniciales de la ruta
    $segmentos = explode('/', $ruta);
    $publicId = implode('/', array_slice($segmentos, 3));

    // Eliminar la extensión del archivo si está presente
    $publicId = preg_replace('/\.\w+$/', '', $publicId);

    return $publicId;
}
}
