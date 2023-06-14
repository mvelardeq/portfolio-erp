<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Ventas\Cotizacion;
use App\Models\Operaciones\Equipo;
use App\Models\Ventas\Linea_cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        can('listar-cotizaciones');
        $cotizaciones= Cotizacion::with('lineas_cotizacion','equipo')->orderBy('fecha','desc')->orderBy('numero','desc')->get();

        return view('dinamica.ventas.cotizacion.index',compact('cotizaciones'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        can('crear-cotizaciones');
        $cotizaciones= Cotizacion::with('lineas_cotizacion')->orderBy('id')->get();
        $lineas_cotizacion= Linea_cotizacion::orderBy('id')->get();
        $equipos= Equipo::orderBy('id')->get();
        return  view('dinamica.ventas.cotizacion.crear',compact('cotizaciones', 'lineas_cotizacion', 'equipos'));
    }


    // ----------------Automatiza-Crear pdfs masivos--------------------------

    public function automatizar()
    {

        set_time_limit(2000);

        $cotizaciones= Cotizacion::with('lineas_cotizacion')->orderBy('id')->get();

        foreach ($cotizaciones as $cotizacion) {

            // if($cotizacion->id>=891 || $cotizacion->id<=866){
            //     continue;
            // }

            $lineas_cotizacion = Linea_cotizacion::where('cotizacion_id',$cotizacion->id)->orderBy('id')->get();
            $cotizacion_total = Cotizacion::join('linea_cotizacion','cotizacion_id','=','cotizacion.id')->where('cotizacion_id',$cotizacion->id)->select(DB::raw('SUM(cantidad*subtotal) as total'))->first();
            $cotizacion = Cotizacion::with('equipo')->findOrFail($cotizacion->id);

            $pdf = App::make('dompdf.wrapper');
            $content = $pdf->loadView('dinamica.ventas.cotizacion.pdf3', compact('cotizacion','lineas_cotizacion','cotizacion_total'))->output();

            Storage::disk('local')->put('cotizacion.pdf',$pdf->output());
            $ruta_pdf = storage_path('app/cotizacion.pdf');

            $pdfUrl = Cotizacion::setQuotation($ruta_pdf);

            Storage::disk('local')->delete('app/cotizacion.pdf');

            Cotizacion::findOrFail($cotizacion->id)->update([
                'pdf'=>$pdfUrl
            ]);


        }

        return 'Good job!';

    }

    // ----------------Automatiza-Crear pdfs masivos--------------------------


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        can('crear-cotizaciones');
        Cotizacion::create([
            'equipo_id' => $request->equipo_id,
            'numero' => $request->numero,
            'resumen' => $request->resumen,
            'fecha' => $request->fecha,
            'dirigido_a' => $request->dirigido_a,
            'observacion' => $request->observacion,
            ]);

            $idcotizacion= Cotizacion::orderBy('created_at', 'desc')->first()->id;


            for ($i=0; $i < count($request->descripcion); $i++) {
                Linea_cotizacion::create([
                    'cotizacion_id' => $idcotizacion,
                    'descripcion' => $request->descripcion[$i],
                    'cantidad' => $request->cantidad[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);
            }

            $lineas_cotizacion = Linea_cotizacion::where('cotizacion_id',$idcotizacion)->orderBy('id')->get();
            $cotizacion_total = Cotizacion::join('linea_cotizacion','cotizacion_id','=','cotizacion.id')->where('cotizacion_id',$idcotizacion)->select(DB::raw('SUM(cantidad*subtotal) as total'))->first();
            $cotizacion = Cotizacion::with('equipo')->findOrFail($idcotizacion);

            $pdf = App::make('dompdf.wrapper');
            $content = $pdf->loadView('dinamica.ventas.cotizacion.pdf3', compact('cotizacion','lineas_cotizacion','cotizacion_total'))->output();

            Storage::disk('local')->put('cotizacion.pdf',$pdf->output());
            $ruta_pdf = storage_path('app/cotizacion.pdf');

            $pdfUrl = Cotizacion::setQuotation($ruta_pdf);

            Storage::disk('local')->delete('app/cotizacion.pdf');

            Cotizacion::findOrFail($idcotizacion)->update([
                'pdf'=>$pdfUrl
            ]);


        return redirect('ventas/cotizacion')->with('mensaje', 'Cotización creada con éxito');
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
        can('editar-cotizaciones');
        $cotizacion = Cotizacion::findOrFail($id);
        $lineas_cotizacion = Linea_cotizacion::orderBy('id')->where('cotizacion_id', $id)->get();
        $equipos= Equipo::orderBy('id')->get();

        $total_coti = 0;
        foreach ($lineas_cotizacion as $linea_cotizacion) {
            $total_coti += $linea_cotizacion->cantidad*$linea_cotizacion->subtotal;
        }

        return view('dinamica.ventas.cotizacion.editar', compact('lineas_cotizacion','cotizacion', 'equipos', 'total_coti'));
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
        can('editar-cotizaciones');
        Cotizacion::findOrFail($id)->update([
            'equipo_id' => $request->equipo_id,
            'numero' => $request->numero,
            'resumen' => $request->resumen,
            'fecha' => $request->fecha,
            'dirigido_a' => $request->dirigido_a,
            'observacion' => $request->observacion,
        ]);

        $ids_lineas_cotizacion = Linea_cotizacion::orderBy('id')->where('cotizacion_id', $id)->pluck('id')->toArray();

        Linea_cotizacion::where('cotizacion_id',$id)->delete();

        for ($i=0; $i < count($request->descripcion); $i++) {

            Linea_cotizacion::create([
                'cotizacion_id' => $id,
                'descripcion' => $request->descripcion[$i],
                'cantidad' => $request->cantidad[$i],
                'subtotal' => $request->subtotal[$i],
            ]);
        }

        $lineas_cotizacion = Linea_cotizacion::where('cotizacion_id',$id)->orderBy('id')->get();
        $cotizacion_total = Cotizacion::join('linea_cotizacion','cotizacion_id','=','cotizacion.id')->where('cotizacion_id',$id)->select(DB::raw('SUM(cantidad*subtotal) as total'))->first();
        $cotizacion = Cotizacion::with('equipo')->findOrFail($id);

        $pdf = App::make('dompdf.wrapper');
        $content = $pdf->loadView('dinamica.ventas.cotizacion.pdf3', compact('cotizacion','lineas_cotizacion','cotizacion_total'))->output();

        Storage::disk('local')->put('cotizacion.pdf',$pdf->output());
        $ruta_pdf = storage_path('app/cotizacion.pdf');

        $publicId = getPublicIdByUrl($cotizacion->pdf);

        $pdfUrl = Cotizacion::setQuotation($ruta_pdf,$publicId);

        Storage::disk('local')->delete('app/cotizacion.pdf');

        Cotizacion::findOrFail($id)->update([
            'pdf'=>$pdfUrl
        ]);

        return dd($publicId);

        return redirect('ventas/cotizacion')->with('mensaje', 'Cotización actualizada con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $id)
    {
        can('eliminar-cotizaciones');
        if ($request->ajax()) {
            $url = Cotizacion::findOrFail($id)->pdf;
            $publicId = getPublicIdByUrl($url);
            if (Linea_cotizacion::where('cotizacion_id',$id)->delete()) {
                if (Cotizacion::destroy($id)) {
                    cloudinary()->destroy($publicId);
                    return response()->json(['mensaje' => 'ok']);
                }

            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
