<?php

if (! function_exists('vialer')) {
	function vialer($options=false){
		return new \Ajtarragona\Vialer\Models\VialerProvider($options);
	}
}