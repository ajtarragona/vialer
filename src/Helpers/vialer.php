<?php

use Ajtarragona\Vialer\Models\VialerRenderer;

if (! function_exists('vialer')) {
	function vialer($options=false){
		return new \Ajtarragona\Vialer\Providers\VialerProvider($options);
	}
}


if (! function_exists('catastro')) {
	function catastro($options=false){
		return new \Ajtarragona\Vialer\Providers\CatastroProvider($options);
	}
}


if (! function_exists('districtes')) {
	function districtes($options=false){
		return new \Ajtarragona\Vialer\Providers\DistricteSeccioProvider($options);
	}
}




if (! function_exists('vialerFormControl')) {
	function vialerFormControl($options=[]){
		$renderer=new VialerRenderer($options);
		return $renderer->render();
	}
}

