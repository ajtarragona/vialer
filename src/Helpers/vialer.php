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
if (! function_exists('cadenaDomicili')) {
	function cadenaDomicili($domicili, $provinciaimun=false){
		$ret=[];
		// $ret[]=$domicili->nomVia();

		if(isset($domicili->rustic) && $domicili->rustic){
            $ret[]=$domicili->via->nombreVia;
        }else{
            if(isset($domicili->viaAccede) && $domicili->viaAccede){
                $ret[]= $domicili->viaAccede->codigoTipoVia." ".$domicili->viaAccede->nombreLargoVia;
            }else{
                $ret[]= $domicili->via? ($domicili->via->tipoVia." ".$domicili->via->nombreVia): "";
            }
        }
		if($domicili->numero) $ret[]=$domicili->numero;
		if($domicili->letra) $ret[]=$domicili->letra;
		if($domicili->escalera) $ret[]="ESC: ".$domicili->escalera;
		if($domicili->bloque) $ret[]="BLQ: ".$domicili->bloque;
		if($domicili->planta) $ret[]="PLNT: ".$domicili->planta;
		if($domicili->puerta) $ret[]="PRT: ".$domicili->puerta;
		if($domicili->codigo_postal) $ret[]="CP: ".$domicili->codigo_postal;
		if($provinciaimun && $domicili->provincia) $ret[]=$domicili->provincia ??'';
		if($provinciaimun && $domicili->municipi) $ret[]=$domicili->municipi ??'';
		return implode(" ",$ret);
	}
}

