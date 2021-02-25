@php
use Carbon\Carbon;
@endphp

@extends("theme.$theme.layout")
@section('titulo')
    Perfil Trabajador
@endsection

@section("script")
<script src="{{asset("assets/pages/scripts/admin/trabajador/crear.js")}}" type="text/javascript"></script>
{{-- <script>
    function recargar(){
        document.getElementById("card-trabajador").innerHTML = "@include('dinamica.admin.periodo-trabajador.formperiodotrabajador')";
    }
</script> --}}
@endsection

@section('contenido')

<!-- Main content -->
<section class="content">
    {{-- {{dd($data->periodos->last())}} --}}
    {{-- {{dd($periodo_trabajador->last())}} --}}
    @include('dinamica.includes.mensaje')
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{Storage::disk('s3')->url("photos/profilePhoto/".$data->foto."")}}"
                     alt="User profile picture">
              </div>

            <h3 class="profile-username text-center">{{$data->primer_nombre." ".$data->primer_apellido}}</h3>

              <p class="text-muted text-center">{{$ascensos->last()->cargo->nombre ?? 'Sin Contrato'}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Edad</b> <a class="float-right">{{Carbon::parse($data->fecha_nacimiento)->age}} años</a>
                </li>
                <li class="list-group-item">
                      <b>Sueldo</b> <a class="float-right">
                      @if (isset($data->periodos->last()->fecha_fin))
                             Cesado
                        @elseif (isset($data->periodos->last()->fecha_inicio))
                            {{-- {{$data->periodos->last()->fecha_inicio}} --}}
                            {{$ascensos->last()->sueldo ?? 'Sin Contrato'}}
                        @else
                            Sin contrato
                        @endif
                    </a>
                </li>
                <li class="list-group-item">
                    <b>Fecha Inicio</b> <a class="float-right">
                        @if (isset($data->periodos->last()->fecha_fin))
                             Cesado
                        @elseif (isset($data->periodos->last()->fecha_inicio))
                            {{-- {{$data->periodos->last()->fecha_inicio}} --}}
                            {{Carbon::parse($data->periodos->last()->fecha_inicio)->isoFormat('DD MMMM YYYY')}}
                        @else
                            Sin contrato
                        @endif
                    </a>
                </li>
              </ul>

                @if (isset($data->periodos->last()->fecha_fin))
                    <a href="{{route('crear_periodo_trabajador', ['id' => $data->id])}}" class="btn btn-primary btn-block"><b>Contratar</b></a>

                    @elseif (isset($data->periodos->last()->fecha_inicio))
                    <a href="{{route('crear_ascenso_trabajador', ['id' => $data->id])}}" class="btn btn-primary btn-block"><b>Ascender</b></a>

                    @else
                    <a href="{{route('crear_periodo_trabajador', ['id' => $data->id])}}" class="btn btn-primary btn-block"><b>Contratar</b></a>

                @endif
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Acerca de mi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <strong><i class="fas fa-mobile-alt mr-1"></i> Celular</strong>

                <p class="text-muted">{{$data->celular}}</p>

                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> Correo</strong>

                <p class="text-muted">
                    {{$data->correo}}
                </p>

                <hr>

                <strong><i class="fas fa-id-card mr-1"></i> Dni</strong>

                <p class="text-muted">
                    {{$data->dni}}
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Ubicación</strong>

                <p class="text-muted">{{$data->direccion}}</p>

                <hr>

                <strong><i class="fas fa-birthday-cake mr-1"></i> Cumpleaños</strong>

                <p class="text-muted">
                    {{Carbon::parse($data->fecha_nacimiento)->isoFormat('Do MMMM') }}
                </p>

                <hr>

                <strong><i class="fas fa-shoe-prints mr-1"></i> Botas</strong>

                <p class="text-muted">
                    {{$data->botas}}
                </p>
                <hr>

                <strong><i class="fas fa-tshirt mr-1"></i> Overol</strong>

                <p class="text-muted">
                    {{$data->overol}}
                </p>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-success card-outline" id="card-trabajador">
            @yield('contenido2')
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection
