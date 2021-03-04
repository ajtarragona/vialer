@extends('ajtarragona-web-components::layout/master')

@section('title')
	@lang('Vialer')
@endsection

@section('body')

@form(['class'=>'vialer-form','method'=>'post','action'=>route('vialer.testform')])
    

    
    <div class="container-fluid"    >
        {{-- @dump($filter) --}}
        <div class="row pt-3 justify-content-center">
            <div class="col-sm-4 ">  
                @vialerFormControl([
                    'name'=>'field[0][value]',
                    'class' => 'mb-3',
                    'color'=>'info',
                    'label' => 'mierda',
                    'icon' => 'map-marker',
                    'helptext' => 'Lalafd lfd lfdlf',
                    'placeholder' => 'Lalafd lfd lfdlf',
                    // 'show_map'=>false,
                    // 'show_refcat'=>true,
                    // 'show_xy'=>true,
                    // "search_xy"=>false,
                    // "search_refcat"=>false,
                    // "btn_parcela"=>true,
                    "value"=> [
                        "via"=> [
                            "tipus" => "CR",
                            "nom" => "DE LA UNIO",
                            "codi" => 3120
                        ],
                        "numero" => 23,
                        "refcat"=> "3231506CF5533A0016DM",
                        "location" =>[
                            "lat" => "41.1147391577075",
                            "lng" => "1.25146962624948",
                        ]
                    ],
                    "readonly" =>false
                ])

            </div>

            {{-- <div class="col-sm-8 ">     
                  @vialerFormControl([
                    'name'=>'vialer2',
                    "map_position" => "left",
                    "map_columns" => 3,
                    'class' => 'mb-3',
                    'color'=>'secondary',
                    "readonly" =>false
                ])
            </div>
            <div class="col-sm-8 ">  
                @vialerFormControl([
                    'name'=>'vialer3',
                    "map_position" => "right",
                    'class' => 'mb-3'
                    
                ])

            </div> --}}
{{-- 
            <div class="col-sm-4 ">     
                  @vialerFormControl([
                    'name'=>'vialer4',
                    "map_position" => "top",
                    "map_height" => "200px",
                    'class' => 'mb-3'
                ])
            </div> --}}
            
        </div>
    
    </div>
    
    <button type="submit" class="btn btn-primary mt-3 btn-block">@lang('vialer::vialer.test')</button>

@endform

@endsection

@section('pre-js')
	@include("ajtarragona-web-components::layout.parts.gmaps")
@endsection

@section('js')
    <script src="{{ asset('vendor/ajtarragona/js/vialer.js')}}" language="JavaScript"></script>
    <script language="JavaScript">
        
        onDocumentReady = function (callback){
            document.addEventListener('DOMContentLoaded', callback );
        }
        
        
        onDocumentReady(function(){
            $('.vialer-field').vialerField();
        });
    </script>
@endsection


@section('css')
    <link href="{{ asset('vendor/ajtarragona/css/vialer.css') }}" rel="stylesheet">


    {{-- <style>
        @include('vialer::_style')
    </style> --}}
@endsection
