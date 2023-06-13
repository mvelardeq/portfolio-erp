@extends("theme.$theme.layout")
@section('titulo')
    Cotizaciones
@endsection

@section("styles")
<link href="{{asset("assets/js/bootstrap-fileinput/css/fileinput.min.css")}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endsection

@section("scriptsPlugins")
<script src="{{asset("assets/js/maxLength-master/maxLength.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/bootstrap-fileinput/js/fileinput.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/bootstrap-fileinput/js/fileinput.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/bootstrap-fileinput/js/locales/es.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/bootstrap-fileinput/themes/fas/theme.min.js")}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

@endsection

@section("script")
<script src="{{asset("assets/pages/scripts/admin/trabajador/crear.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/pages/scripts/ventas/cotizacion/crear.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('dinamica.includes.form-error')
        @include('dinamica.includes.mensaje')
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Editar cotización {{$cotizacion->numero}}</h3>
                <div class="card-tools">
                    <a href="{{route('cotizacion')}}" class="btn btn-block btn-info btn-sm">
                        <i class="fa fa-fw fa-reply-all"></i> Volver al listado
                    </a>
                </div>
            </div>
            <form action="{{route('actualizar_cotizacion', ['id' => $cotizacion->id])}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf @method("put")
                <div class="card-body">
                    @include('dinamica.ventas.cotizacion.form-edit')
                </div>
                <div class="card-footer">
                    @include('dinamica.includes.boton-form-editar')
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Agregar Item cotización--}}
<div class="modal fade" id="modalItemCoti" tabindex="-1" role="dialog" aria-labelledby="modalItemCotiLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalProductocLabel">Agregar Item Cotización</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form-item-coti" id="formitemcoti">
            {{-- @csrf --}}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="descripcion" class="col-lg-3 col-form-label requerido">Descripción</label>
                    <div class="col-lg-8">
                        <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="5"></textarea>
                        <div class="text-info">Caracteres restantes: <span class="text-danger" id="limit"></span></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cantidadModal" class="col-lg-3 col-form-label">Cantidad</label>
                    <div class="col-lg-8">
                        <input type="number" step="0.01" name="cantidadModal" id="cantidadModal" class="form-control"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="precio_sin_igvModal" class="col-lg-3 col-form-label">Precio unit.</label>
                    <div class="col-lg-8">
                        <input type="number" step="0.01" name="precio_sin_igvModal" id="precio_sin_igvModal" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="guardarItemCoti" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>


{{-- Modal Editar Item cotización--}}
<div class="modal fade" id="modalEditItemCoti" tabindex="-1" role="dialog" aria-labelledby="modalEditItemCotiLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalProductocLabel">Editar Item Cotización</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form-edit-item-coti" id="formedititemcoti">
            {{-- @csrf --}}
            <div class="modal-body">
                <input type="hidden" step="0.01" name="item-edit" id="item-edit" class="form-control"/>

                <div class="form-group row">
                    <label for="descripcion-edit" class="col-lg-3 col-form-label requerido">Descripción</label>
                    <div class="col-lg-8">
                        <textarea name="descripcion-edit" id="descripcion-edit" class="form-control" cols="30" rows="5"></textarea>
                        <div class="text-info">Caracteres restantes: <span class="text-danger" id="limit-edit"></span></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cantidadModal-edit" class="col-lg-3 col-form-label">Cantidad</label>
                    <div class="col-lg-8">
                        <input type="number" step="0.01" name="cantidadModal-edit" id="cantidadModal-edit" class="form-control"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="precio_sin_igvModal-edit" class="col-lg-3 col-form-label">Precio unit.</label>
                    <div class="col-lg-8">
                        <input type="number" step="0.01" name="precio_sin_igvModal-edit" id="precio_sin_igvModal-edit" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="actualizarItemCoti" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection
