<?php

namespace Ajtarragona\Vialer\Models;
use Catastro;


class ReferenciaCatastral extends ModelCatastro{

    public $completa;
    public $parcela;
    public $pc1;
    public $pc2;
    public $car;
    public $cc1;
    public $cc2;
    

    public static function fromObject($obj){
        $ret= new static;
        $ret->pc1=$obj->pc1 ?? null;
        $ret->pc2=$obj->pc2 ?? null;
        $ret->car=$obj->car ?? null;
        $ret->cc1=$obj->cc1 ?? null;
        $ret->cc2=$obj->cc2 ?? null;
        $ret->parcela= $ret->pc1.$ret->pc2;
        $ret->completa= $ret->pc1.$ret->pc2.$ret->car.$ret->cc1.$ret->cc2;
       
        // $ret->numero = $ret->numero ?? null;
        return $ret;
    }

    /** Devuelve las coordenadas de esta RC */
    public function toXY(){
        return Catastro::consultaXYporRC($this->completa);
    }

}
