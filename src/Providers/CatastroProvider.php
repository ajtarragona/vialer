<?php

namespace Ajtarragona\Vialer\Providers;

use Ajtarragona\Vialer\Models\Coordenades;
use Ajtarragona\Vialer\Models\ReferenciaCatastral;
use Ajtarragona\Vialer\Models\Domicili;
use Ajtarragona\Vialer\Models\Via;
use Ajtarragona\Vialer\Models\ModelCatastro;
use Ajtarragona\Vialer\Traits\CanReturnCached;
use Illuminate\Http\Request;
use SoapClient;
use Exception;

class CatastroProvider{
  
    use CanReturnCached;
    
    protected $wsdl_calle="http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?WSDL";
    protected $wsdl_callecodigo="http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejeroCodigos.asmx?WSDL";
    protected $wsdl_coord="http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCoordenadas.asmx?WSDL";
    
    
    protected $provincia;
    protected $municipio;
    protected $codigoProvincia;
    protected $codigoMunicipio;
    protected $codigoMunicipioIne;
    protected $srs;

    
    /**
     * Class constructor.
     */
    public function __construct($args = null)
    {
       
       $config=config('vialer');
       $this->srs = $config["srs"];
       $this->provincia = $config["provincia"];
       $this->municipio = $config["municipio"];
       $this->codigoProvincia = $config["codigoProvincia"];
       $this->codigoMunicipio = $config["codigoMunicipio"];
       $this->codigoMunicipioIne = $config["codigoMunicipioIne"];
    } 
    

    protected function callejero(){
        return new SoapClient($this->wsdl_calle);
    }

    protected function callejero_codigo(){
        return new SoapClient($this->wsdl_callecodigo);
    }

    protected function coordenadas(){
        return new SoapClient($this->wsdl_coord);
    }
     


    /**
     * Devuelve una vía a partir de su código.
     * Retorna una sola via
     */
    public function getVia($codigoIneVia, $codigoProvincia=null, $codigoMunicipio=null, $codigoMunicipioIne=null){

        $hash=$this->getHash('getVia', [$codigoIneVia, $codigoProvincia, $codigoMunicipio, $codigoMunicipioIne]);
        
		return $this->returnCached($hash, function() use ($codigoIneVia, $codigoProvincia, $codigoMunicipio, $codigoMunicipioIne){
            $results=$this->callejero_codigo()->ObtenerCallejeroCodigos(
                $codigoProvincia ?? $this->codigoProvincia, 
                $codigoMunicipio ?? $this->codigoMunicipio,  
                $codigoMunicipioIne ?? $this->codigoMunicipioIne,  
                $codigoIneVia
            );

            $ret= Via::fromResponse($results);
            
            if($ret && $ret->count()>0) return $ret->first();
            return null;
        });
    }
    

    
    /**
     * Consulta vias por nombre de la via. Opcionalmente se puede pasar el código de tipo de via.
     * Retorna una collection de Via
     */
    public function consultaViasPorNombre($nombreVia, $tipoVia=null){
        $hash=$this->getHash('consultaViasPorNombre', [$nombreVia, $tipoVia]);
        
		return $this->returnCached($hash, function() use ($nombreVia, $tipoVia){
            $results=$this->callejero()->ObtenerCallejero(
                $provincia ?? $this->provincia, 
                $municipio ?? $this->municipio,  
                $tipoVia ?? "", 
                $nombreVia
            );
            return Via::fromResponse($results);
        });
    }



    
    /** 
     * Consulta las los domicilios de una vía y un número. 
     * Opcionalmente podemos pasar más partes de la dirección en un array (Bloque, Escalera, Planta y Puerta)
     * Devuelve una collection de objetos Domicili.
     * El domicilio contiene la RC, codigo de calle, y coordenadas x,y
     */
    public function consultaDomiciliosPorVia($codigoVia, $numero, $partes=[], $codigoProvincia=null, $codigoMunicipio=null, $codigoMunicipioIne=null){
        $partes=array_merge([
            "Bloque" => "",
            "Escalera" => "",
            "Planta" => "",
            "Puerta" => "",
        ],$partes);

        $hash=$this->getHash('consultaDomiciliosPorVia', [$codigoVia, $numero, $partes, $codigoProvincia, $codigoMunicipio, $codigoMunicipioIne]);
        
        if(!$codigoVia) return null;

		return $this->returnCached($hash, function() use ($codigoVia, $numero, $partes, $codigoProvincia, $codigoMunicipio, $codigoMunicipioIne){

            $results=$this->callejero_codigo()->Consulta_DNPLOC_Codigos(
                $codigoProvincia ?? $this->codigoProvincia, 
                $codigoMunicipio ?? $this->codigoMunicipio,  
                $codigoMunicipioIne ?? $this->codigoMunicipioIne,  
                $codigoVia, 
                $numero, 
                $partes["Bloque"],
                $partes["Escalera"],
                $partes["Planta"],
                $partes["Puerta"]
            );
            
            //retorno rc, via y xy 
            $domicilis = Domicili::fromResponse($results);
            // dd($domicilis);
            return $domicilis;
        });
    }


    /**
     * Devuelve los domicilios en una referencia catastral. 
     * Si la RC es de 14 es de parcela, puede haber varios domicilios
     * Si la RC es de 20 es un domicilio concreto
     */
    public function consultaDomiliciosPorRC($rc){
        $hash=$this->getHash('consultaDomiliciosPorRC', [$rc]);
        // dd($rc);
		return $this->returnCached($hash, function() use ($rc){
            $results=$this->callejero()->Consulta_DNPRC(
                $provincia ?? '', 
                $municipio ?? '',  
                $rc 
            );
            // dd($results);
            // dd(ModelCatastro::fromResponse($results));
            // dump($results);
            $ret=Domicili::fromResponse($results);
            dd($ret);
            if($ret && $ret->count()>0){
                if(strlen($rc)==20) return $ret->first();
                else return $ret;
            }
            return null;
        });

    }

    /**
     * Consulta de domiilio en unas coordendaas X,Y
     * Devuelve una collection de domicilios
     */
    public function consultaDomiciliosPorXY($lat, $lng){
        $rc=$this->consultaRCporXY($lng,$lat);
        if($rc)
            return $this->consultaDomiliciosPorRC($rc->completa);
        else
            return null;
    }





    /**  COORDENADAS  */

    /**
     * Devuelve Lat y Lng a partir de RC
     */
    public function consultaXYporRC($rc, $srs=null, $provincia = null, $municipio=null){
        $hash=$this->getHash('consultaXYporRC', [$rc, $srs, $provincia , $municipio]);
        // dd($rc);
		return $this->returnCached($hash, function() use ($rc, $srs, $provincia , $municipio){
            $results=$this->coordenadas()->Consulta_CPMRC(
                $provincia ?? '', 
                $municipio ?? '',  
                $srs ?? $this->srs, 
                $rc
            );
            // dd($results);
            return Coordenades::fromResponse($results);
        });

    }


    /**
     * Devuelve RC a partir de XY
     */
    public function consultaRCporXY($x, $y, $srs=null){
        $hash=$this->getHash('consultaRCporXY', [$x, $y, $srs]);
        
		return $this->returnCached($hash, function() use ($x, $y, $srs){
            $results=$this->coordenadas()->Consulta_RCCOOR(
                $srs ?? $this->srs, 
                $x, $y
            );
            $ret=ModelCatastro::fromResponse($results);
            if(isset($ret->coordenadas)){
                $coords=to_object($ret->coordenadas->coord->pc);
                return ReferenciaCatastral::fromObject($coords);
            }
            return null;
        });

    }

}