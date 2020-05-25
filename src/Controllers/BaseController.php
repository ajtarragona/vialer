<?php

namespace Ajtarragona\Vialer\Controllers; 

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BaseController extends Controller
{

	
	
	public function view($view, $args=[]){
        if(!Str::contains($view,"::")) $view="vialer::".$view;
		return view($view, $args);
	}


	
}