<?php

namespace Ajtarragona\Vialer\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BaseController extends Controller
{

	
	
	public function view($view, $args=[]){
        if(!Str::contains($view,"::")) $view="vialer::".$view;
		return view($view, $args);
	}


	
}