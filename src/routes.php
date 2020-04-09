<?php

Route::group(['prefix' => 'ajtarragona/vialer','middleware' => ['vialer-backend','web','auth','language']	], function () {
	
	Route::get('/', 'Ajtarragona\Vialer\Controllers\VialerController@home')->name('vialer.home');
	
});



Route::group(['prefix' => 'ajtarragona/vialer/api'], function () {


});