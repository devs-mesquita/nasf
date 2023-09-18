<?php

use Illuminate\Support\Facades\Route;

Route::get('/',            "AuthController@login")->name('login');
Route::get ("/login", 		"AuthController@login")->name('login');
Route::post('/login', 		"AuthController@entrar");
Route::get ('/logout', 		'AuthController@logout')->name('logout');


Route::group(['middleware' => ['auth']], function () {

    Route::get ('/', 							'HomeController@index')->name('home');
    Route::get ('/alterasenha',					'UserController@AlteraSenha');
	Route::post('/salvasenha',   				'UserController@SalvarSenha');

    //========================================================================================
	// 										USER
	//========================================================================================
    Route::get('user/perm/{id}',					'UserController@perm');   
	Route::put('user/perm',							'UserController@permSave');



    Route::get('solicitacao/send/{id}', 'SolicitacaoController@send')->name('send');
    Route::get('solicitacao/solcreate/{id}',     'SolicitacaoController@solcreate')->name('solcreate');
    Route::put('solicitacao/enviaresposta/{id}', 'SolicitacaoController@enviaresposta');

    Route::get('pdf/{id}',                       'SolicitacaoController@pdf')->name('pdf');
    // API PEC
    Route::get('/api/equipes', 'SolicitacaoController@getEquipes');
    Route::get('/api/acss', 'SolicitacaoController@getAcss');

    Route::resource('solicitacao',              'SolicitacaoController');
    Route::resource('categoria',                'CategoriaController');
    Route::resource('user',                     'UserController');
});