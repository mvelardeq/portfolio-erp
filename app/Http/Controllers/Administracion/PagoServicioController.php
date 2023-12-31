<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionPagoServicio;
use App\Models\Administracion\Pago_servicio;
use App\Models\Administracion\Servicio_tercero;
use App\Models\Finanzas\Contabilidad\Asiento_contable;
use App\Models\Finanzas\Contabilidad\Asiento_cuenta;
use App\Models\Finanzas\Contabilidad\Cuenta_contable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        can('listar-pagos-serviciost');
        $pagos_servicio = Pago_servicio::with('servicio_tercero')->orderBy('id')->get();
        return view('dinamica.administracion.pago-servicio.index', compact('pagos_servicio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        can('crear-pagos-serviciost');
        $servicios_tercero = Servicio_tercero::orderBy('id')->get();
        $cuentas_contable = Cuenta_contable::where('responsable_id',Auth::user()->id)->orderBy('id')->get();
        return view('dinamica.administracion.pago-servicio.crear', compact('servicios_tercero','cuentas_contable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionPagoServicio $request)
    {
        can('crear-pagos-serviciost');
        Pago_servicio::create($request->all());
        $idpago_servicio = Pago_servicio::orderBy('created_at','desc')->first()->id;
        $servicio_tercero = Servicio_tercero::findOrFail($request->servicio_tercero_id);
        Asiento_contable::create([
            'fecha'=>$request->fecha_pago,
            'glosa'=>'Pago por servicio de '.$servicio_tercero->nombre.' dirigido hacia '.$servicio_tercero->dirigido_a,
            'asientoable_id'=>$idpago_servicio,
            'asientoable_type'=>'App\Models\Administracion\Pago_servicio',
        ]);

        if (isset($request->ruc_proveedor)) {

            // Asientos de pago de servicio
            $idasientocontable = Asiento_contable::orderBy('created_at','desc')->first()->id;
            $idcuentaigv = Cuenta_contable::where('codigo','1673')->value('id');

            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$request->cuenta_contable_id,
                'haber'=>$request->pago,
            ]);
            $idcuentaservicio = Cuenta_contable::where('codigo',$servicio_tercero->cuenta)->value('id');

            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentaservicio,
                'debe'=>($request->pago)/1.18,
            ]);

            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentaigv,
                'debe'=>($request->pago)*0.18/1.18,
            ]);

            // Asientos de destino
            $area_gasto = Servicio_tercero::findOrFail($request->servicio_tercero_id)->tipo_gasto;
            switch ($area_gasto) {
                case 'Administrativo':
                    $area_gasto='94';
                    break;

                case 'Producción':
                    $area_gasto='92';
                    break;

                case 'Ventas':
                    $area_gasto='95';
                    break;

                default:
                    $area_gasto='';
                    break;
            }
            $idcuentadestinodebe = Cuenta_contable::where('codigo',$area_gasto)->value('id');
            $idcuentadestinohaber = Cuenta_contable::where('codigo','79')->value('id');
            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentadestinodebe,
                'debe'=>($request->pago)/1.18,
            ]);
            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentadestinohaber,
                'haber'=>($request->pago)/1.18,
            ]);
            $saldo1 = Cuenta_contable::findOrFail($request->cuenta_contable_id)->saldo;
            Cuenta_contable::findOrFail($request->cuenta_contable_id)->update(['saldo'=>($saldo1-$request->pago)]);
            $saldo2 = Cuenta_contable::findOrFail($idcuentaservicio)->saldo;
            Cuenta_contable::findOrFail($idcuentaservicio)->update(['saldo'=>($saldo2+($request->pago)/1.18)]);
            $saldoigv = Cuenta_contable::findOrFail($idcuentaigv)->saldo;
            Cuenta_contable::findOrFail($idcuentaigv)->update(['saldo'=>($saldoigv+($request->pago)*0.18/1.18)]);
            $saldo3 = Cuenta_contable::findOrFail($idcuentadestinodebe)->saldo;
            Cuenta_contable::findOrFail($idcuentadestinodebe)->update(['saldo'=>($saldo3+($request->pago)/1.18)]);
            $saldo4 = Cuenta_contable::findOrFail($idcuentadestinohaber)->saldo;
            Cuenta_contable::findOrFail($idcuentadestinohaber)->update(['saldo'=>($saldo4+($request->pago)/1.18)]);

        }else{
                // Asientos de pago de servicio
            $idasientocontable = Asiento_contable::orderBy('created_at','desc')->first()->id;
            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$request->cuenta_contable_id,
                'haber'=>$request->pago,
            ]);
            $idcuentaservicio = Cuenta_contable::where('codigo',$servicio_tercero->cuenta)->value('id');

            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentaservicio,
                'debe'=>$request->pago,
            ]);

            // Asientos de destino
            $area_gasto = Servicio_tercero::findOrFail($request->servicio_tercero_id)->tipo_gasto;
            switch ($area_gasto) {
                case 'Administrativo':
                    $area_gasto='94';
                    break;

                case 'Producción':
                    $area_gasto='92';
                    break;

                case 'Ventas':
                    $area_gasto='95';
                    break;

                default:
                    $area_gasto='';
                    break;
            }
            $idcuentadestinodebe = Cuenta_contable::where('codigo',$area_gasto)->value('id');
            $idcuentadestinohaber = Cuenta_contable::where('codigo','79')->value('id');
            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentadestinodebe,
                'debe'=>$request->pago,
            ]);
            Asiento_cuenta::create([
                'asiento_contable_id'=>$idasientocontable,
                'cuenta_contable_id'=>$idcuentadestinohaber,
                'haber'=>$request->pago,
            ]);
            $saldo1 = Cuenta_contable::findOrFail($request->cuenta_contable_id)->saldo;
            Cuenta_contable::findOrFail($request->cuenta_contable_id)->update(['saldo'=>($saldo1-$request->pago)]);
            $saldo2 = Cuenta_contable::findOrFail($idcuentaservicio)->saldo;
            Cuenta_contable::findOrFail($idcuentaservicio)->update(['saldo'=>($saldo2+$request->pago)]);
            $saldo3 = Cuenta_contable::findOrFail($idcuentadestinodebe)->saldo;
            Cuenta_contable::findOrFail($idcuentadestinodebe)->update(['saldo'=>($saldo3+$request->pago)]);
            $saldo4 = Cuenta_contable::findOrFail($idcuentadestinohaber)->saldo;
            Cuenta_contable::findOrFail($idcuentadestinohaber)->update(['saldo'=>($saldo4+$request->pago)]);
        }

        return redirect('administracion/pago-servicio')->with('mensaje','Pago creado con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        can('editar-pagos-serviciost');
        $servicios_tercero = Servicio_tercero::orderBy('id')->get();
        $pago_servicio = Pago_servicio::findOrFail($id);
        return view('dinamica.administracion.pago-servicio.editar',compact('pago_servicio','servicios_tercero'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionPagoServicio $request, $id)
    {
        can('editar-pagos-serviciost');
        Pago_servicio::findOrFail($id)->update($request->all());
        return redirect('administracion/pago-servicio')->with('mensaje','Pago actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Eliminar(Request $request, $id)
    {
        can('eliminar-pagos-serviciost');
        if ($request->ajax()) {
            if (Pago_servicio::destroy($id)) {
                return response()->json(['mensaje'=>'ok']);
            }else {
                return response()->json(['mensaje'=>'ng']);
            }
        }else {
            abort(404);
        }
    }
}
