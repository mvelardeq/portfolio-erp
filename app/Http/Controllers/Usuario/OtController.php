<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Operaciones\Actividad;
use App\Models\Operaciones\Ot;
use App\Models\Operaciones\Ot_actividad;
use App\Models\Ventas\Contrato;
use Illuminate\Http\Request;

class OtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $ots= Ot::with('contrato')->where('trabajador_id',$id)->orderBy('fecha','Desc')->get();
        return view('dinamica.usuario.ot.index',compact('ots'));
        // $var = array();
        // foreach ($ots as $ot) {
        //     array_push($var, $ot->contrato);
        // }
        // return dd($var);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear($id)
    {
        $contratos= Contrato::with('conceptos_pago','equipo')->where('estado','Abierto')->orderBy('id')->get();
        return view('dinamica.usuario.ot.crear',compact('contratos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request, $id)
    {
        Ot::create([
            'trabajador_id' => $request->trabajador_id,
            'contrato_id' => $request->contrato_id,
            'estado_ot_id' => 1,
            'fecha' => $request->fecha,
            'pedido' => $request->pedido,
            ]);

            $idot = Ot::orderBy('created_at', 'desc')->first()->id;

            Ot_actividad::create([
                'ot_id' => $idot,
                'actividad_id' => $request->actividad1_id,
                'horas' => $request->horas1,
            ]);

            if ($request->actividad2_id){

                Ot_actividad::create([
                    'ot_id' => $idot,
                    'actividad_id' => $request->actividad2_id,
                    'horas' => $request->horas2,
                ]);
            }
            if ($request->actividad3_id){

                Ot_actividad::create([
                    'ot_id' => $idot,
                    'actividad_id' => $request->actividad3_id,
                    'horas' => $request->horas3,
                ]);
            }

        return redirect('usuario/ot/'.$id)->with('mensaje', 'OT creada con éxito');
    }

    public function combo($contrato_id)
    {
        $contrato = Contrato::with('servicio')->findOrFail($contrato_id);
        $actividades = Actividad::where('servicio_id',$contrato->servicio->id)->orderBy('id')->get();

        $listas = '<option value="0">Elige una opción</option>';

        foreach ($actividades as $actividad) {
                $listas .= '<option value="'.$actividad->id.'">'.$actividad->nombre.'</option>';
        }
        echo $listas;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrar($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        //
    }
}
