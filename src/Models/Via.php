<?php

namespace Ajtarragona\Vialer\Models;

use Catastro;

class Via extends ModelCatastro{
    public $codigoVia;
    public $tipoVia;
    public $nombreVia;
    
    /**
     * Class constructor.
     */
    public function __construct($codigoVia=null,$tipoVia=null,$nombreVia=null)
    {
        $this->codigoVia = $codigoVia;
        $this->tipoVia = $tipoVia;
        $this->nombreVia = $nombreVia;
    }

    public static function fromObject($obj){
        return new static($obj->cv, $obj->tv, $obj->nv);
    }

    public static function fromResponse($response){
        $xml=parent::fromResponse($response);
        // dump($xml);
        if($xml && isset($xml->callejero)){
            $tmp=to_object($xml->callejero);
            $carrers=[];
            if(is_object($tmp->calle)){
                $carrers=[$tmp->calle];
            }else{
                $carrers=$tmp->calle;
            }
            
            // dd($carrers);
            return collect($carrers)->map(function($item){
                return self::fromObject($item->dir);
            });

            // $model = new static;
            // // dump($xml);
            // $coords=to_object($xml->coordenadas->coord->geo);

            // $model->lat=$coords->xcen;
            // $model->lng=$coords->ycen;
            // $model->srs=$coords->srs;
            // return $model;
        }
        return null;
    }



    public function getDomicilis($numero, $parts=[], $viaAccede=null){
        $domicilis=Catastro::consultaDomiciliosPorVia(
            $this->codigoVia, 
            $numero, 
            $parts
        );
        // dump($domicilis);
        //si no existe el numero se devuelve el numerero, en este caso no hay vía, pongo la original
        if($domicilis){
            foreach($domicilis as $domicili){
                if(!isset($domicili->via) || !$domicili->via) $domicili->via=$this;
                if(!isset($domicili->viaAccede) || !$domicili->viaAccede) $domicili->viaAccede=$viaAccede;
            }
        }
        // dd($domicilis);
        return $domicilis;
    }
}
