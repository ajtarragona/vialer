<?php

namespace Ajtarragona\Vialer\Models;
use Catastro;

class Coordenades extends ModelCatastro{

    public $lat;
    public $lng;
    public $srs;

    public static function fromResponse($response){
        $xml=parent::fromResponse($response);
        if($xml && isset($xml->coordenadas)){
            $model = new static;
            // dump($xml);
            $coords=to_object($xml->coordenadas->coord->geo);

            $model->lat=$coords->ycen;
            $model->lng=$coords->xcen;
            $model->srs=$coords->srs;
            return $model;
        }
        // dd($xml);
        return null;
    }


    /** Devuelve las RCs en estas coordenadas */
    public function getRCs(){
        return Catastro::consultaRCporXY($this->lat,$this->lng,$this->srs);
    }

}
