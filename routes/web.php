<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'inicio')->name('inicio');
Route::view('/nosotros', 'informacion.nosotros')->name('nosotros');
Route::view('/como-funciona', 'informacion.como-funciona')->name('como-funciona');
Route::view('/contacto', 'informacion.contacto')->name('contacto');
Route::get('/ofertas', [ReservaController::class, 'listarOfertas'])->name('ofertas.listar');

Route::middleware('auth')->group(function () {
    Route::get('/cuenta', [CuentaController::class, 'mostrar'])->name('dashboard');

    Route::get('/reservas/crear', [ReservaController::class, 'mostrarFormularioReserva'])->name('reservas.crear');
    Route::post('/reservas', [ReservaController::class, 'guardarReserva'])->name('reservas.guardar');
    Route::get('/reservas/{reserva}/pago', [ReservaController::class, 'mostrarPago'])->name('reservas.pago');
    Route::post('/reservas/{reserva}/pago', [ReservaController::class, 'confirmarPago'])->name('reservas.confirmar-pago');
    Route::get('/reservas/{reserva}', [ReservaController::class, 'mostrarReserva'])->name('reservas.ver');
    Route::post('/reservas/{reserva}/recepcion', [ReservaController::class, 'confirmarRecepcion'])->name('reservas.confirmar-recepcion');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'administrador'])->prefix('administracion')->name('administracion.')->group(function () {
    Route::view('/', 'administracion.panel')->name('inicio');

    Route::get('/categorias', [CategoriaController::class, 'listar'])->name('categorias.listar');
    Route::get('/categorias/crear', [CategoriaController::class, 'mostrarFormularioNuevo'])->name('categorias.crear');
    Route::post('/categorias', [CategoriaController::class, 'guardar'])->name('categorias.guardar');
    Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'mostrarFormularioEditar'])->name('categorias.editar');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'actualizar'])->name('categorias.actualizar');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'desactivar'])->name('categorias.desactivar');

    Route::get('/establecimientos', [EstablecimientoController::class, 'listar'])->name('establecimientos.listar');
    Route::get('/establecimientos/crear', [EstablecimientoController::class, 'mostrarFormularioNuevo'])->name('establecimientos.crear');
    Route::post('/establecimientos', [EstablecimientoController::class, 'guardar'])->name('establecimientos.guardar');
    Route::get('/establecimientos/{establecimiento}/editar', [EstablecimientoController::class, 'mostrarFormularioEditar'])->name('establecimientos.editar');
    Route::put('/establecimientos/{establecimiento}', [EstablecimientoController::class, 'actualizar'])->name('establecimientos.actualizar');
    Route::delete('/establecimientos/{establecimiento}', [EstablecimientoController::class, 'desactivar'])->name('establecimientos.desactivar');

    Route::get('/metodos-pago', [MetodoPagoController::class, 'listar'])->name('metodos-pago.listar');
    Route::get('/metodos-pago/crear', [MetodoPagoController::class, 'mostrarFormularioNuevo'])->name('metodos-pago.crear');
    Route::post('/metodos-pago', [MetodoPagoController::class, 'guardar'])->name('metodos-pago.guardar');
    Route::get('/metodos-pago/{metodoPago}/editar', [MetodoPagoController::class, 'mostrarFormularioEditar'])->name('metodos-pago.editar');
    Route::put('/metodos-pago/{metodoPago}', [MetodoPagoController::class, 'actualizar'])->name('metodos-pago.actualizar');
    Route::delete('/metodos-pago/{metodoPago}', [MetodoPagoController::class, 'desactivar'])->name('metodos-pago.desactivar');

    Route::get('/ofertas', [OfertaController::class, 'listar'])->name('ofertas.listar');
    Route::get('/ofertas/crear', [OfertaController::class, 'mostrarFormularioNuevo'])->name('ofertas.crear');
    Route::post('/ofertas', [OfertaController::class, 'guardar'])->name('ofertas.guardar');
    Route::get('/ofertas/{oferta}/editar', [OfertaController::class, 'mostrarFormularioEditar'])->name('ofertas.editar');
    Route::put('/ofertas/{oferta}', [OfertaController::class, 'actualizar'])->name('ofertas.actualizar');
    Route::delete('/ofertas/{oferta}', [OfertaController::class, 'desactivar'])->name('ofertas.desactivar');
});

require __DIR__.'/auth.php';
