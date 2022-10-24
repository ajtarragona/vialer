<?php

namespace Ajtarragona\Vialer\Controllers;

use Ajtarragona\Vialer\Models\Domicili;
use Ajtarragona\Vialer\Models\Via;
use Illuminate\Http\Request;

use Catastro;
use Vialer; //facade
use Exception;
use SoapFault;

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
		try{
			switch($type){
				case "via":
					if($request->via["codi"]){
						$via = Catastro::getVia($request->via["codi"]);
						
						$viaIris = Vialer::getVia($request->via["codi"]);
						
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
								$viaIris
							);

						}
						$args["codivia"]=$via->codigoVia;
						$args["nomvia"]=$viaIris?($viaIris->acronym ." ". $viaIris->stname):($via->tipoVia." ".$via->nombreVia);
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
		}catch(SoapFault  $e){
			// dd($e);
			return $this->view('modal.modalerror', ["error"=>__("vialer::vialer.No s'ha pogut connectar amb el servei web del Catastre")]);
			// return "Error";
		}catch(Exception  $e){
			return $this->view('modal.modalerror');
			// return "Error";
		}
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


	
}