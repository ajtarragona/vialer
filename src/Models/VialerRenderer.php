<?php

namespace Ajtarragona\Vialer\Models;
use Illuminate\Support\Str;

class VialerRenderer{

    protected $default_domicili=[
        "via"=> [
            "tipus" => "",
            "nom" => "",
            "codi" => ""
        ],
        "numero" => "",
        "lletra" => "",
        "escala" => "",
        "bloc" => "",
        "planta" => "",
        "porta" => "",
        "codi_postal" => "",
        "refcat" => "",
        "provincia" => "",
        "municipi" => "",
        "districte" => "",
        "seccio" => "",
        "districte_administratiu" => "",
        "location" => [
            "lat" => '',
            "lng" => ''
        ]
    ];


    protected $defaults=[
        'class' => '',
        "value" => null,
        "label" => null,
        "placeholder" => null,
        "helptext" => null,
        "icon" => null,
        "name" => "vialer",
        "id" => null,
        "map_position" => "bottom",
        "map_height" => "300px",
        "map_columns" => 6,
        'color'=>null,
        "show_map" => true,
        "show_refcat" => true,
        "show_xy" => true,
        "search_refcat" => true,
        "btn_parcela" => true,
        "search_xy" => true,
        "readonly"=>false,
        "required"=>false,
        "disabled"=>false,
    ];

    protected $options=[];

    /**
     * Class constructor.
     */
    public function __construct($options=[])
    {
        // $this->default_domicili= to_object($this->default_domicili);

        $this->options = array_merge($this->defaults, $options);
        $this->domicili=new Domicili();
        //modifico el valor para que tenga todos los campos en blanco almenos
        $value=$this->options["value"];
        $this->options["value"] = to_object(array_merge($this->default_domicili, (($value && is_array($value))?$value:[]) ) );
        
        if(!$this->options["id"]) $this->options["id"] = Str::snake($this->options["name"]);
        // dd($this);

        $this->options['class'].= " vialer-field map-". $this->options["map_position"];
    

    }

    public function render(){
        // dump($this->options["map_position"]);
        $view='vialer::control._layout_'.($this->options["map_position"]??'bottom');
        if(!$this->options["show_map"])  $view='vialer::control._layout_nomap';
       
        // dd($view);
        if(view()->exists($view)){
            return view($view, $this->options);
        }else{
            return view('vialer::control._layout_bottom', $this->options);
        }
    }
}