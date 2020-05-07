<?php

Route::group(['prefix' => 'ajtarragona/vialer','middleware' => ['vialer-backend','web','auth','language']	], function () {
	
	Route::get('/', 'Ajtarragona\Vialer\Controllers\VialerController@ajaxform')->name('vialer.home');
	Route::get('/parcela/{refcat}', 'Ajtarragona\Vialer\Controllers\VialerController@veureParcela')->name('vialer.parcela');
	Route::post('/search/{type}', 'Ajtarragona\Vialer\Controllers\VialerController@search')->name('vialer.search');
	Route::get('/numerero/{rc}', 'Ajtarragona\Vialer\Controllers\VialerController@numerero')->name('vialer.numerero');
	Route::get('/domicili/{rc}', 'Ajtarragona\Vialer\Controllers\VialerController@domicili')->name('vialer.domicili');
	Route::post('/testform', 'Ajtarragona\Vialer\Controllers\VialerController@testform')->name('vialer.testform');

	// Route::post('/search', 'Ajtarragona\Vialer\Controllers\VialerController@search')->name('vialer.search');
	// Route::get('/via/{codiVia}', 'Ajtarragona\Vialer\Controllers\VialerController@via')->name('vialer.via');
	
});



Route::group(['prefix' => 'ajtarragona/vialer/api'], function () {

	//PAISOS
		Route::get('/paisos/search/{filter}', 'Ajtarragona\Vialer\Controllers\VialerApiController@paisos')->name('api.vialer.paisos.search');
		Route::get('/paisos/{codigoPais}', 'Ajtarragona\Vialer\Controllers\VialerApiController@pais')->name('api.vialer.pais');
		Route::get('/paisos', 'Ajtarragona\Vialer\Controllers\VialerApiController@paisos')->name('api.vialer.paisos');
	
		//PROVINCIES
		Route::get('/provincies/search/{filter}', 'Ajtarragona\Vialer\Controllers\VialerApiController@provincies')->name('api.vialer.provincies.search');
		Route::get('/provincies/{codigoProvincia}', 'Ajtarragona\Vialer\Controllers\VialerApiController@provincia')->name('api.vialer.provincia');
		Route::get('/provincies', 'Ajtarragona\Vialer\Controllers\VialerApiController@provincies')->name('api.vialer.provincies');
		
	
		//MUNICIPIS
		Route::get('/municipis/search/{filter}', 'Ajtarragona\Vialer\Controllers\VialerApiController@municipis')->name('api.vialer.municipis.search');
		Route::get('/municipis', 'Ajtarragona\Vialer\Controllers\VialerApiController@municipis')->name('api.vialer.municipis');
		Route::get('/municipis/{codigoMunicipio}', 'Ajtarragona\Vialer\Controllers\VialerApiController@municipi')->name('api.vialer.municipi');
	
	
		//VIES
		Route::get('/vies/search/{filter}', 'Ajtarragona\Vialer\Controllers\VialerApiController@vies')->name('api.vialer.vies.search');
		
		Route::get('/vies/combo', 'Ajtarragona\Vialer\Controllers\VialerApiController@viesCombo')->name('api.vialer.vies.combo');
	
		Route::get('/vies', 'Ajtarragona\Vialer\Controllers\VialerApiController@vies')->name('api.vialer.vies');
		Route::get('/vies/{codigoIneVia}', 'Ajtarragona\Vialer\Controllers\VialerApiController@via')->name('api.vialer.via');
	
		
		//dades de la via
		Route::get('/codificadors/{codigoIneVia}/{numero?}/{nombrePlanta?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@codificadors')->name('api.vialer.codificadors');
		
		//tipus de via
		Route::get('/tipusvia/combo/{codigoIneVia?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@tipusviaCombo')->name('api.vialer.tipusvia.combo');
		Route::get('/tipusvia/{codigoIneVia?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@tipusvia')->name('api.vialer.tipusvia');
	
		
		//numeros
		Route::get('/numeros/combo/{codigoIneVia}', 'Ajtarragona\Vialer\Controllers\VialerApiController@numerosCombo')->name('api.vialer.numeros.combo');
		Route::get('/numeros/{codigoIneVia}', 'Ajtarragona\Vialer\Controllers\VialerApiController@numeros')->name('api.vialer.numeros');
	
		//blocs
		Route::get('/blocs/combo/{codigoIneVia}', 'Ajtarragona\Vialer\Controllers\VialerApiController@blocsCombo')->name('api.vialer.blocs.combo');
		Route::get('/blocs/{codigoIneVia}', 'Ajtarragona\Vialer\Controllers\VialerApiController@blocs')->name('api.vialer.blocs');
		Route::get('/blocs', 'Ajtarragona\Vialer\Controllers\VialerApiController@allBlocs')->name('api.vialer.allblocs');
	
	
		//escales
		Route::get('/escales/combo/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@escalesCombo')->name('api.vialer.escales.combo');
		Route::get('/escales/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@escales')->name('api.vialer.escales');
		Route::get('/escales', 'Ajtarragona\Vialer\Controllers\VialerApiController@allEscales')->name('api.vialer.allescales');
	
	
		//lletres
		Route::get('/lletres/combo/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@lletresCombo')->name('api.vialer.lletres.combo');
		Route::get('/lletres/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@lletres')->name('api.vialer.lletres');
	
		//plantes
		Route::get('/plantes/combo/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@plantesCombo')->name('api.vialer.plantes.combo');
		Route::get('/plantes/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@plantes')->name('api.vialer.plantes');
		Route::get('/plantes', 'Ajtarragona\Vialer\Controllers\VialerApiController@allPlantes')->name('api.vialer.allplantes');
	
		
		//codis postals
		Route::get('/codispostals/combo/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@codispostalsCombo')->name('api.vialer.codispostals.combo');
		Route::get('/codispostals/{codigoIneVia}/{numero?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@codispostals')->name('api.vialer.codispostals');
		Route::get('/codispostals', 'Ajtarragona\Vialer\Controllers\VialerApiController@allCodispostals')->name('api.vialer.allcodispostals');
		
		//portes
		Route::get('/portes/combo/{codigoIneVia}/{numero?}/{nombrePlanta?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@portesCombo')->name('api.vialer.portes.combo');
		Route::get('/portes/{codigoIneVia}/{numero?}/{nombrePlanta?}', 'Ajtarragona\Vialer\Controllers\VialerApiController@portes')->name('api.vialer.portes');
		Route::get('/portes', 'Ajtarragona\Vialer\Controllers\VialerApiController@allPortes')->name('api.vialer.allportes');
		
	
	
	
	
	});