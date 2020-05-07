<?php

namespace Ajtarragona\Vialer\Controllers;

use Ajtarragona\Vialer\Models\Domicili;
use Ajtarragona\Vialer\Models\Via;
use Illuminate\Http\Request;

use Catastro;
use Vialer; //facade
use Exception;

class VialerController extends BaseController{
	

	
	public function ajaxform(){
		$value=null;

		$args=compact('value');

		return $this->view('ajaxform', $args);
	}


	public function search($type, Request $request){
		$domicilis=collect();
		// dd($request->all());
		$args=compact('type');

		switch($type){
			case "via":
				if($request->via["codi"]){
					$via = Catastro::getVia($request->via["codi"]);
					
					$viaAccede = Vialer::getVia($request->via["codi"]);
					
					if(!$via){
						$via=new Via($request->via["codi"],$request->via["tipus"],$request->via["nom"]);

					}
					// dump($via);
					if($via){
						$domicilis = $via->getDomicilis($request->numero ?? "0000",[
								"Bloque"=>$request->bloc,
								"Escalera"=>$request->escala, 
								"Planta"=>$request->planta, 
								"Puerta"=>$request->porta
							],
							$viaAccede
						);

					}
					$args["codivia"]=$via->codigoVia;
					$args["nomvia"]=$viaAccede?($viaAccede->codigoTipoVia ." ". $viaAccede->nombreLargoVia):($via->tipoVia." ".$via->nombreVia);
					$args["numero"]=$request->numero;
					$args["bloc"]=$request->bloc;
					$args["escala"]=$request->escala;
					$args["planta"]=$request->planta;
					$args["porta"]=$request->porta;
				}
				break;
			case "refcat":
				$ret=Catastro::consultaDomiliciosPorRC($request->refcat);
				if($ret instanceof Domicili){
					$domicilis->push($ret);
				}else{
					$domicilis = $ret;
				}
				break;
			case "location":
				$domicilis=Catastro::consultaDomiciliosPorXY($request->location["lat"], $request->location["lng"]);

				break;
			default:break;
		}
		$args["domicilis"] = $domicilis;

		return $this->view('modal.modalsearch', $args);

	}

	public function veureParcela($refcat){
		$args=compact('refcat');
		return $this->view('modal.modalparcela', $args);
	}
	

	public function numerero($rc, Request $request){
		// abort(500);
		$domicilis=Catastro::consultaDomiliciosPorRC($rc);
		$args=compact('domicilis');
		if(is_collection($domicilis)){
			return $this->view('modal._numerero', $args);
		}
		abort(404);
	}

	public function domicili($rc, Request $request){
		// dd($rc);
		$domicili=Catastro::consultaDomiliciosPorRC($rc);
		if($domicili instanceof Domicili){
			// dd($domicili);
			return response()->json($domicili);
		}
		abort(404);
	}
	public function testform(Request $request){
		dd($request->all());
	}


	
	// protected function getFilter(){
	// 	return to_object(session('vialer_filter', $this->defaultFilter()));
	// }


	// protected function setFilter($filter){
	// 	if($filter && is_array($filter)){
	// 		$filter= array_merge($this->defaultFilter(), $filter);
	// 	}else{
	// 		$filter=$this->defaultFilter();
	// 	}
	// 	session(['vialer_filter' => $filter ]);
	// 	return to_object($filter);
	// }

	
	// protected function defaultFilter(){
	// 	return [
	// 		"search_type"=>'via',
	// 		"codiVia"=>'',
	// 		"nomVia"=>'',
	// 		"numero"=>'',
	// 		"lletra"=>'',
	// 		"planta"=>'',
	// 		"porta"=>'',
	// 		"escala"=>'',
	// 		"bloc"=>'',
	// 		"rc" =>'',
	// 		"lat" =>'',
	// 		"lng" =>'',
	// 		"codi_postal" =>'',
	// 	];
	// }
	// protected function filterFromRequest($request){
		
	// 	return [
	// 		"search_type"=>$request->action??'via',
	// 		"codiVia"=>$request->codigoVia??'',
	// 		"nomVia"=>'',
	// 		"numero"=>$request->numero??'',
	// 		"lletra"=>$request->lletra??'',
	// 		"planta"=>$request->Planta??'',
	// 		"porta"=>$request->Puerta??'',
	// 		"escala"=>$request->Escalera??'',
	// 		"bloc"=>$request->Bloque??'',
	// 		"rc" =>$request->rc??'',
	// 		"lat" =>$request->lat??'',
	// 		"lng" =>$request->lng??'',
	// 		"codi_postal" =>$request->codigo_postal??''
	// 	];
	// }


// 	public function home(){
		
// 		// $this->setFilter(null);
// 		$filter = $this->getFilter();
// 		// dd($filter);
// 		$via=null;
// 		$viaAccede=null;
// 		$domicilis=null;
// 		$domicili=null;

		
// 		if($filter->search_type=='clear'){
// 			$filter=$this->setFilter(null);
			
// 		}else if( $filter->search_type == 'rc' || $filter->search_type=='xy' ){
			
// 			if($filter->search_type=='xy'){
// 				$domicilis=Catastro::consultaDomiciliosPorXY($filter->lat, $filter->lng);
// 			}else{
// 				$domicilis=Catastro::consultaDomiliciosPorRC($filter->rc);
// 				if($domicilis instanceof Domicili){
// 					return redirect()->route('vialer.domicili',['rc'=>$filter->rc]);
					
// 				}
					
// 			}
	

// 			if($domicilis){
// 				// dd($domicilis);
// 				// $primer=$domicilis->first();				
// 				// $filter->codiVia = $primer->via->codigoVia;
// 				// $filter->numero = $primer->numero;
				
// 				// $filter->nomVia = $viaAccede->codigoTipoVia." ".$viaAccede->nombreLargoVia;
// 			}


// 			if($domicili){
// 				$filter->rc = $domicili->rc->completa;
// 				$filter->lletra = $domicili->letra;
// 				$filter->bloc = $domicili->bloque;
// 				$filter->escala = $domicili->escalera;
// 				$filter->planta = $domicili->planta;
// 				$filter->porta = $domicili->puerta;
// 				$filter->lat = $domicili->xy->lat;
// 				$filter->lng = $domicili->xy->lng;
// 				$filter->codi_postal = $domicili->codigo_postal;	
// 				$filter->codiVia = $domicili->via->codigoVia;
// 				$filter->numero = $domicili->numero;
// 				// $viaAccede = Vialer::getVia($filter->codiVia);
// 				$filter->nomVia = $domicili->viaAccede->codigoTipoVia." ".$domicili->viaAccede->nombreLargoVia;
// 			}

// 		}elseif($filter->search_type=='via'){
// 			if($filter->codiVia){
// 				$via = Catastro::getVia($filter->codiVia);
// 				$viaAccede = Vialer::getVia($filter->codiVia);
// 				$filter->nomVia = $viaAccede->codigoTipoVia." ".$viaAccede->nombreLargoVia;
			
// 				$domicilis = $via->getDomicilis($filter->numero ?? "0000",[
// 						"Bloque"=>$filter->bloc,
// 						"Escalera"=>$filter->escala, 
// 						"Planta"=>$filter->planta, 
// 						"Puerta"=>$filter->porta
// 					],
// 					$viaAccede
// 				);
// 			}
// 			// die();
// 		} 
		
// // dd($filter);
// 		$args=compact('via','viaAccede','filter','domicilis','domicili','defaultValue');

// 		return $this->view('home', $args);
// 	}



// 	public function domicili($rc,Request $request){
// 		$domicili=Catastro::consultaDomiliciosPorRC($rc);
				
// 		if($domicili instanceof Domicili){
// 			$filter = $this->getFilter();
// 			$filter->rc = $domicili->rc->completa;
// 			$filter->lletra = $domicili->letra;
// 			$filter->bloc = $domicili->bloque;
// 			$filter->escala = $domicili->escalera;
// 			$filter->planta = $domicili->planta;
// 			$filter->porta = $domicili->puerta;
// 			$filter->lat = $domicili->xy->lat;
// 			$filter->lng = $domicili->xy->lng;
// 			$filter->codi_postal = $domicili->codigo_postal;	
// 			$filter->codiVia = $domicili->via->codigoVia;
// 			$filter->numero = $domicili->numero;
// 			// $viaAccede = Vialer::getVia($filter->codiVia);
// 			$filter->nomVia = $domicili->viaAccede->codigoTipoVia." ".$domicili->viaAccede->nombreLargoVia;
			
// 			return $this->view('domicili', compact('domicili','filter'));
// 		}else{
// 			$this->setFilter([
// 				"rc"=> $rc,
// 				"search_type"=> 'rc'
// 			]);
				
// 			return redirect()->route('vialer.home');
// 		}
// 	}

// 	public function search(Request $request){
// 		dd($request->all());
// 		$this->setFilter($this->filterFromRequest($request));

// 		return redirect()->route('vialer.home');
// 		// dump($request->rc);
// 		// dd($request->all());

		
		
// 	}

	
}