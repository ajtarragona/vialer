<?php

namespace Ajtarragona\Vialer\Controllers; 

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Ajtarragona\Accede\Exceptions\AccedeErrorException;
use Ajtarragona\Accede\Exceptions\AccedeNoResultsException;
use Exception;


class BaseApiController extends Controller{

	protected function tryWrap(callable $function){
		try{
			return call_user_func($function);
		}catch(Exception $e){
			// dd($e);
			return response()->json([
				'error' => $e->getCode(),
				'message' => $e->getMessage()
			], 500);
		}

	}
}