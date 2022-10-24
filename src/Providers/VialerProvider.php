<?php

namespace Ajtarragona\Vialer\Providers;

use Ajtarragona\Vialer\Models\Domicili;
use Illuminate\Http\Request;
use SoapClient;
use Exception;
use Catastro;
use TsystemsVialer;

use Ajtarragona\Vialer\Traits\CanReturnCached;

class VialerProvider{
	
	use CanReturnCached;

	public function getPais($codigoPais){
		$hash=$this->getHash('getPais', [$codigoPais]);
		return $this->returnCached($hash,function() use ($codigoPais){
			return TsystemsVialer::getCountryByCode($codigoPais);
		});

	}
	
	public function getAllPaisos(){
		$hash=$this->getHash('getAllPaisos');
		return $this->returnCached($hash, function(){
			return TsystemsVialer::getAllCountries();
		});
	}

	public function searchPaisosByName($filter){
		$hash=$this->getHash('searchPaisosByName', [$filter]);
		return $this->returnCached($hash,function() use ($filter){
			return TsystemsVialer::getCountriesByName($filter);
		});
	}

	public function getProvincia($codigoProvincia){
		$hash=$this->getHash('getProvincia', [$codigoProvincia]);
		return $this->returnCached($hash,function() use ($codigoProvincia){
			return TsystemsVialer::getProvinciaByCode($codigoProvincia);
		});
	}
	
	public function getAllProvincies(){
		$hash=$this->getHash('getAllProvincies');
		return $this->returnCached($hash,function() {
			return TsystemsVialer::getAllProvincies();
		});
	}
	
	public function searchProvinciesByName($filter){
		$hash=$this->getHash('searchProvinciesByName', [$filter]);
		return $this->returnCached($hash,function() use ($filter){
			return TsystemsVialer::getProvinciesByName($filter);
		});
	}

	public function getMunicipi($codigoMunicipio, $codigoProvincia=false){
		$hash=$this->getHash('getMunicipi', [$codigoMunicipio, $codigoProvincia]);
		return $this->returnCached($hash,function() use ($codigoMunicipio, $codigoProvincia){
			return TsystemsVialer::getMunicipiByCode($codigoMunicipio, $codigoProvincia);
		});
	}

	public function getAllMunicipis($codigoProvincia=false){
		$hash=$this->getHash('getAllMunicipis', [$codigoProvincia]);
		return $this->returnCached($hash,function() use ($codigoProvincia){
			return TsystemsVialer::getAllMunicipis($codigoProvincia);
		});
	}

	public function searchMunicipisByName($filter, $codigoProvincia=false){
		$hash=$this->getHash('searchMunicipisByName', [$filter, $codigoProvincia]);
		return $this->returnCached($hash,function() use ($filter, $codigoProvincia){
			return TsystemsVialer::getMunicipisByName($filter, $codigoProvincia);
		});
	}


	// public function getPortal($codigoPortal){
	// 	$hash=$this->getHash('getPortal', [$codigoPortal]);
	// 	return $this->returnCached($hash,function() use ($codigoPortal){
	// 		return AccedeVialer::getPortal($codigoPortal);
	// 	});
	// }

	// public function getAllPortals(){
	// 	$hash=$this->getHash('getAllPortals');
	// 	return $this->returnCached($hash,function(){
	// 		return AccedeVialer::getAllPortals();
	// 	});
	// } 	
	// public function getPorta($codigoPuerta){
	// 	$hash=$this->getHash('getPorta', [$codigoPuerta]);
	// 	return $this->returnCached($hash,function() use ($codigoPuerta){
	// 		return AccedeVialer::getPorta($codigoPuerta);
	// 	});
	// }
	// public function getAllPortes(){
	// 	$hash=$this->getHash('getAllPortes');
	// 	return $this->returnCached($hash,function() {
	// 		return AccedeVialer::getAllPortes();
	// 	});
	// } 		
	// public function getPlanta($codigoPlanta){
	// 	$hash=$this->getHash('getPlanta', [$codigoPlanta]);
	// 	return $this->returnCached($hash,function() use ($codigoPlanta){
	// 		return AccedeVialer::getPlanta($codigoPlanta);
	// 	});
	// }	
	// public function getAllPlantes(){
	// 	$hash=$this->getHash('getAllPlantes');
	// 	return $this->returnCached($hash,function(){
	// 		return AccedeVialer::getAllPlantes();
	// 	});
	// } 	
	// public function getEscala($codigoEscalera){
	// 	$hash=$this->getHash('getEscala', [$codigoEscalera]);
	// 	return $this->returnCached($hash,function() use ($codigoEscalera){
	// 		return AccedeVialer::getEscala($codigoEscalera);
	// 	});
	// }
	// public function getAllEscales(){
	// 	$hash=$this->getHash('getAllEscales');
	// 	return $this->returnCached($hash,function(){
	// 		return AccedeVialer::getAllEscales();
	// 	});
	// } 	
	// public function getAllBlocs($codiProvincia=false){
	// 	$hash=$this->getHash('getAllBlocs', [$codiProvincia]);
	// 	return $this->returnCached($hash,function() use ($codiProvincia){
	// 		return AccedeVialer::getAllBlocs($codiProvincia);
	// 	});
	// }
	// public function getBloc($codigoBloque){
	// 	$hash=$this->getHash('getBloc', [$codigoBloque]);
	// 	return $this->returnCached($hash,function() use ($codigoBloque){
	// 		return AccedeVialer::getBloc($codigoBloque);
	// 	});
	// }
	// public function getAllCodisPostals($codiProvincia=false){
	// 	$hash=$this->getHash('getAllCodisPostals', [$codiProvincia]);
	// 	return $this->returnCached($hash,function() use ($codiProvincia){
	// 		return AccedeVialer::getAllCodisPostals($codiProvincia);
	// 	});
	// }
	// public function getCodiPostal($codigoPostal){
	// 	$hash=$this->getHash('getCodiPostal', [$codigoPostal]);
	// 	return $this->returnCached($hash,function() use ($codigoPostal){
	// 		return AccedeVialer::getCodiPostal($codigoPostal);
	// 	});
	// }
	// public function getCodisPostalsVia($codigoIneVia){
	// 	$hash=$this->getHash('getCodisPostalsVia', [$codigoIneVia]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia){
	// 		return AccedeVialer::getCodisPostalsVia($codigoIneVia);
	// 	});
	// }
	// public function getNumerosVia($codigoIneVia){
	// 	$hash=$this->getHash('getNumerosVia', [$codigoIneVia]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia){
	// 		return AccedeVialer::getNumerosVia($codigoIneVia);
	// 	});
	// }
	// public function getBlocsVia($codigoIneVia){
	// 	$hash=$this->getHash('getBlocsVia', [$codigoIneVia]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia){
	// 		return AccedeVialer::getBlocsVia($codigoIneVia);
	// 	});
	// }
	// public function getLletresVia($codigoIneVia, $numero=false){
	// 	$hash=$this->getHash('getLletresVia', [$codigoIneVia, $numero]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia, $numero){
	// 		return AccedeVialer::getLletresVia($codigoIneVia, $numero);
	// 	});
	// }
	// public function getPlantesVia($codigoIneVia, $numero=false){
	// 	$hash=$this->getHash('getPlantesVia', [$codigoIneVia, $numero]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia, $numero){
	// 		return AccedeVialer::getPlantesVia($codigoIneVia, $numero);
	// 	});
	// }
	// public function getEscalesVia($codigoIneVia, $numero=false){
	// 	$hash=$this->getHash('getEscalesVia', [$codigoIneVia, $numero]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia, $numero){
	// 		return AccedeVialer::getEscalesVia($codigoIneVia, $numero);
	// 	});
	// }
	// public function getPortesVia($codigoIneVia, $numero=false, $nombrePlanta=false){
	// 	$hash=$this->getHash('getPortesVia', [$codigoIneVia, $numero, $nombrePlanta]);
	// 	return $this->returnCached($hash,function() use ($codigoIneVia, $numero, $nombrePlanta){
	// 		return AccedeVialer::getPortesVia($codigoIneVia, $numero, $nombrePlanta);
	// 	});
	// }


	public function searchViesByName($filter, $codiProvincia=false, $codiMunicipi=false){
		$hash=$this->getHash('searchViesByName', [$filter, $codiProvincia, $codiMunicipi]);
		return $this->returnCached($hash,function() use ($filter, $codiProvincia, $codiMunicipi){
			try{
				return TsystemsVialer::getCarrersByName($filter,$codiMunicipi);
			}catch(Exception $e){
				return null;
			}
		});
	}

	public function getVia($codigoIneVia, $codigoProvincia=null, $codigoMunicipio=null){
		if(!$codigoIneVia) return null;
		$hash=$this->getHash('getVia', [$codigoIneVia]);
		return $this->returnCached($hash,function() use ($codigoIneVia, $codigoProvincia, $codigoMunicipio){
			try{
				$via=TsystemsVialer::getCarrerByCode(intval($codigoIneVia), intval($codigoMunicipio));
				return $via;
			}catch(exception $e){
				return null;
			}
		});
	}
	// public function getAllVies($codiProvincia=false, $codiMunicipi=false){
	// 	$hash=$this->getHash('getAllVies', [$codiProvincia, $codiMunicipi]);
	// 	return $this->returnCached($hash,function() use ($codiProvincia, $codiMunicipi){
	// 		return AccedeVialer::getAllVies($codiProvincia, $codiMunicipi);
	// 	});
	// }


	

	// public function getAllTipusVia(){
	// 	$hash=$this->getHash('getAllTipusVia', []);
	// 	return $this->returnCached($hash,function() {
	// 		return AccedeVialer::getAllTipusVia();
	// 	});
	// }
	// public function getTipusVia($codigoTipoVia){
	// 	$hash=$this->getHash('getTipusVia', [$codigoTipoVia]);
	// 	return $this->returnCached($hash,function() use ($codigoTipoVia){
	// 		return AccedeVialer::getTipusVia($codigoTipoVia);
	// 	});
	// }


	// public function searchDomicilis($params=[]){
	// 	$hash=$this->getHash('searchDomicilis', [$params]);
	// 	return $this->returnCached($hash,function() use ($params){
	// 		return AccedeVialer::searchDomicilis($params);
	// 	});
	// }
	
	
}