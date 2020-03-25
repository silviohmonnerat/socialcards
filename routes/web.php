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

#Route::get('/', function () {
#    return view('index');
#});

#Route::get('login', function () {
#    return view('login');
#});

Route::get('privacidade', function () {
    return view('index');
});

Route::get('sobre', function () {
    return view('sobre', [
        'title' => 'Sobre',
        'content' => 'Social Cards, é uma plataforma aonde os usuários interagem em diversas categorias. Mostrando suas reações e também compartilhando essas informações no Facebook.'
    ]);
});

Route::get('contato', function () {
    return view('contato');
});

Route::get('criar', function () {
    return view('criar');
});

#Route::get('index', function () {
#    return view('index');
#});

#Route::post('profile', 'ProfileController@profile')->name('profile');

#Route::post('login', 'ProfileController@login')->name('post-login');

#Route::post('pwdupdate', 'ProfileController@updatePwd')->name('updatePwd');

Route::post('socialcard', 'ProfileController@socialCard')->name('post_socialcard');

Route::get('/', 'ProfileController@socialCard')->name('socialcard');

#Route::get('dashboard', 'ProfileController@dashboard')->name('dashboard');

#Route::get('perfil', 'ProfileController@perfil')->name('perfil');

#Route::get('plugins', 'PluginsController@plugins')->name('plugin');

#Route::post('pluginativado', 'PluginsController@pluginsAdicionar')->name('adicionar_plugin');

#Route::post('plugindesativado', 'PluginsController@pluginsRetirar')->name('retirar_plugin');

#Route::get('pagamentos', 'PagamentosController@lista')->name('lista_pagamentos');

#Route::post('boleto', 'PagamentosController@gerarBoleto')->name('gerar_boleto');

Route::post('loginsocial', 'ProfileController@loginSocial')->name('login_social');

Route::post('reactsocial', 'ProfileController@reactSocial')->name('react_social');

Route::post('updatesocial', 'ProfileController@updateSocial')->name('update_social');

Route::post('verificacep', 'ProfileController@verificaCep')->name('verifica_cep');

Route::post('verificainfluencia', 'ProfileController@verificaInfluenciador')->name('verifica_influencia');

Route::post('verificareacao', 'ProfileController@verificaReacao')->name('verifica_reacao');

Route::post('salvarimagem', 'ProfileController@salvarImagem')->name('salvar_imagem');

Route::get('listarcategorias', 'CategoriasController@listar')->name('listar_categorias');

Route::post('criarcard', 'CardsController@criar')->name('criar_card');

Route::post('saveimage', 'CardsController@salvarImagem')->name('save_image');


/*
|--------------------------------------------------------------------------
| Cards Routes Saida json
|--------------------------------------------------------------------------
*/


Route::get('/cardslist', 'CardsController@cardsList')->name('cards_list');