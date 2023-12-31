{{-- {{dd(key($lineas_cotizacion))}}; --}}
{{-- {{dd($descripciones)}}; --}}
{{-- {{dd($subtotales)}}; --}}
<div class="form-group row">
    <label for="numero" class="col-lg-3 col-form-label">Número de cotización</label>
    <div class="col-lg-8">
        <input type="text" required name="numero" id="numero" class="form-control" value="{{old('numero', $cotizacion->numero ?? '')}}"/>
    </div>
</div>

<div class="form-group row">
    <label for="equipo_id" class="col-lg-3 col-form-label requerido">Equipo</label>
    <div class="col-lg-8">
        <select name="equipo_id" required id="equipo_id" class="selectpicker form-control" data-live-search="true">
            <option value="">Seleccione el equipo</option>
            @foreach($equipos as $equipo)
        <option value="{{$equipo->id}}" {{($equipo->id==old('equipo_id',$cotizacion->equipo->id ?? ''))?'selected':''}}>
                {{$equipo->obra->nombre}} (OE-{{$equipo->oe}})
            </option>
            @endforeach
        </select>

    </div>
</div>

<div class="form-group row">
    <label for="resumen" class="col-lg-3 col-form-label">Resumen</label>
    <div class="col-lg-8">
        <input type="text" required name="resumen" id="resumen" class="form-control" value="{{old('resumen', $cotizacion->resumen ?? '')}}"/>
    </div>
</div>

{{-- <input type="hidden" name="servicio_id" id="servicio_id" class="form-control" value="{{$servicio->id}}" required/> --}}
<div class="form-group row">
    <label for="fecha" class="col-lg-3 col-form-label">Fecha</label>
    <div class="col-lg-8">
        <input type="date" required name="fecha" id="fecha" class="form-control" value="{{old('fecha', $cotizacion->fecha ?? '')}}"/>
    </div>
</div>
<div class="form-group row">
    <label for="dirigido_a" class="col-lg-3 col-form-label">Dirigido a</label>
    <div class="col-lg-8">
        <input type="text" required name="dirigido_a" id="dirigido_a" class="form-control" value="{{old('dirigido_a', $cotizacion->dirigido_a ?? '')}}"/>
    </div>
</div>

<div class="form-group row">
    <label for="observacion" class="col-lg-3 col-form-label">Observación</label>
    <div class="col-lg-8">
        <textarea name="observacion" id="observacion" class="form-control" cols="30" rows="5">{{old('observacion', $cotizacion->observacion ?? '')}}</textarea>
    </div>
</div>



<div class="row mb-3">
    <button type="submit" id="btn-agregar-item" class="btn btn-success">Agregar linea</button>
</div>



<table class= "table table-striped table-hover table-responsive-lg" id="table-form">
    <thead>
        <tr>
            <th>Item</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>

            <th class="width70"></th>
        </tr>
    </thead>
    <tbody id="compraBody">

    </tbody>
    <tfoot id="compraFoot">
    </tfoot>
    <input id="total" type="hidden" name="total">
</table>






