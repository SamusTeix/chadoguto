<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

// site
Route::get('/', function(){
	return view('index');
});

Route::get('/list/{tipo?}', 'ItemController@list');

Route::get('/item/{id}', function($id) {
	$data = [];
	$data['item']     = App\ItemModel::find($id);
	$data['imagens']  = App\ImagemModel::where('tabela', 'item')->where('tabela_id', $id)->get();
	$data['links']    = App\LinkModel::where('tabela', 'item')->where('tabela_id', $id)->get();
	$data['tamanho']  = App\TamanhoModel::where('item_id', $id)->first();

	return view('item', $data);
});

Route::get('/sacolinha', 'DoacaoController@index');
Route::post('/sacolinha/adicionar', 'DoacaoItemController@adicionarItem');
Route::post('/sacolinha/remover', 'DoacaoItemController@removerItem');
Route::post('/sacolinha/editar', 'DoacaoItemController@alteraQuantidade');

Route::post('/sacolinha/salvar', 'DoacaoController@salvar');

// admin
Route::get('/admin', 'AdminController@index')->name('admin');

// login
Route::post('/admin/login', 'AdminController@login');
Route::post('/admin/logout', 'AdminController@logout');

// item
Route::get('/admin/item/index/{id?}', 'ItemAdminController@index'); //->middleware('auth');
Route::get('/admin/item/edit/{id?}' , 'ItemAdminController@edit'); //->middleware('auth');
Route::get('/admin/item/delete/{id}', 'ItemAdminController@delete'); //->middleware('auth');
Route::post('/admin/item/save'      , 'ItemAdminController@save'); //->middleware('auth');

// tipo
Route::get('/admin/tipo/index/{id?}', 'TipoController@index');
Route::get('/admin/tipo/edit/{id?}' , 'TipoController@edit');
Route::get('/admin/tipo/delete/{id}', 'TipoController@delete');
Route::post('/admin/tipo/save'      , 'TipoController@save');

// imagem
Route::post('/admin/imagem/store', 'ImagemController@store');//->middleware('auth');

Route::post('/usuario/verificar', 'UsuarioController@verificar');
Route::post('/usuario/cadastrar', 'UsuarioController@cadastrar');