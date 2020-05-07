<?php

namespace Ajtarragona\Vialer\Controllers; 

use Illuminate\Http\Request;
use Vialer; //facade

class VialerApiController extends BaseApiController{
   

	public function pais($codigoPais){
		return $this->tryWrap(function() use ($codigoPais){
			return response()->json(Vialer::getPais(intval($codigoPais)));
		});
	}




	public function paisos($filter=false){
		return $this->tryWrap(function() use ($filter){
			
			if($filter){
				$paisos=Vialer::searchPaisosByName($filter);
			}else{
				$paisos=Vialer::getAllPaisos();
			}

			return response()->json($paisos);

		});
		
	}




	public function provincia($codigoProvincia){
		return $this->tryWrap(function() use ($codigoProvincia){
			return response()->json(Vialer::getProvincia(intval($codigoProvincia)));
		});
	}
	



	public function provincies($filter=false){
		return $this->tryWrap(function() use ($filter){
			if($filter){
				$provincies=Vialer::searchProvinciesByName($filter);
			}else{
				$provincies=Vialer::getAllProvincies();
			}

			return response()->json($provincies);
		});
		
	}





	public function municipi($codigoMunicipio){
		return $this->tryWrap(function() use ($codigoMunicipio){
			return response()->json(Vialer::getMunicipi(intval($codigoMunicipio),intval($request->codigoProvincia)));
		});
	}




	public function municipis($filter=false, Request $request){
        // dd($filter);
		return $this->tryWrap(function() use ($filter, $request){
			if($filter){
				$municipis=Vialer::searchMunicipisByName($filter, intval($request->codigoProvincia));
			}else{
				$municipis=Vialer::getAllMunicipis(intval($request->codigoProvincia));
			}
			return response()->json($municipis);
		});
		
	}





	public function via($codigoIneVia){
		return $this->tryWrap(function() use ($codigoIneVia){
			//dd($codigoIneVia);
			return response()->json(Vialer::getVia(intval($codigoIneVia),intval($request->codigoProvincia),intval($request->codigoMunicipio)));
		});
	}





	public function vies($filter=false, Request $request){
		return $this->tryWrap(function() use ($filter, $request){
			if($filter){
				$vies=Vialer::searchViesByName($filter,intval($request->codigoProvincia),intval($request->codigoMunicipio));
			}else{
				$vies=Vialer::getAllVies(intval($request->codigoProvincia),intval($request->codigoMunicipio));
			}
			return response()->json($vies);
		});
		
	}








	public function codificadors($codigoIneVia, $numero=false, $nombrePlanta=false){
		return $this->tryWrap(function() use ($codigoIneVia,$numero,$nombrePlanta){
			$codificadors=Vialer::getCodificadorsVia($codigoIneVia,$numero,$nombrePlanta);
			return response()->json($codificadors);
		});
	}






	public function viesCombo(Request $request){
		return $this->tryWrap(function() use ($request){
			
			if($request->term){
                
				$vies=Vialer::searchViesByName($request->term,intval($request->codigoProvincia),intval($request->codigoMunicipio));
			}else{
				$vies=Vialer::getAllVies(intval($request->codigoProvincia),intval($request->codigoMunicipio));
			}
			
			$ret=[];
			if($vies){
				foreach($vies as $via){
					$ret[] = ["value"=>$via->codigoIneVia, "name"=>$via->codigoTipoVia." ".$via->nombreLargoVia, "tipusVia" => $via->codigoTipoVia ,"nomLlarg" => $via->nombreLargoVia, "nomCurt" => $via->nombreVia];
				}
			}
		    return response()->json($ret);

		});
		
	}





	public function numeros($codigoIneVia){
		return $this->tryWrap(function() use ($codigoIneVia){
			$numeros=Vialer::getNumerosVia($codigoIneVia);
			return response()->json($numeros);
		});
	}





	public function numerosCombo($codigoIneVia){
		return $this->tryWrap(function() use ($codigoIneVia){
			$items=Vialer::getNumerosVia($codigoIneVia);
				
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item, "name"=>$item];
		    }
		    return response()->json($ret);
		});
	}
	



	
	public function lletres($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$lletres=Vialer::getLletresVia($codigoIneVia, $numero);
			return response()->json($lletres);
		});
	}





	public function lletresCombo($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$items=Vialer::getLletresVia($codigoIneVia, $numero);
			//dd($items);
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item, "name"=>$item];
		    }
		    return response()->json($ret);
		});
	}

	
	



	public function escales($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$escales=Vialer::getEscalesVia($codigoIneVia, $numero);
			return response()->json($escales);
		});
	}





	public function escalesCombo($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$items=Vialer::getEscalesVia($codigoIneVia, $numero);
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item["codigoEscalera"], "name"=>$item["nombreEscalera"] ];
		    }
		    return response()->json($ret);
		});
	}




	

	public function blocs($codigoIneVia){
		return $this->tryWrap(function() use ($codigoIneVia){
			$blocs=Vialer::getBlocsVia($codigoIneVia);
			return response()->json($blocs);
		});
	}





	public function blocsCombo($codigoIneVia){
		return $this->tryWrap(function() use ($codigoIneVia){
			$items=Vialer::getBlocsVia($codigoIneVia);
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item["codigoBloque"], "name"=>$item["nombreBloque"]];
		    }
		    return response()->json($ret);
		});
	}





	public function plantes($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$plantes=Vialer::getPlantesVia($codigoIneVia, $numero);
			return response()->json($plantes);
		});
	}






	public function plantesCombo($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$items=Vialer::getPlantesVia($codigoIneVia, $numero);
			//dd($items);
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item["codigoPlanta"], "name"=>$item["nombrePlanta"]];
		    }
		    return response()->json($ret);
		});
	}


	

	public function codispostals($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$cpostals=Vialer::getCodisPostalsVia($codigoIneVia, $numero);
			return response()->json($cpostals);
		});
	}

	


	public function codispostalsCombo($codigoIneVia, $numero=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero){
			$items=Vialer::getCodisPostalsVia($codigoIneVia, $numero);
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item, "name"=>$item];
		    }
		    return response()->json($ret);
		});
	}





	public function portes($codigoIneVia, $numero=false, $nombrePlanta=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero, $nombrePlanta){
			$portes=Vialer::getPortesVia($codigoIneVia, $numero, $nombrePlanta);
			return response()->json($portes);
		});
	}





	public function portesCombo($codigoIneVia, $numero=false, $nombrePlanta=false){
		return $this->tryWrap(function() use ($codigoIneVia, $numero, $nombrePlanta){
			$items=Vialer::getPortesVia($codigoIneVia, $numero, $nombrePlanta);
			$ret=[];
		    foreach($items as $item){
		        $ret[] = ["value"=>$item["codigoPuerta"], "name"=>$item["nombrePuerta"]];
		    }
		    return response()->json($ret);
		});
	}
	
}
