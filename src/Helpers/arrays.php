<?php

use Ajtarragona\Vialer\Models\Numerero;
use Illuminate\Support\Collection;

if (! function_exists('to_object')) {
	function to_object($array) {
		return json_decode(json_encode($array), FALSE);
		
	}
}



if (! function_exists('to_array')) {
	function to_array($object) {
	 	return json_decode(json_encode($object), true);
	}
}


if (! function_exists('is_collection')) {
	function is_collection($obj){
		return $obj && ($obj instanceof Collection);

	}
}

if (! function_exists('is_numerero')) {
	function is_numerero($obj){
		return $obj && ($obj instanceof Numerero);

	}
}