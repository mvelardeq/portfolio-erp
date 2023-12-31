<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

// Cloudinary::admin();
// Cloudinary::search();
// Cloudinary::uploadApi();

// use MediaAlly;

Route::get('prueba', function () {
    return view('prueba');
});
Route::post('prueba', function () {
    // $uploadedFileUrl = Cloudinary::uploadFile(request()->file('image')->getRealPath())->getSecurePath('samples/');
    // $result = request()->file('image')->storeOnCloudinary('photos/profilePhoto/');
    // dd($result);
    // $publicId = 'photos/profilePhoto/j7rkrkefl9obcs1dvfxk';
    // cloudinary()->destroy($publicId);
    dd(request()['image']);
})->name('prueba');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*RUTAS PASSWORD RESET*/
Route::post('usuario/configurar/password/confirm', 'Auth\ConfirmPasswordController@confirm')->name('password.confirmp');
Route::get('usuario/configurar/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');


// RUTAS DE LOGIN
Route::get('/', 'InicioController@index')->name('inicio');
Route::get('seguridad/login', 'Seguridad\LoginController@index')->name('login');
Route::post('seguridad/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('seguridad/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::post('ajax-sesion', 'AjaxController@setSession')->name('ajax')->middleware('auth');

// RUTAS ADMIN
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'superadmin']], function () {
    Route::get('', 'AdminController@index');
    /*RUTAS DE USUARIO*/
    Route::get('usuario', 'UsuarioController@index')->name('usuario');
    Route::get('usuario/crear', 'UsuarioController@crear')->name('crear_usuario');
    Route::post('usuario', 'UsuarioController@guardar')->name('guardar_usuario');
    Route::get('usuario/{id}/editar', 'UsuarioController@editar')->name('editar_usuario');
    Route::put('usuario/{id}', 'UsuarioController@actualizar')->name('actualizar_usuario');
    Route::delete('usuario/{id}', 'UsuarioController@eliminar')->name('eliminar_usuario');
    /*RUTAS DE PERMISO*/
    Route::get('permiso', 'PermisoController@index')->name('permiso');
    Route::get('permiso/crear', 'PermisoController@crear')->name('crear_permiso');
    Route::post('permiso', 'PermisoController@guardar')->name('guardar_permiso');
    Route::get('permiso/{id}/editar', 'PermisoController@editar')->name('editar_permiso');
    Route::put('permiso/{id}', 'PermisoController@actualizar')->name('actualizar_permiso');
    Route::delete('permiso/{id}', 'PermisoController@eliminar')->name('eliminar_permiso');
    /*RUTAS DEL MENU*/
    Route::get('menu', 'MenuController@index')->name('menu');
    Route::get('menu/crear', 'MenuController@crear')->name('crear_menu');
    Route::post('menu', 'MenuController@guardar')->name('guardar_menu');
    Route::get('menu/{id}/editar', 'MenuController@editar')->name('editar_menu');
    Route::put('menu/{id}', 'MenuController@actualizar')->name('actualizar_menu');
    Route::get('menu/{id}/eliminar', 'MenuController@eliminar')->name('eliminar_menu');
    Route::post('menu/guardar-orden', 'MenuController@guardarOrden')->name('guardar_orden');
    // RUTAS ROL
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/crear', 'RolController@crear')->name('crear_rol');
    Route::post('rol', 'RolController@guardar')->name('guardar_rol');
    Route::get('rol/{id}/editar', 'RolController@editar')->name('editar_rol');
    Route::put('rol/{id}', 'RolController@actualizar')->name('actualizar_rol');
    Route::delete('rol/{id}', 'RolController@eliminar')->name('eliminar_rol');
    /*RUTAS MENU_ROL*/
    Route::get('menu-rol', 'MenuRolController@index')->name('menu_rol');
    Route::post('menu-rol', 'MenuRolController@guardar')->name('guardar_menu_rol');
    /*RUTAS PERMISO_ROL*/
    Route::get('permiso-rol', 'PermisoRolController@index')->name('permiso_rol');
    Route::post('permiso-rol', 'PermisoRolController@guardar')->name('guardar_permiso_rol');
});


Route::group(['prefix' => 'operaciones', 'namespace' => 'Operaciones', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE OBRA*/
    Route::get('obra', 'ObraController@index')->name('obra');
    Route::get('obra/crear', 'ObraController@crear')->name('crear_obra');
    Route::post('obra', 'ObraController@guardar')->name('guardar_obra');
    Route::get('obra/{id}/editar', 'ObraController@editar')->name('editar_obra');
    Route::put('obra/{id}', 'ObraController@actualizar')->name('actualizar_obra');
    Route::delete('obra/{id}', 'ObraController@eliminar')->name('eliminar_obra');
    // Route::get('trabajador/{id}/perfil', 'TrabajadorPerfilController@index')->name('trabajador_perfil');
    /*RUTAS DE EQUIPO*/
    Route::get('equipo', 'EquipoController@index')->name('equipo');
    Route::get('equipo/crear', 'EquipoController@crear')->name('crear_equipo');
    Route::post('equipo', 'EquipoController@guardar')->name('guardar_equipo');
    Route::get('equipo/{id}/editar', 'EquipoController@editar')->name('editar_equipo');
    Route::put('equipo/{id}', 'EquipoController@actualizar')->name('actualizar_equipo');
    Route::delete('equipo/{id}', 'EquipoController@eliminar')->name('eliminar_equipo');
    Route::post('equipo/subir/{id}', 'EquipoController@subir')->name('subir_equipo');
    // Route::get('trabajador/{id}/perfil', 'TrabajadorPerfilController@index')->name('trabajador_perfil');

    /*RUTAS DE EMPRESA*/
    Route::get('empresa', 'EmpresaController@index')->name('empresa');
    Route::get('empresa/crear', 'EmpresaController@crear')->name('crear_empresa');
    Route::post('empresa', 'EmpresaController@guardar')->name('guardar_empresa');
    Route::get('empresa/{id}/editar', 'EmpresaController@editar')->name('editar_empresa');
    Route::put('empresa/{id}', 'EmpresaController@actualizar')->name('actualizar_empresa');
    Route::delete('empresa/{id}', 'EmpresaController@eliminar')->name('eliminar_empresa');
    // Route::get('trabajador/{id}/perfil', 'TrabajadorPerfilController@index')->name('trabajador_perfil');
    /*RUTAS DE SERVICIO*/
    Route::get('servicio', 'ServicioController@index')->name('servicio');
    Route::get('servicio/crear', 'ServicioController@crear')->name('crear_servicio');
    Route::post('servicio', 'ServicioController@guardar')->name('guardar_servicio');
    Route::get('servicio/{id}/editar', 'ServicioController@editar')->name('editar_servicio');
    Route::put('servicio/{id}', 'ServicioController@actualizar')->name('actualizar_servicio');
    Route::delete('servicio/{id}', 'ServicioController@eliminar')->name('eliminar_servicio');
    /*RUTAS DE OT*/
    Route::get('ot', 'OtController@index')->name('ot');
    Route::get('ot/crear', 'OtController@crear')->name('crear_ot');
    Route::post('ot', 'OtController@guardar')->name('guardar_ot');
    Route::get('ot/{id}/editar', 'OtController@editar')->name('editar_ot');
    Route::put('ot/{id}', 'OtController@actualizar')->name('actualizar_ot');
    // Route::delete('ot/{id}', 'OtController@eliminar')->name('eliminar_ot');
});

Route::group(['prefix' => 'ventas', 'namespace' => 'Ventas', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE COTIZACIÓN*/
    Route::get('cotizacion', 'CotizacionController@index')->name('cotizacion');
    Route::get('cotizacion/crear', 'CotizacionController@crear')->name('crear_cotizacion');
    Route::post('cotizacion', 'CotizacionController@guardar')->name('guardar_cotizacion');

    // --------------------------Automatiza pdf masivos--------------------------------------
    Route::get('cotizacion/automatizar', 'CotizacionController@automatizar');
    // --------------------------Automatiza pdf masivos--------------------------------------


    Route::get('cotizacion/{id}/editar', 'CotizacionController@editar')->name('editar_cotizacion');
    Route::put('cotizacion/{id}', 'CotizacionController@actualizar')->name('actualizar_cotizacion');
    Route::delete('cotizacion/{id}', 'CotizacionController@eliminar')->name('eliminar_cotizacion');
    /*RUTAS DE CONTRATO*/
    Route::get('contrato', 'ContratoController@index')->name('contrato');
    Route::get('contrato/crear', 'ContratoController@crear')->name('crear_contrato');
    Route::post('contrato', 'ContratoController@guardar')->name('guardar_contrato');
    Route::get('contrato/{id}/editar', 'ContratoController@editar')->name('editar_contrato');
    Route::put('contrato/{id}', 'ContratoController@actualizar')->name('actualizar_contrato');
    Route::delete('contrato/{id}', 'ContratoController@eliminar')->name('eliminar_contrato');
    Route::post('contrato/finalizar/{id}', 'ContratoController@finalizar')->name('finalizar_contrato');
    Route::post('contrato/retomar/{id}', 'ContratoController@retomar')->name('retomar_contrato');
    /*RUTAS DE FACTURA*/
    Route::get('factura', 'FacturaController@index')->name('factura');
    Route::get('factura-repor', 'FacturaController@repor')->name('repor-factura');
    Route::get('factura/crear', 'FacturaController@crear')->name('crear_factura');
    Route::post('factura', 'FacturaController@guardar')->name('guardar_factura');
    Route::delete('factura/{id}', 'FacturaController@eliminar')->name('eliminar_factura');
    Route::post('factura/combo/{id}', 'FacturaController@combo')->name('combo_factura');
    Route::post('factura/costofac/{id}', 'FacturaController@costofac')->name('costofac_factura');
    Route::post('factura/procesar/{id}', 'FacturaController@procesar')->name('procesar_factura');
    Route::post('factura/pagar/{id}', 'FacturaController@pagar')->name('pagar_factura');
    Route::post('factura/detraer/{id}', 'FacturaController@detraer')->name('detraer_factura');
    Route::post('factura/anular/{id}', 'FacturaController@anular')->name('anular_factura');
});

Route::group(['prefix' => 'usuario', 'namespace' => 'Usuario', 'middleware' => ['auth']], function () {
    // RUTAS DE PERFIL
    Route::get('perfil', 'PerfilController@index')->name('usuario_perfil');
    /*RUTAS DE OT*/
    Route::get('ot', 'OtController@index')->name('usuario_ot');
    Route::get('ot/crear', 'OtController@crear')->name('crear_usuario_ot');
    Route::post('ot', 'OtController@guardar')->name('guardar_usuario_ot');
    Route::delete('ot/{id}', 'OtController@eliminar')->name('eliminar_usuario_ot');
    Route::post('ot/combo/{contrato_id}', 'OtController@combo')->name('combo_usuario_ot');
    /*RUTAS DE NOTIFICACIONES*/
    Route::get('notificaciones', 'NotificacionesController@index')->middleware(['supervisor'])->name('usuario_notificaciones');
    Route::post('notificaciones/aprobar/{id}', 'NotificacionesController@aprobar_ot')->middleware(['supervisor'])->name('aprobar_notificacion_ot');
    Route::delete('notificaciones/eliminar/{id}', 'NotificacionesController@eliminar')->middleware(['supervisor'])->name('eliminar_ot');
    Route::post('notificaciones/adelanto/{id}', 'NotificacionesController@adelanto')->middleware(['supervisor'])->name('adelanto_ot');
    Route::post('notificaciones/descuento/{id}', 'NotificacionesController@descuento')->middleware(['supervisor'])->name('descuento_ot');
    Route::post('notificaciones/gastoi/{id}', 'NotificacionesController@gastoi')->middleware(['supervisor'])->name('gastoi_ot');
    Route::post('notificaciones/gastom/{id}', 'NotificacionesController@gastom')->middleware(['supervisor'])->name('gastom_ot');
    Route::get('notificaciones/crear-falta', 'NotificacionesController@crear_falta')->middleware(['supervisor'])->name('crear_falta_ot');
    Route::post('notificaciones/guardar-falta/{id}', 'NotificacionesController@guardar_falta')->middleware(['supervisor'])->name('guardar_falta_ot');
    Route::get('notificaciones/mostrarfotos/{id}', 'NotificacionesController@mostrarfotos')->middleware(['supervisor'])->name('mostrarfotos_ot');


    // RUTAS DE CALENDARIO
    Route::get('calendario', 'CalendarioController@index')->name('usuario_calendario');
    Route::get('calendario/mostrar', 'CalendarioController@mostrar')->name('mostrar_calendario');

    Route::get('cuenta-corriente', 'UsuarioCuentaCorrienteController@index')->name('cuenta_corriente_usuario');
    Route::get('cuenta-corriente/{id}/transferencia', 'UsuarioCuentaCorrienteController@transferencia')->name('transferencia_usuario');
    Route::post('cuenta-corriente/{id}/transferencia', 'UsuarioCuentaCorrienteController@guardarTransferencia')->name('guardar_transferencia_usuario');



    //RUTAS DE CONFIGURAR
    Route::get('configurar', 'ConfigurarController@index')->middleware(['password.confirm'])->name('configurar_usuario');
    Route::post('configurar/cambiar-password', 'ConfigurarController@cambiarPassword')->name('cambio_contrasenia_usuario');
    Route::get('configurar/informacion', 'ConfigurarController@informacion')->name('informacion_usuario');
    Route::post('configurar/cambiar-informacion', 'ConfigurarController@cambiarInformacion')->name('cambiar_informacion_usuario');
});


Route::group(['prefix' => 'administracion', 'namespace' => 'Administracion\Logistica', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE CATEGORIA_PRODUCTO*/
    Route::get('logistica/categoria', 'CategoriaProductoController@index')->name('categoria_producto');
    Route::get('logistica/categoria/crear', 'CategoriaProductoController@crear')->name('crear_categoria_producto');
    Route::post('logistica/categoria', 'CategoriaProductoController@guardar')->name('guardar_categoria_producto');
    Route::get('logistica/categoria/{id}/editar', 'CategoriaProductoController@editar')->name('editar_categoria_producto');
    Route::put('logistica/categoria/{id}', 'CategoriaProductoController@actualizar')->name('actualizar_categoria_producto');
    Route::delete('logistica/categoria/{id}', 'CategoriaProductoController@eliminar')->name('eliminar_categoria_producto');
    /*RUTAS DE PRODUCTO*/
    Route::get('logistica/producto', 'ProductoController@index')->name('producto');
    Route::get('logistica/producto/crear', 'ProductoController@crear')->name('crear_producto');
    Route::post('logistica/producto', 'ProductoController@guardar')->name('guardar_producto');
    Route::get('logistica/producto/{id}/editar', 'ProductoController@editar')->name('editar_producto');
    Route::put('logistica/producto/{id}', 'ProductoController@actualizar')->name('actualizar_producto');
    Route::delete('logistica/producto/{id}', 'ProductoController@eliminar')->name('eliminar_producto');
    /*RUTAS DE COMPRA*/
    Route::get('logistica/compra', 'CompraController@index')->name('compra');
    Route::get('logistica/compra/crear', 'CompraController@crear')->name('crear_compra');
    Route::post('logistica/compra', 'CompraController@guardar')->name('guardar_compra');
    Route::get('logistica/compra/{id}/editar', 'CompraController@editar')->name('editar_compra');
    Route::put('logistica/compra/{id}', 'CompraController@actualizar')->name('actualizar_compra');
    Route::delete('logistica/compra/{id}', 'CompraController@eliminar')->name('eliminar_compra');
    /*RUTAS DE PERDIDA*/
    Route::get('logistica/perdida', 'PerdidaExistenciaController@index')->name('perdida');
    Route::get('logistica/perdida/comun/crear', 'PerdidaExistenciaController@crear_comun')->name('crear_perdida_comun');
    Route::get('logistica/perdida/particular/crear', 'PerdidaExistenciaController@crear_particular')->name('crear_perdida_particular');
    Route::post('logistica/perdida/comun', 'PerdidaExistenciaController@guardar_comun')->name('guardar_perdida_comun');
    Route::post('logistica/perdida/particular', 'PerdidaExistenciaController@guardar_particular')->name('guardar_perdida_particular');
    Route::get('logistica/perdida/{id}/editar', 'PerdidaExistenciaController@editar')->name('editar_perdida');
    Route::put('logistica/perdida/{id}', 'PerdidaExistenciaController@actualizar')->name('actualizar_perdida');
    Route::delete('logistica/perdida/{id}', 'PerdidaExistenciaController@eliminar')->name('eliminar_perdida');
    /*RUTAS DE INVENTARIO*/
    Route::get('logistica/inventario', 'InventarioController@index')->name('inventario');
    Route::get('logistica/compra/crear', 'CompraController@crear')->name('crear_compra');
    Route::post('logistica/compra', 'CompraController@guardar')->name('guardar_compra');
    Route::get('logistica/compra/{id}/editar', 'CompraController@editar')->name('editar_compra');
    Route::put('logistica/compra/{id}', 'CompraController@actualizar')->name('actualizar_compra');
    Route::delete('logistica/compra/{id}', 'CompraController@eliminar')->name('eliminar_compra');
});

Route::group(['prefix' => 'administracion', 'namespace' => 'Administracion\RRHH', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE TRABAJADOR*/
    Route::get('rrhh/trabajador', 'TrabajadorController@index')->name('trabajador');
    Route::get('rrhh/trabajador/crear', 'TrabajadorController@crear')->name('crear_trabajador');
    Route::post('rrhh/trabajador', 'TrabajadorController@guardar')->name('guardar_trabajador');
    Route::get('rrhh/trabajador/{id}/editar', 'TrabajadorController@editar')->name('editar_trabajador');
    Route::put('rrhh/trabajador/{id}', 'TrabajadorController@actualizar')->name('actualizar_trabajador');
    Route::delete('rrhh/trabajador/{id}', 'TrabajadorController@eliminar')->name('eliminar_trabajador');
    Route::get('rrhh/trabajador/{id}/perfil', 'TrabajadorPerfilController@index')->name('trabajador_perfil');
    Route::get('rrhh/trabajador/{id}/periodo-trabajador', 'PeriodoTrabajadorController@crear')->name('crear_periodo_trabajador');
    Route::post('rrhh/trabajador/{id}/periodo-trabajador', 'PeriodoTrabajadorController@guardar')->name('guardar_periodo_trabajador');
    Route::get('rrhh/trabajador/{id}/fin-periodo-trabajador', 'PeriodoTrabajadorController@editar')->name('fin_periodo_trabajador');
    Route::post('rrhh/trabajador/{id}/fin-periodo-trabajador', 'PeriodoTrabajadorController@actualizar')->name('actualizar_periodo_trabajador');
    Route::get('rrhh/trabajador/{id}/observacion-trabajador', 'ObservacionTrabajadorController@crear')->name('crear_observacion_trabajador');
    Route::post('rrhh/trabajador/{id}/observacion-trabajador', 'ObservacionTrabajadorController@guardar')->name('guardar_observacion_trabajador');
    Route::get('rrhh/trabajador/{id}/ascenso-trabajador', 'AscensoTrabajadorController@crear')->name('crear_ascenso_trabajador');
    Route::post('rrhh/trabajador/{id}/ascenso-trabajador', 'AscensoTrabajadorController@guardar')->name('guardar_ascenso_trabajador');
    Route::get('rrhh/trabajador/{id}/perfil/calendario', 'TrabajadorPerfilController@mostrarc')->name('mostrar_calendario_trabajador');
    /*RUTAS DE CARGO*/
    Route::get('rrhh/cargo', 'CargoController@index')->name('cargo');
    Route::get('rrhh/cargo/crear', 'CargoController@crear')->name('crear_cargo');
    Route::post('rrhh/cargo', 'CargoController@guardar')->name('guardar_cargo');
    Route::get('rrhh/cargo/{id}/editar', 'CargoController@editar')->name('editar_cargo');
    Route::put('rrhh/cargo/{id}', 'CargoController@actualizar')->name('actualizar_cargo');
    Route::delete('rrhh/cargo/{id}', 'CargoController@eliminar')->name('eliminar_cargo');
    /*RUTAS DE BOLETA DE PAGO*/
    Route::get('rrhh/boleta-pago', 'BoletaPagoController@index')->name('boleta_trabajador');
    Route::get('rrhh/boleta-pago/crear-fin-de-mes/{id}/{periodo}', 'BoletaPagoController@crearFinDeMes')->name('crear_boleta_trabajador');
    Route::post('rrhh/boleta-pago/guardar-fin-de-mes/{id}/{periodo}', 'BoletaPagoController@guardarFinDeMes')->name('guardar_boleta_trabajador');
    Route::get('rrhh/boleta-pago/crear-quincena/{id}/{periodo}', 'BoletaPagoController@crearQuincena')->name('crear_quincena_trabajador');
    Route::post('rrhh/boleta-pago/guardar-quincena/{id}/{periodo}', 'BoletaPagoController@guardarQuincena')->name('guardar_quincena_trabajador');
});

Route::group(['prefix' => 'administracion', 'namespace' => 'Administracion', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE SERVICIO TERCERO*/
    Route::get('servicio-tercero', 'ServicioTerceroController@index')->name('servicio_tercero');
    Route::get('servicio-tercero/crear', 'ServicioTerceroController@crear')->name('crear_servicio_tercero');
    Route::post('servicio-tercero', 'ServicioTerceroController@guardar')->name('guardar_servicio_tercero');
    Route::get('servicio-tercero/{id}/editar', 'ServicioTerceroController@editar')->name('editar_servicio_tercero');
    Route::put('servicio-tercero/{id}', 'ServicioTerceroController@actualizar')->name('actualizar_servicio_tercero');
    Route::delete('servicio-tercero/{id}', 'ServicioTerceroController@eliminar')->name('eliminar_servicio_tercero');
    /*RUTAS DE PAGO SERVICIO*/
    Route::get('pago-servicio', 'PagoServicioController@index')->name('pago_servicio');
    Route::get('pago-servicio/crear', 'PagoServicioController@crear')->name('crear_pago_servicio');
    Route::post('pago-servicio', 'PagoServicioController@guardar')->name('guardar_pago_servicio');
    Route::get('pago-servicio/{id}/editar', 'PagoServicioController@editar')->name('editar_pago_servicio');
    Route::put('pago-servicio/{id}', 'PagoServicioController@actualizar')->name('actualizar_pago_servicio');
    Route::delete('pago-servicio/{id}', 'PagoServicioController@eliminar')->name('eliminar_pago_servicio');
});

Route::group(['prefix' => 'finanzas/contabilidad', 'namespace' => 'Finanzas\Contabilidad', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE CUENTA CONTABLE*/
    Route::get('cuenta-contable', 'CuentaContableController@index')->name('cuenta_contable');
    Route::get('cuenta-contable/crear', 'CuentaContableController@crear')->name('crear_cuenta_contable');
    Route::post('cuenta-contable', 'CuentaContableController@guardar')->name('guardar_cuenta_contable');
    Route::get('cuenta-contable/{id}/editar', 'CuentaContableController@editar')->name('editar_cuenta_contable');
    Route::put('cuenta-contable/{id}', 'CuentaContableController@actualizar')->name('actualizar_cuenta_contable');
    Route::delete('cuenta-contable/{id}', 'CuentaContableController@eliminar')->name('eliminar_cuenta_contable');
});

Route::group(['prefix' => 'finanzas', 'namespace' => 'Finanzas', 'middleware' => ['auth', 'linea-mando']], function () {
    /*RUTAS DE CUENTA CONTABLE*/
    Route::get('estado-movimientos', 'EstadoMovimientosController@index')->name('estado_movimientos');
    Route::get('cuenta-corriente', 'CuentaCorrienteController@index')->name('cuenta_corriente');
    Route::get('cuenta-corriente/{id}/movimiento', 'CuentaCorrienteController@movimiento')->name('movimiento_cuenta_corriente');
});


Route::get('/inicio', 'HomeController@index')->name('home');
Route::get('/inicio/perfil/{id}', 'PerfilPublicoController@index')->middleware('auth')->name('perfil-publico');

Route::group(['prefix' => 'social', 'namespace' => 'Social', 'middleware' => ['auth']], function () {
    /*RUTAS DE POST*/
    Route::post('post', 'PostController@guardar')->name('guardar_post');
    Route::delete('post/{id}', 'PostController@eliminar')->name('eliminar_post');
    /*RUTAS DE LIKES*/
    Route::post('like/guardar/{id}', 'LikesController@guardar')->name('guardar_like');
    Route::post('like/eliminar/{id}', 'LikesController@eliminar')->name('eliminar_like');
    Route::get('like/listar/{id}', 'LikesController@listar')->name('listar_like');
    /*RUTAS DE COMENTARIOS*/
    Route::post('comentario/{id}', 'ComentarioController@guardar')->name('guardar_comentario');
});
