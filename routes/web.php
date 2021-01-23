<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('prospectos/listado', function() {return View::make('prospectos.listado');})->name('prospectos.inicio');
Route::get('prospectos/listado',  'ProspectoController@index')->name('prospectos.inicio');
Route::get('prospectos/listado/captura', 'ProspectoController@listadoProspectos')->name('prospectos.listaCaptura');
Route::get('prospectos/listado/evaluar', 'ProspectoController@listadoProspectosEvaluar')->name('prospectos.listaEvaluar');

Route::get('prospectos/listado/ver/{idProspecto}', 'ProspectoController@verProspecto')->name('prospectos.ver');

Route::post('prospectos/listado/crear', 'ProspectoController@crearProspecto')->name('prospectos.crear');
Route::post('prospectos/listado/editar/{idProspecto}', 'ProspectoController@editarProspecto')->name('prospectos.editar');
Route::get('prospectos/listado/borrar/{idProspecto}', 'ProspectoController@borrarProspecto')->name('prospectos.borrar');

Route::get('prospectos/listado/aprobar/{idProspecto}', 'ProspectoController@aprobarProspecto')->name('prospectos.aprobar');
Route::get('prospectos/listado/rechazar/{idProspecto}', 'ProspectoController@rechazarProspecto')->name('prospectos.rechazar');

Route::get('prospectos/listado/descargarDocs/{idProspecto}', 'ProspectoController@descargarDocs')->name('prospectos.descargarDocs');


