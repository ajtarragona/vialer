<?php

namespace Ajtarragona\Vialer\Controllers;

use Ajtarragona\Vialer\Models\VialerProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Vialer; //facade
use \Artisan;


class VialerController extends Controller{
	public function home(VialerProvider $vialer){
		
		return $vialer->sayHi("Pepito");

	}
}