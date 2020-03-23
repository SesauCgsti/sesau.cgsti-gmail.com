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



Route::get('/covid','CovidController@index');

Route::post('/covid/upload/excel','CovidController@covidExcel');

Route::get('/covid/excel','CovidController@excel');

Route::get('/covid/cep','CovidController@cep');

Route::get('/covid/mapa','CovidController@mapa');

Route::get('/covid/grafico','CovidController@grafico');

Route::get('/covid/grafico/evolucaofiltro','CovidController@graficoevolucaofiltro');
Route::get('/covid/grafico/sexo','CovidController@graficosexo');
Route::get('/covid/grafico/somatorio','CovidController@graficosomatorio');
Route::get('/covid/grafico/diario','CovidController@graficodiario');
Route::get('/covid/grafico/evolucao','CovidController@graficoevolucao');

//Route::get('/covid/grafico/evolucaofiltro','CovidController@graficoevolucaofiltro');


Route::get('/covid/coordenadas','DadosController@coordenadas');
Route::get('/covid/casosDiarios','DadosController@casosDiarios');
Route::get('/covid/casosDiariosSomatorio','DadosController@casosDiariosSomatorio');
Route::get('/covid/casosSexo','DadosController@casosSexo');
Route::get('/covid/casosIdade','DadosController@casosIdade');
Route::get('/covid/casosConfirmado','DadosController@casosConfirmado');
Route::get('/covid/casosConfirmadoDIA','DadosController@casosConfirmadoDIA');

