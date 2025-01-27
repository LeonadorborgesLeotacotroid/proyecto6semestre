<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\VentasController;

Route::get('/', function () {
    return view('modulos.users.Ingresar');
})->name('Ingresar');

Route::get('/Inicio', function () {
    return view('modulos.Inicio');
});

Auth::routes();

//Rutas Sucursales
Route::get('Sucursales', [SucursalesController::class, 'index']);
Route::post('Sucursales', [SucursalesController::class, 'store']);
Route::get('Editar-Sucursal/{id_sucursal}', [SucursalesController::class, 'edit']);
Route::put('Actualizar-Sucursal', [SucursalesController::class, 'update']);
Route::get('Cambiar-Estado-Sucursal/{estado}/{id_sucursal}', [SucursalesController::class, 'CambiarEstado']);

//Rutas Mis-Datos
Route::get('Mis-Datos', function (){
    return view('modulos.users.Mis-Datos');
});
Route::post('Mis-Datos', [UsuariosController::class, 'ActualizarMisDatos']);

//Rutas Usuarios
Route::get('Usuarios', [UsuariosController::class, 'index']);
Route::post('Usuarios', [UsuariosController::class, 'store']);
Route::get('Cambiar-Estado-Usuario/{id_usuario}/{estado}', [UsuariosController::class, 'CambiarEstado']);
Route::get('Editar-Usuario/{id_usuario}', [UsuariosController::class, 'edit']);
Route::post('Verificar-Usuario', [UsuariosController::class, 'verficarUsuario']);
Route::put('Actualizar-Usuario', [UsuariosController::class, 'update']);
Route::get('Eliminar-Usuario/{id_usuario}', [UsuariosController::class, 'destroy']);

//Rutas Categorias
Route::get('Categorias', [CategoriasController::class, 'index']);
Route::post('Categorias', [CategoriasController::class, 'store']);
Route::get('Editar-Categoria/{id_categoria}', [CategoriasController::class, 'edit']);
Route::put('Actualizar-Categoria', [CategoriasController::class, 'update']);
Route::get('Eliminar-Categoria/{id_categoria}', [CategoriasController::class, 'destroy']);

//Rutas Productos
Route::get('Productos', [ProductosController::class, 'index']);
Route::get('Generar-Codigo-Producto/{id_categoria}', [ProductosController::class, 'GenerarCodigo']);
Route::post('Productos', [ProductosController::class, 'AgregarProducto']);
Route::get('Editar-Producto/{id_producto}', [ProductosController::class, 'edit']);
Route::put('Actualizar-Producto', [ProductosController::class, 'update']);
Route::get('Eliminar-Producto/{id_producto}', [ProductosController::class, 'destroy']);

//Rutas Usuarios
Route::get('Clientes', [ClientesController::class, 'index']);
Route::post('Clientes', [ClientesController::class, 'store']);
Route::post('Validar-Documento', [ClientesController::class, 'ValidarDocumento']);
Route::get('Editar-Cliente/{id_cliente}', [ClientesController::class, 'edit']);
Route::put('Actualizar-Cliente', [ClientesController::class, 'update']);
Route::get('Eliminar-Cliente/{id_cliente}', [ClientesController::class, 'destroy']);

//Rutas Administrar ventas
Route::get('Ventas', [VentasController::class, 'index']);
Route::post('Ventas', [VentasController::class, 'store']);
Route::get('Ventas/{id_venta}', [VentasController::class, 'AdministrarVenta']);
Route::post('Agregar-Producto-Venta',[VentasController::class, 'AgregarProductoVenta']);
Route::get('Cargar-Productos-Venta/{id_venta}',[VentasController::class, 'CargarProductosVenta']);
Route::post('Quitar-Producto-Venta',[VentasController::class, 'QuitarProductoVenta']);
Route::post('Finalizar-Venta', [VentasController::class, 'FinalizarVenta']);
Route::get('Eliminar-Venta/{id_venta}',[VentasController::class, 'EliminarVenta']);

//Rutas Reportes
Route::get('Reportes', [VentasController::class, 'Reportes']);
Route::get('ReportesFiltrados/{fechaInicial}/{fechaFinal}/{id_sucursal}', [VentasController::class, 'ReportesFiltrados']);
