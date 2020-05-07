<?php

namespace Ajtarragona\Vialer\Models;

class ModelCatastro{
    
    
    public static function fromResponse($response){
        $response=$response->any;
		$response= simplexml_load_string($response);
		return $response;
    }
}
