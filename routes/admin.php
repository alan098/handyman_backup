<?php

use App\Http\Controllers\AdelantosController;
use App\Http\Controllers\Admin\Cruds\ArticuloCategoriaController;
use App\Http\Controllers\Admin\Cruds\ArticuloController;
use App\Http\Controllers\Admin\Cruds\ComboController;
use App\Http\Controllers\Admin\Cruds\DepositoController;
use App\Http\Controllers\Admin\Cruds\EntidadController;
use App\Http\Controllers\Admin\Cruds\PersonaController;
use App\Http\Controllers\Admin\Cruds\PromosController;
use App\Http\Controllers\Admin\Cruds\SucursalController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\Cruds\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Cruds\ServicioCategoriaController;
use App\Http\Controllers\Admin\Cruds\ServicioController;
use App\Http\Controllers\BancosController;
use App\Http\Controllers\CalendarColaboradoresController;
use App\Http\Controllers\ComicionesController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ComunesController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\CuentasController;
use App\Http\Controllers\CuentasTwoController;
use App\Http\Controllers\DescuentosController;
use App\Http\Controllers\DevolucionesController;
use App\Http\Controllers\DiasLibresController;
use App\Http\Controllers\ExistenciasController;
use App\Http\Controllers\facturasContoller;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\GiftcardController;
use App\Http\Controllers\InsumosController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\OrdenInsumosController;
use App\Http\Controllers\PagoComisionesController;
use App\Http\Controllers\PagosConController;
use App\Http\Controllers\PreferenciasController;
use App\Http\Controllers\RecordatoriosController;
use App\Http\Controllers\ReporteClientesController;
use App\Http\Controllers\ReporteImpresiones;
use App\Http\Controllers\ReporteIngresosController;
use App\Http\Controllers\ReporteVentaController;
use App\Http\Controllers\ReservasController as ControllersReservasController;
use App\Http\Controllers\ReservasListController;
use App\Http\Controllers\TimbradoController;
use App\Http\Controllers\TransferenciasController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\VentasNuevasController;
use App\Http\Livewire\Admin\ShowEventos;
use App\Http\Livewire\Admin\ShowReservas;
use Illuminate\Support\Facades\Route;

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

Route::get('', [HomeController::class, 'index'])->name('home'); // HomeAdmin /admin


// Route::get('calendar', [EventoController::class, 'index'])->name('calendar.index');
// Route::get('calendar/mostrar', [EventoController::class, 'show'])->name('calendar.show');
// Route::get('calendar/editar/{id}', [EventoController::class, 'edit'])->name('calendar.edit');
// Route::get('calendar/borrar/{id}', [EventoController::class, 'destroy'])->name('calendar.destroy');
// Route::post('calendar/agregar', [EventoController::class, 'store'])->name('calendar.store');
// Route::post('calendar/actualizar/', [EventoController::class, 'update'])->name('calendar.update');

Route::get('/navbar/change/perfil', [ConfiguracionesController::class, 'cambiarContraseña'])->name('admin.configuracion.perfil');
Route::get('/navbar/change/{ent}/{suc}/{dep}', [ConfiguracionesController::class, 'cambiarSucursal'])->name('admin.configuracion.sucursal');
Route::get('/navbar/optener/sucursal', [ConfiguracionesController::class, 'optenerSucursal'])->name('admin.configuracion.data');
Route::post('navbar/usuario/entidad/', [ConfiguracionesController::class, 'guardarEntidad'])->name('admin.configuracion.entidad');
Route::post('navbar/usuario/pass/', [ConfiguracionesController::class, 'guardarContraseña'])->name('admin.configuracion.pass');

Route::resource('calendar', EventoController::class)->except('show')->names('admin.calendar');
Route::get('calendar/eventos', [EventoController::class, 'eventos'])->name('admin.calendar.eventos');


// Route::resource('reservas', ReservasController::class)->only(['index', 'update', 'store'])->names('admin.reservas');
// Route::get('reservas', ShowReservas::class)->name('admin.reservas.index'); //si quisiera llamar solo al componente como una ruta



Route::resource('users', UserController::class)->only(['index', 'edit', 'store'])->names('admin.users');
Route::get('users/datatable', [UserController::class, 'datatable'])->name('admin.users.datatable');
Route::post('users/update/', [UserController::class, 'update'])->name('admin.users.update');
Route::post('users/destroy/', [UserController::class, 'destroy'])->name('admin.users.destroy');
Route::get('users/roles/{user}', [UserController::class, 'showRoles'])->name('admin.users.showroles');
Route::put('users/syncroles/{user}', [UserController::class, 'syncRoles'])->name('admin.users.syncroles');

Route::resource('roles', RoleController::class)->names('admin.roles');
Route::resource('perfiles', RoleController::class)->except('show')->names('admin.perfiles');

Route::resource('entidades', EntidadController::class)->only(['index', 'edit', 'store'])->names('admin.entidades');
Route::get('entidades/datatable', [EntidadController::class, 'datatable'])->name('admin.entidades.datatable');
Route::post('entidades/update/', [EntidadController::class, 'update'])->name('admin.entidades.update');
Route::post('entidades/destroy/', [EntidadController::class, 'destroy'])->name('admin.entidades.destroy');

Route::resource('sucursales', SucursalController::class)->only(['index', 'edit', 'store'])->names('admin.sucursales');
Route::get('sucursales/datatable', [SucursalController::class, 'datatable'])->name('admin.sucursales.datatable');
Route::post('sucursales/update/', [SucursalController::class, 'update'])->name('admin.sucursales.update');
Route::post('sucursales/destroy/', [SucursalController::class, 'destroy'])->name('admin.sucursales.destroy');


Route::resource('depositos', DepositoController::class)->only(['index', 'edit', 'store'])->names('admin.depositos');
Route::get('depositos/datatable', [DepositoController::class, 'datatable'])->name('admin.depositos.datatable');
Route::post('depositos/update/', [DepositoController::class, 'update'])->name('admin.depositos.update');
Route::post('depositos/destroy/', [DepositoController::class, 'destroy'])->name('admin.depositos.destroy');

Route::resource('personas', PersonaController::class)->only(['index', 'edit', 'store'])->names('admin.personas');
Route::get('personas/datatable', [PersonaController::class, 'datatable'])->name('admin.personas.datatable');
Route::post('personas/update/', [PersonaController::class, 'update'])->name('admin.personas.update');
Route::post('personas/destroy/', [PersonaController::class, 'destroy'])->name('admin.personas.destroy');
Route::post('personas/uporcre/', [PersonaController::class, 'updateOrCreation'])->name('admin.personas.uporcre');

Route::resource('categorias_productos', ArticuloCategoriaController::class)->only(['index', 'edit', 'store'])->names('admin.categorias_productos');
Route::get('categorias_productos/datatable', [ArticuloCategoriaController::class, 'datatable'])->name('admin.categorias_productos.datatable');
Route::post('categorias_productos/update/', [ArticuloCategoriaController::class, 'update'])->name('admin.categorias_productos.update');
Route::post('categorias_productos/destroy/', [ArticuloCategoriaController::class, 'destroy'])->name('admin.categorias_productos.destroy');

Route::resource('categorias_servicios', ServicioCategoriaController::class)->only(['index', 'edit', 'store'])->names('admin.categorias_servicios');
Route::get('categorias_servicios/datatable', [ServicioCategoriaController::class, 'datatable'])->name('admin.categorias_servicios.datatable');
Route::post('categorias_servicios/update/', [ServicioCategoriaController::class, 'update'])->name('admin.categorias_servicios.update');
Route::post('categorias_servicios/destroy/', [ServicioCategoriaController::class, 'destroy'])->name('admin.categorias_servicios.destroy');

//timbrados
Route::resource('timbrados', TimbradoController::class)->only(['index','store'])->names('admin.timbrados');
Route::get('/timbrados/editar/',[TimbradoController::class, 'editar'])->name('admin.timbrados.editar');
Route::get('/timbrados/getdata/',[TimbradoController::class, 'data'])->name('admin.timbrados.get_data');
Route::post('/timbrado/save/guardar/',[TimbradoController::class, 'guardar_timbrado'])->name('admin.timbrados.save');
Route::get('/timbrados/datatable/',[TimbradoController::class, 'datatable'])->name('admin.timbrados.datatable');
Route::get('/timbrados/sucursales/',[TimbradoController::class, 'puntosVentas'])->name('admin.timbrados.sucursales');

Route::resource('productos', ArticuloController::class)->only(['index', 'edit', 'store'])->names('admin.productos');
Route::get('productos/datatable', [ArticuloController::class, 'datatable'])->name('admin.productos.datatable');
Route::post('productos/update/', [ArticuloController::class, 'update'])->name('admin.productos.update');
Route::post('productos/destroy/', [ArticuloController::class, 'destroy'])->name('admin.productos.destroy');
Route::get('productos/entidades/{articulo}', [ArticuloController::class, 'ArticuloEntidades'])->name('admin.productos.entidades.get');

Route::resource('servicios', ServicioController::class)->only(['index', 'edit', 'store'])->names('admin.servicios');
Route::get('servicios/datatable', [ServicioController::class, 'datatable'])->name('admin.servicios.datatable');
Route::post('servicios/update/', [ServicioController::class, 'update'])->name('admin.servicios.update');
Route::post('servicios/destroy/', [ServicioController::class, 'destroy'])->name('admin.servicios.destroy');
Route::get('servicios/productos/{servicio}', [ServicioController::class, 'productos'])->name('admin.servicios.productos');
Route::post('servicios/producto/destroy/', [ServicioController::class, 'productoDestroy'])->name('admin.servicios.producto.destroy');


Route::resource('combos', ComboController::class)->only(['index', 'edit', 'store'])->names('admin.combos');
Route::get('combos/datatable', [ComboController::class, 'datatable'])->name('admin.combos.datatable');
Route::post('combos/update/', [ComboController::class, 'update'])->name('admin.combos.update');
Route::post('combos/destroy/', [ComboController::class, 'destroy'])->name('admin.combos.destroy');
Route::get('combos/productos/{combo}', [ComboController::class, 'productos'])->name('admin.combos.productos');
Route::post('combos/producto/destroy/', [ComboController::class, 'productoDestroy'])->name('admin.combos.producto.destroy');

Route::resource('promos', PromosController::class)->only(['index', 'edit', 'store'])->names('admin.promos');
Route::get('promos/datatable', [PromosController::class, 'datatable'])->name('admin.promos.datatable');
Route::post('promos/update/', [PromosController::class, 'update'])->name('admin.promos.update');
Route::post('promos/destroy/', [PromosController::class, 'destroy'])->name('admin.promos.destroy');
Route::get('promos/productos/{promo}', [PromosController::class, 'productos'])->name('admin.promos.productos');
Route::get('promos/entidades/{promo}', [PromosController::class, 'PromoEntidades'])->name('admin.promos.entidades');
Route::post('promos/producto/destroy/', [PromosController::class, 'productoDestroy'])->name('admin.promos.producto.destroy');

//creamos calendarioColaboradores

Route::resource('calendario/colaboradores', CalendarColaboradoresController::class)->only(['index', 'edit', 'store','eventos'])->names('admin.calendario.colaboradores');
Route::get('calendario/colaboradores/datos/{id}/{fecha}', [CalendarColaboradoresController::class, 'detallesEventos'])->name('admin.calendario.colaboradores.datos');
Route::post('calendario/colaboradores/data', [CalendarColaboradoresController::class, 'eventos'])->name('admin.calendario.colaboradores.verificar');
Route::post('calendario/colaboradores/destroy/', [CalendarColaboradoresController::class, 'EliminarReserva'])->name('admin.calendario.colaboradores.destroy');
Route::post('calendario/colaboradores/update/', [CalendarColaboradoresController::class, 'update'])->name('admin.calendario.colaboradores.update');

Route::post('calendario/colaboradores/cambio/', [CalendarColaboradoresController::class, 'cambio'])->name('admin.calendario.colaboradores.cambio');


Route::get('fechear', [CalendarColaboradoresController::class, 'Fechear'])->name('admin.fechear');


//creamos seccion de cuentas
Route::resource('cuentas', CuentasController::class)->only(['index', 'edit', 'store'])->names('admin.cuentas');
Route::get('clientes/datatable/detalles', [CuentasController::class, 'cuentasDatatable'])->name('admin.cuenta.cliente.cuentasDatatable');
Route::get('clientes/datatable/resumen', [CuentasController::class, 'cuentasResumen'])->name('admin.cuenta.cliente.cuentasResumen');
Route::get('cuenta_cliente/detalle/{venta}/{cliente}', [CuentasController::class, 'cuentaCliente'])->name('admin.cuenta.cliente.edit');
Route::get('clientes/datatable/edit/detalles/{venta}', [CuentasController::class, 'eventosDetallesResumen'])->name('admin.cuenta.cliente.eventosDetallesResumen');
Route::post('clientes/cuentas/reserva/verificar', [CuentasController::class, 'eventos'])->name('admin.cuenta.reserva.verificar');
Route::post('clientes/cuentas/producto/verificar', [CuentasController::class, 'ProductosSave'])->name('admin.cuenta.producto.verificar');
Route::post('clientes/cuentas/delete', [CuentasController::class, 'delete'])->name('admin.cuenta.delete');
//cuentas historial
Route::get('clientes/data/historial', [CuentasController::class, 'historial'])->name('admin.cuenta.cliente.historial');
//asociar cuenta
Route::get('clientes/data/asociar', [CuentasController::class, 'asociar'])->name('admin.cuenta.cliente.asociar');
Route::post('clientes/asociar/save', [CuentasController::class, 'asociarSave'])->name('admin.cuenta.cliente.asociar.save');
//seecionde prueba
Route::get('clientes/listado/data/', [CuentasController::class, 'data'])->name('admin.listado.data');
//creamos seccion de cuentas
Route::get('vender', [VentasController::class, 'index'])->name('admin.vender.index');
Route::post('vender/store', [VentasController::class, 'store'])->name('admin.vender.store');
Route::post('vender/existencia', [VentasController::class, 'existencia'])->name('admin.vender.existencia');
Route::post('vender/verificar', [VentasController::class, 'disponibilidad'])->name('admin.vender.disponibilidad');
Route::get('vender/horas/libres', [ComunesController::class, 'horasLibres'])->name('admin.vender.libres');
Route::get('vender/edit/{id}', [VentasController::class, 'edit'])->name('admin.vender.edit');
Route::post('vender/update', [VentasController::class, 'update'])->name('admin.vender.update');
Route::post('vender/cerrar', [VentasController::class, 'cerrar'])->name('admin.vender.cerrar');
Route::get('vender/clientes/datos', [VentasController::class, 'datosClientes'])->name('admin.vender.clientes');

//facturas
Route::get('factura/{id}', [facturasContoller::class, 'facturacion'])->name('admin.facturar');
// Route::get('ventas/facturar/{id}', [VentasController::class, 'Clonar'])->name('admin.ventas.facturar');
Route::get('/ventas/consultar/timbrado/{ruc}', [VentasController::class, 'consultarTimbrado'])->name('admin.ventas.timbrado');
Route::post('vender/generar/factura', [VentasController::class, 'facturar'])->name('admin.vender.facturar');
//añadimos gifcart a la anterior de ventas
Route::get('vender/gifcard/edit', [VentasController::class, 'giftcardEdit'])->name('admin.vender.giftcard.edit');
Route::post('giftcard/cerrar/venta', [GiftcardController::class, 'cerrar'])->name('admin.giftcard.cerrar');




//Seccion de Gastos
 //elimino show, update y destroy por que las cre manualmente (sino me asigna put y no anda)
Route::resource('gastos', GastosController::class)->except(['show', 'update', 'destroy'])->names('admin.gastos');
Route::get('gastos/datatable', [GastosController::class, 'datatable'])->name('admin.gastos.datatable');
Route::post('gastos/update/', [GastosController::class, 'update'])->name('admin.gastos.update');
Route::post('gastos/destroy/', [GastosController::class, 'destroy'])->name('admin.gastos.destroy');


//comPras
 Route::resource('compras', ComprasController::class)->except(['show', 'update', 'destroy'])->names('admin.compras');
 Route::get('compras/datatable', [ComprasController::class, 'datatable'])->name('admin.compras.datatable');
 Route::post('compras/update/', [ComprasController::class, 'update'])->name('admin.compras.update');
 Route::post('compras/destroy/', [ComprasController::class, 'destroy'])->name('admin.compras.destroy');

 //reporte comicion

 Route::get('comiciones', [ComicionesController::class, 'index'])->name('admin.comiciones.index');
 Route::get('comiciones/pdf/ver', [ComicionesController::class, 'descargarPdf'])->name('admin.comiciones.pdf');
 Route::post('comiciones/guardar/pdf', [ComicionesController::class, 'guardarContrato'])->name('admin.comisiones.pdf.save');
 Route::get('comiciones/data/', [ComicionesController::class, 'data'])->name('admin.comisiones.data');

 //comisionesServicios
 Route::get('comiciones/edit/{id}', [ComicionesController::class, 'edit'])->name('admin.comiciones.edit');
 Route::get('comiciones/configuracion/', [ComicionesController::class, 'comisionesMantenimiento'])->name('admin.comisiones.config');
 Route::get('comiciones/conf/data/', [ComicionesController::class, 'datatable'])->name('admin.comisiones.datatable');
 Route::post('comiciones/update/', [ComicionesController::class, 'storeUpdate'])->name('admin.comisiones.store');
 Route::post('comiciones/destroy/', [ComicionesController::class, 'productoDestroy'])->name('admin.comisiones.destroy');



 //inventarios

 Route::resource('inventarios', InventariosController::class)->except(['show', 'update', 'destroy'])->names('admin.inventarios');
 Route::get('inventarios/datatable', [InventariosController::class, 'datatable'])->name('admin.compras.datatable');
 Route::get('/inventarios/importacion', [InventariosController::class,'frmImportacion'])->name('admin.inventario.form');
 Route::post('/inventarios/procesar', [InventariosController::class,'procesarArchivo'])->name('admin.inventario.procesar');
 Route::post('/inventarios/confirmar', [InventariosController::class,'confirmar'])->name('admin.inventario.confirmar');
 Route::post('/inventarios/guardar_importacion', [InventariosController::class,'guardarArchivo'])->name('admin.inventario.guardar');
 Route::get('/inventarios/exportacion/{tipo?}', [InventariosController::class,'exportInventarios'])->name('admin.exportacion');
 Route::get('/stock/exportacion', [InventariosController::class,'exportExistencias'])->name('admin.exportacion.existe');
 Route::post('inventarios/destroy/', [InventariosController::class, 'delete'])->name('admin.inventario.delete');



 //existencias
 Route::resource('existencia', ExistenciasController::class)->except(['show', 'update', 'destroy'])->names('admin.existencia');
 Route::get('existencia/datatable', [ExistenciasController::class, 'data'])->name('admin.existencia.datatable');
 Route::post('existencia/update/', [ExistenciasController::class, 'update'])->name('admin.existencia.update');
 Route::post('existencia/destroy/', [ExistenciasController::class, 'destroy'])->name('admin.existencia.destroy');
 Route::get('existencia/detalles', [ExistenciasController::class, 'detalles'])->name('admin.existencia.detalles');
 Route::get('existencia/data/data', [ExistenciasController::class, 'dataDetalles'])->name('admin.existencia.detalles.data');
 Route::get('existencia/ver/{tipo}/{id}', [ExistenciasController::class, 'ver'])->name('admin.existencia.ver');
 Route::get('transferencias/redirec', [ExistenciasController::class, 'redi'])->name('admin.existencia.redirecion'); 


 //reporte de ventas Ahun inconcluso
 Route::get('reportes/ventas', [ReporteVentaController::class, 'index'])->name('admin.reportes.ventas.index');
 Route::get('reportes/ventas/pdf', [ReporteVentaController::class, 'descargarPdf'])->name('admin.reportes.ventas.pdf');
//impresiones
 Route::get('impresion/ventas', [ReporteImpresiones::class, 'index'])->name('admin.impresion.ventas.index');
 Route::get('impresion/ventas/datos', [ReporteImpresiones::class, 'getdatos'])->name('admin.impresion.ventas');
 Route::get('impresion/ventas/timbrado/{id}/{ruc}', [ReporteImpresiones::class, 'consultarTimbrado'])->name('admin.impresion.timbrado');
 Route::post('impresion/generar/factura', [ReporteImpresiones::class, 'facturar'])->name('admin.impresion.facturar');
 //anular

 Route::get('anular/ventas', [DevolucionesController::class, 'index'])->name('admin.anular.ventas.index');
 Route::get('anular/ventas/data', [DevolucionesController::class, 'getdatos'])->name('admin.anular.data');
 Route::get('anular/ventas/save', [DevolucionesController::class, 'anular'])->name('admin.anular.anular');
 //pago Comisiones
 Route::get('pagos/comisiones', [PagoComisionesController::class, 'index'])->name('admin.pagos.comisiones.index');
 Route::get('pagos/comisiones/data', [PagoComisionesController::class, 'proveedorComprobantes'])->name('admin.pagos.comisiones.colaboradores');
 Route::get('pagos/comisiones/data/colaborador', [PagoComisionesController::class, 'octenerDatos'])->name('admin.pagos.comisiones.cola.data');
 Route::post('pagos/comisiones/comprobante', [PagoComisionesController::class, 'create'])->name('admin.pagos.comisiones.nuevo');
 Route::post('pagos/comisiones/comprobante/save', [PagoComisionesController::class, 'store'])->name('admin.pagos.comisiones.store');
 //pagos comisiones por afiliados
 Route::get('pagos/comisiones/afiliados', [PagoComisionesController::class, 'indexAfiliado'])->name('admin.pagos.comisiones.index.afiliado');
 Route::get('pagos/comisiones/data/afiliados', [PagoComisionesController::class, 'afiliadoComprobantes'])->name('admin.pagos.comisiones.colaboradores.afiliado');

 

 //comprobantes
 Route::get('comisiones/comprobantes', [PagoComisionesController::class, 'comprobantes'])->name('admin.pagos.comisiones.comprobante');
 Route::get('comisiones/comprobantes/data', [PagoComisionesController::class, 'datatable'])->name('admin.pagos.comprobante.data');
 Route::get('comisiones/comprobantes/ver', [PagoComisionesController::class, 'descargarPdf'])->name('admin.pagos.comprobante.ver');
 Route::get('comisiones/comprobantes/eliminar', [PagoComisionesController::class, 'eliminarComprobantes'])->name('admin.pagos.comprobante.eliminar');
#descuentos Conceptos
Route::resource('descuentos', DescuentosController::class)->only(['index', 'edit', 'store'])->names('admin.descuentos');
Route::get('descuentos/datatable', [DescuentosController::class, 'datatable'])->name('admin.descuentos.datatable');
Route::post('descuentos/update/', [DescuentosController::class, 'update'])->name('admin.descuentos.update');
Route::post('descuentos/destroy/', [DescuentosController::class, 'destroy'])->name('admin.descuentos.destroy');
//dias Libres                                                                                                          
Route::resource('diaslibres', DiasLibresController::class)->only(['index', 'edit', 'store'])->names('admin.diaslibres');
Route::get('diaslibres/datatable', [DiasLibresController::class, 'datatable'])->name('admin.diaslibres.datatable');
Route::post('diaslibres/update/', [DiasLibresController::class, 'update'])->name('admin.diaslibres.update');
Route::post('diaslibres/destroy/', [DiasLibresController::class, 'destroy'])->name('admin.diaslibres.destroy');
//recordatorios                                                                                                                
Route::resource('recordatorios', RecordatoriosController::class)->only(['index', 'edit', 'store'])->names('admin.recordatorios');
Route::get('recordatorios/datatable', [RecordatoriosController::class, 'datatable'])->name('admin.recordatorios.datatable');
Route::post('recordatorios/update/', [RecordatoriosController::class, 'update'])->name('admin.recordatorios.update');
Route::post('recordatorios/destroy/', [RecordatoriosController::class, 'destroy'])->name('admin.recordatorios.destroy');
Route::get('recordatorios/data', [RecordatoriosController::class, 'data'])->name('admin.recordatorios.data');
Route::post('recordatorios/data/actualizar', [RecordatoriosController::class, 'vistear'])->name('admin.recordatorios.vistear');
//cumple
Route::get('recordatorios/cumple', [RecordatoriosController::class, 'cumple'])->name('admin.recordatorios.cumple');
Route::get('recordatorios/cumple/data', [RecordatoriosController::class, 'cumpleData'])->name('admin.recordatorios.cumple.data');

//giftcard                                                                                                               
Route::resource('giftcard', GiftcardController::class)->only(['index', 'edit', 'store'])->names('admin.giftcard');
Route::get('giftcard/create/form', [GiftcardController::class, 'create'])->name('admin.giftcard.create');
Route::get('giftcard/datatable', [GiftcardController::class, 'datatable'])->name('admin.giftcard.datatable');
Route::post('giftcard/update/', [GiftcardController::class, 'update'])->name('admin.giftcard.update');
Route::post('giftcard/destroy/', [GiftcardController::class, 'destroy'])->name('admin.giftcard.destroy');
// reservas                                                                                 #falta midleware
Route::resource('lista_reserva', ReservasListController::class)->only(['index', 'edit', 'store'])->names('admin.lista_reserva');
Route::get('lista_reserva/get/clientes', [ReservasListController::class, 'clientes'])->name('admin.lista_reserva.clientes');
Route::get('lista_reserva/datatable', [ReservasListController::class, 'datatable'])->name('admin.lista_reserva.datatable');

//clonamos ventas para mejorar cosas
Route::get('ventaaas', [VentasNuevasController::class, 'index'])->name('admin.ventaaas.index');
Route::post('ventaaas/existencia', [VentasNuevasController::class, 'existencia'])->name('admin.ventaaas.existencia');
Route::post('ventaaas/verificar', [VentasNuevasController::class, 'disponibilidad'])->name('admin.ventaaas.disponibilidad');
Route::get('ventaaas/edit/{id}', [VentasNuevasController::class, 'edit'])->name('admin.ventaaas.edit');
Route::post('ventaaas/general', [VentasNuevasController::class, 'storeOrUpdate'])->name('admin.ventaaas.general');
Route::get('ventaaas/clientes/datos', [VentasNuevasController::class, 'datosClientes'])->name('admin.ventaaas.clientes');
Route::get('/ventas/consultar/timbrado/{ruc}', [VentasNuevasController::class, 'consultarTimbrado'])->name('admin.ventas.timbrado');
Route::post('ventaaas/generar/factura', [VentasNuevasController::class, 'facturar'])->name('admin.ventaaas.facturar');
Route::get('ventaaas/factura/contacto', [VentasNuevasController::class, 'facturaContacto'])->name('admin.ventaaas.contacto');
Route::post('ventaaas/anulacion/factura', [VentasNuevasController::class, 'anular'])->name('admin.ventaaas.anular');
//clonamos calendario de colaboradores
Route::resource('calendario/rescar', ControllersReservasController::class)->only(['index', 'edit', 'store','eventos'])->names('admin.rescar');
Route::get('calendario/rescar/datos/{id}/{fecha}', [ControllersReservasController::class, 'detallesEventos'])->name('admin.rescar.datos');
Route::post('calendario/rescar/data', [ControllersReservasController::class, 'eventos'])->name('admin.rescar.verificar');
Route::post('calendario/rescar/destroy/', [ControllersReservasController::class, 'EliminarReserva'])->name('admin.rescar.destroy');
Route::post('calendario/rescar/update/', [ControllersReservasController::class, 'update'])->name('admin.rescar.update');
Route::post('calendario/rescar/cambio/', [ControllersReservasController::class, 'cambio'])->name('admin.rescar.cambio');
Route::get('rescar/fechear', [ControllersReservasController::class, 'Fechear'])->name('admin.fechear.rescar');
Route::get('rescar/datos/reservas', [ControllersReservasController::class, 'octenerReservas'])->name('admin.datos.rescar');
Route::post('calendario/rescar/preferencia/', [ControllersReservasController::class, 'savePreferencia'])->name('admin.rescar.prefe');
//promos y combos
Route::post('calendario/rescar/verificacionpm/', [ControllersReservasController::class, 'verificacion'])->name('admin.rescar.pm');
Route::post('calendario/rescar/storetwo/', [ControllersReservasController::class, 'storeTwo'])->name('admin.rescar.storetwo');
Route::get('rescar/datos/reservas/edit/pm', [ControllersReservasController::class, 'editTwo'])->name('admin.datos.editTwo');
Route::post('calendario/rescar/updatetwo/', [ControllersReservasController::class, 'upadateTwo'])->name('admin.rescar.updatetwo');





//reporte de ingresos ##falta midleware
Route::resource('reporte/ingresos', ReporteIngresosController::class)->except(['edit','show', 'update', 'destroy'])->names('admin.ingresos');
Route::get('ingresos/grupales/datatable', [ReporteIngresosController::class, 'datatableGrupal'])->name('admin.ingresosa.datatable');
Route::get('ingresos/individuales/datatable', [ReporteIngresosController::class, 'datatableIndividual'])->name('admin.ingresosi.datatable');
Route::get('comisiones/agrupados/datatable', [ReporteIngresosController::class, 'datatableComisiones'])->name('admin.ingresos.comision.datatable');
Route::get('comisiones/profecional/datatable', [ReporteIngresosController::class, 'datatableComisionesPro'])->name('admin.profesional.comision.datatable');
Route::get('ingresos/sucursales/datatable', [ReporteIngresosController::class, 'datatableSucursal'])->name('admin.ingresos.sucursal.datatable');
Route::get('ingresos/resumen/data', [ReporteIngresosController::class, 'Resumen'])->name('admin.ingresos.resumen.datatable');
Route::get('ingresos/resumen/datatable', [ReporteIngresosController::class, 'datatableResumen'])->name('admin.resumen.datatable');

Route::get('ingresos/excel/descargar', [ReporteIngresosController::class, 'excelIngresos'])->name('admin.ingresos.excel');

//tranferencias  
Route::get('transferencias/index', [TransferenciasController::class, 'index'])->name('admin.transfer.index'); 
Route::get('transferencias/datatable', [TransferenciasController::class, 'data'])->name('admin.transfer.datatable');
Route::get('transferencias/store', [TransferenciasController::class, 'store'])->name('admin.transfer.store');                                                                                           
Route::post('transferencias/create/', [TransferenciasController::class, 'create'])->name('admin.transfer.create');
Route::get('transferencias/edit', [TransferenciasController::class, 'edit'])->name('admin.transfer.edit');                                                                                           
Route::post('transferencias/update/', [TransferenciasController::class, 'update'])->name('admin.transfer.update');
Route::post('transferencias/close/', [TransferenciasController::class, 'close'])->name('admin.transfer.close');
Route::post('transferencias/destroy/', [TransferenciasController::class, 'destroy'])->name('admin.transfer.destroy');

//ordens de insumos
Route::get('orden/insumos/index', [OrdenInsumosController::class, 'index'])->name('admin.ordinsus.index'); 
Route::get('orden/insumos/datatable', [OrdenInsumosController::class, 'data'])->name('admin.ordinsus.datatable');
Route::get('orden/insumos/store', [OrdenInsumosController::class, 'store'])->name('admin.ordinsus.store');                                                                                           
Route::post('orden/insumos/create/', [OrdenInsumosController::class, 'create'])->name('admin.ordinsus.create');
Route::get('orden/insumos/edit', [OrdenInsumosController::class, 'edit'])->name('admin.ordinsus.edit');                                                                                           
Route::post('orden/insumos/update/', [OrdenInsumosController::class, 'update'])->name('admin.ordinsus.update');
Route::post('orden/insumos/close/', [OrdenInsumosController::class, 'close'])->name('admin.ordinsus.close');
Route::post('orden/insumos/destroy/', [OrdenInsumosController::class, 'destroy'])->name('admin.ordinsus.destroy');
//permisos
Route::post('comunes/permisos/simples', [ComunesController::class, 'permisosSimple'])->name('admin.permisions.simple');
Route::post('comunes/permisos/admin', [ComunesController::class, 'permisosAdmin'])->name('admin.permisions.admin');

//
Route::resource('insumos', InsumosController::class)->only(['index', 'edit', 'store'])->names('admin.insumos');
Route::get('insumos/datatable', [InsumosController::class, 'datatable'])->name('admin.insumos.datatable');
Route::post('insumos/update/', [InsumosController::class, 'update'])->name('admin.insumos.update');
Route::post('insumos/destroy/', [InsumosController::class, 'destroy'])->name('admin.insumos.destroy');
Route::get('insumos/entidades/{articulo}', [InsumosController::class, 'ArticuloEntidades'])->name('admin.insumos.entidades.get');


//adelantos falta agregar al middleware
Route::resource('adelantos', AdelantosController::class)->except(['show', 'update', 'destroy'])->names('admin.adelantos');
Route::get('adelantos/datatable', [AdelantosController::class, 'datatable'])->name('admin.adelantos.datatable');
Route::post('adelantos/update/', [AdelantosController::class, 'update'])->name('admin.adelantos.update');
Route::post('adelantos/destroy/', [AdelantosController::class, 'destroy'])->name('admin.adelantos.destroy');

//reposte de con preferencias
Route::resource('preferencias', PreferenciasController::class)->except(['show', 'update', 'destroy'])->names('admin.preferencias');
Route::get('preferencias/excel', [PreferenciasController::class, 'exportPreferencias'])->name('admin.preferencias.excel');
//parametros de cobro
Route::resource('pagosconceptos', PagosConController::class)->only(['index', 'edit', 'store'])->names('admin.pagosconceptos');
Route::get('pagosconceptos/datatable', [PagosConController::class, 'datatable'])->name('admin.pagosconceptos.datatable');
Route::post('pagosconceptos/update/', [PagosConController::class, 'update'])->name('admin.pagosconceptos.update');
Route::post('pagosconceptos/destroy/', [PagosConController::class, 'destroy'])->name('admin.pagosconceptos.destroy');


//falta middleware
Route::resource('bancos', BancosController::class)->only(['index', 'edit', 'store'])->names('admin.bancos');
Route::get('bancos/datatable', [BancosController::class, 'datatable'])->name('admin.bancos.datatable');
Route::post('bancos/update/', [BancosController::class, 'update'])->name('admin.bancos.update');
Route::post('bancos/destroy/', [BancosController::class, 'destroy'])->name('admin.bancos.destroy');
//falta middleware
Route::resource('cuentas_bancarias', CuentasBancariasController::class)->only(['index', 'edit', 'store'])->names('admin.cuentas_bancarias');
Route::get('cuentas_bancarias/datatable', [CuentasBancariasController::class, 'datatable'])->name('admin.cuentas_bancarias.datatable');
Route::post('cuentas_bancarias/update/', [CuentasBancariasController::class, 'update'])->name('admin.cuentas_bancarias.update');
Route::post('cuentas_bancarias/destroy/', [CuentasBancariasController::class, 'destroy'])->name('admin.cuentas_bancarias.destroy');




































//new cuentas
//creamos seccion de cuentas
Route::resource('new_cuentas', CuentasTwoController::class)->only(['index', 'edit', 'store'])->names('admin.new_cuentas');
Route::get('new_cuentas/datatable/detalles', [CuentasTwoController::class, 'cuentasDatatable'])->name('admin.new_cuentas.cliente.cuentasDatatable');
Route::get('new_cuentas/datatable/resumen', [CuentasTwoController::class, 'cuentasResumen'])->name('admin.new_cuentas.cliente.cuentasResumen');
Route::get('new_cuentas/detalle/{venta}/{cliente}', [CuentasTwoController::class, 'cuentaCliente'])->name('admin.new_cuentas.cliente.edit');
Route::get('new_cuentas/datatable/edit/detalles/{venta}', [CuentasTwoController::class, 'eventosDetallesResumen'])->name('admin.new_cuentas.cliente.eventosDetallesResumen');
Route::post('new_cuentas/cuentas/reserva/verificar', [CuentasTwoController::class, 'eventos'])->name('admin.new_cuentas.reserva.verificar');
Route::post('new_cuentas/cuentas/producto/verificar', [CuentasTwoController::class, 'ProductosSave'])->name('admin.new_cuentas.producto.verificar');
Route::post('new_cuentas/cuentas/delete', [CuentasTwoController::class, 'delete'])->name('admin.new_cuentas.delete');
//cuentas historial
Route::get('new_cuentas/data/historial', [CuentasTwoController::class, 'historial'])->name('admin.new_cuentas.cliente.historial');
//asociar cuenta
Route::get('new_cuentas/data/asociar', [CuentasTwoController::class, 'asociar'])->name('admin.new_cuentas.cliente.asociar');
Route::post('new_cuentas/asociar/save', [CuentasTwoController::class, 'asociarSave'])->name('admin.new_cuentas.cliente.asociar.save');
Route::get('new_cuentas/listado/data/', [CuentasTwoController::class, 'data'])->name('admin.listado.data.new_cuentas');
//obtencion de eventos
Route::get('new_cuentas/listado/datatwo/', [CuentasTwoController::class, 'datatwo'])->name('admin.listado.datatwo.new_cuentas');
Route::get('new_cuentas/listado/generarcuenta/', [CuentasTwoController::class, 'TipoVenta'])->name('admin.listado.datatwo.generar');
//


//repotes especificos
#rankin de clientes  
Route::get('reporte/ranking/clientes', [ReporteClientesController::class, 'RankingClientes'])->name('admin.reporte.ranking.clientes');
Route::get('reporte/ranking/clientes/data', [ReporteClientesController::class, 'RankingClientesData'])->name('admin.reporte.ranking.clientes.data');
//ranking de cancladas y confirmadadas
Route::get('reporte/clientes/canceladas/confirmadas', [ReporteClientesController::class, 'ClientesCC'])->name('admin.reporte.clientes.cc');
Route::get('reporte/clientes/cc/data', [ReporteClientesController::class, 'ClientesCCData'])->name('admin.reporte.clientes.cc.data');
//historial de clientes
Route::get('reporte/historial/clientes', [ReporteClientesController::class, 'HistorialClientes'])->name('admin.reporte.historial.clientes');
Route::get('reporte/historial/clientes/data', [ReporteClientesController::class, 'HistorialClientesData'])->name('admin.reporte.historial.clientes.data');
Route::get('reporte/historial/clientes/data/histori', [ReporteClientesController::class, 'HistorialClientesDataH'])->name('admin.reporte.historial.clientes.data.h'); 
//historial de sin venir
Route::get('reporte/clientes/sin/venir', [ReporteClientesController::class, 'ClientesSinVenir'])->name('admin.reporte.dias.venir.clientes');
Route::get('reporte/clientes/sin/venir/data', [ReporteClientesController::class, 'ClientesSinVenirData'])->name('admin.reporte.dias.venir.clientes.data');
//rankin de profesionales
Route::get('reporte/ranking/profesionales', [ReporteClientesController::class, 'RankingProfesionales'])->name('admin.reporte.rankingprofesionales');
Route::get('reporte/ranking/profesionales/data', [ReporteClientesController::class, 'RankingProfesionalesData'])->name('admin.reporte.rankingprofesionales.data');
//historial profesionales
Route::get('reporte/historial/profesionales', [ReporteClientesController::class, 'HistorialProfesionales'])->name('admin.reporte.historial.profesionales');
Route::get('reporte/historial/profesionales/data', [ReporteClientesController::class, 'HistorialProfesionalesData'])->name('admin.reporte.historial.profesionales.data');
Route::get('reporte/historial/profesionales/data/histori', [ReporteClientesController::class, 'HistorialProfesionalesDataH'])->name('admin.reporte.historial.profesionales.data.h');
#rankin de servicios
Route::get('reporte/ranking/servicios', [ReporteClientesController::class, 'Rankingservicios'])->name('admin.reporte.ranking.servicios');
Route::get('reporte/ranking/servicios/data', [ReporteClientesController::class, 'RankingserviciosData'])->name('admin.reporte.ranking.servicios.data');
//historial de servicios
Route::get('reporte/historial/servicios', [ReporteClientesController::class, 'HistorialServicios'])->name('admin.reporte.historial.servicios');
Route::get('reporte/historial/servicios/data', [ReporteClientesController::class, 'HistorialServiciosData'])->name('admin.reporte.historial.servicios.data');
//rankin de insumos
Route::get('reporte/ranking/insumos', [ReporteClientesController::class, 'RankingInsumos'])->name('admin.reporte.rankin.insumo');
Route::get('reporte/ranking/insumos/data', [ReporteClientesController::class, 'RankingInsumosData'])->name('admin.reporte.rankin.insumo.data');
// historial de insumo
Route::get('reporte/historial/insumos', [ReporteClientesController::class, 'HistorialInsumos'])->name('admin.reporte.historial.insumos');
Route::get('reporte/historial/insumos/data', [ReporteClientesController::class, 'HistorialInsumosData'])->name('admin.reporte.historial.insumos.data');
