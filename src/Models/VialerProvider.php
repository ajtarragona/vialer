<?php

namespace Ajtarragona\Vialer\Models; 

use Illuminate\Http\Request;

class VialerProvider{
	
	public function sayHi($name){
		return "Hello ".$name;
	}
}