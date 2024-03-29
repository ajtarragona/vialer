<?php

namespace Ajtarragona\Vialer\Models;
use Catastro;
use Vialer;
use Districtes;
use Exception;

class Domicili extends ModelCatastro{

   
    public $rc;
    public $via;
    public $viaIris;
    public $numero;
    public $letra;
    public $escalera;
    public $planta;
    public $puerta;
    public $bloque;
    public $codigo_postal;
    public $xy;
    public $numerer;
    public $rustic;
    public $provincia;
    public $municipi;
    public $districte;
    public $seccio;
    public $districte_administratiu;

    public static function fromObject($object, $xy=false){
        $ret= new static;
        $ret->rc=ReferenciaCatastral::fromObject($object->rc);
        
        if($xy){
            $ret->xy=Catastro::consultaXYporRC($ret->rc->parcela);
            // dd($ret);
            $dissec=districtes()->getDistricteISeccio($ret->xy->lat, $ret->xy->lng);
            // dd($dissec);
            if($dissec){
                $ret->districte=$dissec->districte;
                $ret->seccio=$dissec->seccio;
                $ret->districte_administratiu=$dissec->districte_administratiu;
            }
        }else{
            $ret->xy=to_object(["lat"=>0,"lng"=>0]);
        }
        

            
        if(isset($object->num)){
            $ret->numero=$object->num->pnp ?? null;
            $ret->letra=$object->num->plp ?? null;
                 
        }else if(isset($object->dt)){
            $dt=to_object($object->dt);
            // dump($dt);
            $ret->provincia=$dt->np??'';
            $ret->municipi=$dt->nm??'';
            
            $locs=isset($dt->locs->lous)?$dt->locs->lous:(isset($dt->locs->lors)?$dt->locs->lors:null);
            // dd($locs);
            if($locs){
                if(isset($locs->lourb)){
                    $ret->via=Via::fromObject($locs->lourb->dir);
                    try{
                        $ret->viaIris=Vialer::getVia($ret->via->codigoVia, $dt->loine->cp, $dt->loine->cm);
                        // dd($ret);
                    }catch(Exception $e){
                        $ret->viaIris=null;
                        // dd($e);
                    }
                    
                    $ret->numero=$locs->lourb->dir->pnp ?? null;
                    $ret->letra=$locs->lourb->dir->plp ?? null;
                    $ret->codigo_postal=$locs->lourb->dp ?? null;
                    if(isset($locs->lourb->loint)){
                        $ret->escalera=$locs->lourb->loint->es ?? null;
                        $ret->planta=$locs->lourb->loint->pt ?? null;
                        $ret->puerta=$locs->lourb->loint->pu ?? null;
                        $ret->bloque=$locs->lourb->loint->bq ?? null;
                        if($ret->escalera.$ret->planta.$ret->puerta=="TODOS"){
                           $ret->escalera="";
                           $ret->planta="";
                           $ret->puerta="";
                        }elseif($ret->escalera.$ret->planta.$ret->puerta=="SUELO"){
                           $ret->escalera="";
                           $ret->planta="BAIX";
                           $ret->puerta="";
                        }
                        
                    }
                }elseif(isset($locs->lorus)){
                    $ret->rustic=true;
                    $ret->via= new Via(0,"",$locs->lorus->npa);
                    
                }
                
            }
            
            // $args=[
            //     "codigoIneVia" => $ret->via->codigoVia,
            //     "numero" => $ret->numero
            // ];
            // if($ret->escalera) $args["codigoEscalera"]=intval($ret->escalera)?intval($ret->escalera):$ret->escalera;
            // if($ret->planta) $args["codigoPlanta"]= $ret->planta;
            // if($ret->puerta) $args["codigoPuerta"]=$ret->puerta;
            // if($ret->bloque) $args["codigoBloque"]=intval($ret->bloque)?intval($ret->bloque):$ret->bloque;
            

         

            // // dump($args);

            // try{
            //     $ret->domicili=Vialer::searchDomicilis($args);
            // }catch(Exception $e){
            //     dump($e);
            // }
        }
        return $ret;

    }


    public static function fromResponse($response){
        $xml=parent::fromResponse($response);
        
        if($xml){
            if(isset($xml->lrcdnp)){
                //hay varias
                $tmp=to_object($xml->lrcdnp);
                $rcs=[];

                if(is_object($tmp->rcdnp)){
                    $rcs=[$tmp->rcdnp];
                }else{
                    $rcs=$tmp->rcdnp;
                }
                return collect($rcs)->map(function($item){
                    return self::fromObject($item);
                });

            }else if(isset($xml->bico)){
                //hay solo una
                // dd($xml->bico);
                $tmp= to_object($xml->bico)->bi;
                // dd($tmp);
                $tmp->rc=$tmp->idbi->rc;
                $ret=collect();
                $ret->push(self::fromObject($tmp, true));
                return $ret;
                // dd($nums);
            }else if(isset($xml->numerero)){
                //no existe el numero, devuelvo numerero

                $tmp= to_object($xml->numerero);
                if(!is_array($tmp->nump)) $tmp->nump=[$tmp->nump];
                // dd($tmp);
                $ret=new Numerero();
                foreach($tmp->nump as $num){
                    $num->rc=$num->pc;
                    $ret->push(self::fromObject($num));
                }
                return $ret;
                //el numero no existe
            }

        }
        return null;
    }


    public function cadenaDomicili(){
       return cadenaDomicili($this);
    }


    public function nomVia(){
        if($this->rustic){
            return $this->via->nombreVia;
        }else{
            if($this->viaIris){
                return $this->viaIris->acronym." ".$this->viaIris->stname;
            }else{
                return $this->via? ($this->via->tipoVia." ".$this->via->nombreVia): "";
            }
        }
    }


    public function toArray(){
        $via=[
            "tipus"=> "",
            "nom"=>"",
            "codi"=>""
        ];
        if($this->viaIris){
            $via=[
                "tipus"=> $this->viaIris->acronym,
                "nom"=> $this->viaIris->stname,
                "codi"=> $this->viaIris->code
            ];
        }else if($this->via){
            $via=[
                "tipus"=> $this->via->tipoVia,
                "nom"=> $this->via->nombreVia,
                "codi"=> $this->via->codigoVia
            ];
        }
        return[
             "via"=> $via,
             "numero"=> $this->numero,
             "lletra"=> $this->letra,
             "escala"=>$this->escalera,
             "bloc"=>$this->bloque,
             "planta"=> $this->planta,
             "porta"=> $this->puerta,
             "codi_postal"=>$this->codigo_postal,
             "provincia"=> $this->provincia,
             "municipi"=>$this->municipi,
             "districte"=>$this->districte,
             "seccio"=>$this->seccio,
             "districte_administratiu"=>$this->districte_administratiu,
             "refcat"=> $this->rc->completa,
             "location"=>[
                 "lat"=> $this->xy->lat,
                 "lng"=>$this->xy->lng
             ]
        ];
    }

}
