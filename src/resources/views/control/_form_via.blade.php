<div class=" viaform ">
    <input type="hidden" name="{{$name}}[via][tipus]" value="{{ $value->via->tipus }}" />
    <input type="hidden" name="{{$name}}[via][nom]" value="{{ $value->via->nom }}"  />

    

        <div class="row gap-0">
            {{-- <div class="col-2">
                @input(['label'=>'Tipus','readonly'=>true,'name'=>$name.'[via][tipus]','value'=>$value->via->tipus])

            </div> --}}
            <div class="col-12">
                @php
                    $data=[];
                    if($readonly) $data["disabled"]=true;
                @endphp
                @autocomplete([
                    'label'=>__('vialer::vialer.Carrer'), 
                    'containerclass'=>'inputVia',
                    'placeholder'=>$placeholder,
                    'name'=>$name.'[via][codi]',
                    'id'=>$name.'-via-codi',
                    'multiple'=> false,
                    'url' => route('api.vialer.vies.combo'),
                    'savevalue' => true,
                    // 'icon' => 'map-marker',
                    'min-length' => 2,
                    'value'=>$value->via->codi,
                    'valuename' => $value->via->tipus?($value->via->tipus ." ".$value->via->nom):$value->via->nom,
                    "readonly" => $readonly

                ],$data)
            </div>

        </div>
        <div class="row gap-0">
            <div class="col-4 col-sm-2">
                @input(['label'=>__('vialer::vialer.Núm.'),'name'=>$name.'[numero]','value'=>$value->numero,"readonly" => $readonly])
            </div>
            <div class="col-4 col-sm-2">
                @input(['label'=>__('vialer::vialer.Lletra'),'name'=>$name.'[lletra]','value'=>$value->lletra,"readonly" => $readonly])
            </div>
            <div class="col-4 col-sm-2">
                @input(['label'=>__('vialer::vialer.Escala'),'name'=>$name.'[escala]','value'=>$value->escala,"readonly" => $readonly])
            </div>
            <div class="col-3 col-sm-2">
                @input(['label'=>__('vialer::vialer.Bloc'),'name'=>$name.'[bloc]','value'=>$value->bloc,"readonly" => $readonly])
            </div>
            <div class="col-3 col-sm-2">
                @input(['label'=>__('vialer::vialer.Planta'),'name'=>$name.'[planta]','value'=>$value->planta,"readonly" => $readonly])
            </div>
            <div class="col-3 col-sm-2">
                @input(['label'=>__('vialer::vialer.Porta'),'name'=>$name.'[porta]','value'=>$value->porta,"readonly" => $readonly])
            </div>
            <div class="col-sm-4 col-3">
                @input(['label'=>__('vialer::vialer.C.P.'),'name'=>$name.'[codi_postal]','value'=>$value->codi_postal,"readonly" => $readonly])
            </div>
            <div class="col-sm-4 col-6">
                @input(['label'=>__('vialer::vialer.Provincia'),'name'=>$name.'[provincia]','value'=>$value->provincia,"readonly" => $readonly])
            </div>
            <div class="col-sm-4 col-6">
                @input(['label'=>__('vialer::vialer.Municipi'),'name'=>$name.'[municipi]','value'=>$value->municipi,"readonly" => $readonly])
            </div>
            <div class="col-6 col-sm-4">
                @input(['label'=>__('vialer::vialer.Districte'),'name'=>$name.'[districte]','readonly'=>true,'value'=>$value->districte])
            </div>
            <div class="col-6 col-sm-4">
                @input(['label'=>__('vialer::vialer.Secció'),'name'=>$name.'[seccio]','readonly'=>true,'value'=>$value->seccio])
            </div>
            <div class="col-sm-4">
                @input(['label'=>__('vialer::vialer.Districte administratiu'),'name'=>$name.'[districte_administratiu]','readonly'=>true,'value'=>$value->districte_administratiu])
            </div>
        </div>
</div>      

@if(!$readonly)
<div class="px-2 pb-2 mt-2">  
    @button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'search-button','name'=>'action','value'=>'via',"disabled" => $readonly]) @icon('search') @lang('vialer::vialer.Localitzar') @endbutton
</div> 
{{-- @button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'clear-button','name'=>'action','value'=>'clear']) @icon('times') Netejar @endbutton --}}
@endif    
