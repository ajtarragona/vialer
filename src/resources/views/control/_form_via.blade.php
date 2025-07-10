<div class=" viaform ">
    <input type="hidden" name="{{$name}}[via][tipus]" value="{{ $value->via->tipus }}" />
    <input type="hidden" name="{{$name}}[via][nom]" value="{{ $value->via->nom }}"  />

    

        <div class="d-flex  ">
            <div class="flex-grow-1">
                {{-- <div class="col-2">
                @input(['label'=>'Tipus','readonly'=>true,'name'=>$name.'[via][tipus]','value'=>$value->via->tipus])

            </div> --}}
           
                @php
                    $data=[];
                    if($readonly) $data["disabled"]=true;
                @endphp
                @autocomplete([
                    'label'=>__('vialer::vialer.Carrer'), 
                    'containerclass'=>'inputVia rounded-0',
                    'placeholder'=>$placeholder,
                    'name'=>$name.'[via][codi]',
                    'icon'=>$icon && !($show_refcat || $show_xy) && (!$label || ($label && $label==__("vialer::vialer.Carrer")))?$icon:'',
                    'id'=>$name.'-via-codi',
                    'multiple'=> false,
                    'url' => route('api.vialer.vies.combo'),
                    'savevalue' => true,
                    // 'icon' => 'map-marker',
                    'min-length' => 2,
                    'value'=>$value->via->codi,
                    'valuename' => $value->via->tipus?($value->via->tipus ." ".$value->via->nom):$value->via->nom,
                    "readonly" => $readonly,
	                'parent'=>'body'

                ],$data)
            </div>
            
            <div class="flex-1" style="width:100px" {{in_array("numero",$via_fields)?'':'hidden'}}>
                @input(['label'=>__('vialer::vialer.Núm.'),'name'=>$name.'[numero]','value'=>$value->numero,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
        </div>
        <div class="d-flex ">
           
            
            <div class="flex-fill"  {{ in_array("lletra",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Lletra'),'name'=>$name.'[lletra]','value'=>$value->lletra,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
           
            <div class="flex-fill"   {{ in_array("escala",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Escala'),'name'=>$name.'[escala]','value'=>$value->escala,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
            
            <div class="flex-fill"  {{ in_array("bloc",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Bloc'),'name'=>$name.'[bloc]','value'=>$value->bloc,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
            
            <div class="flex-fill" {{ in_array("planta",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Planta'),'name'=>$name.'[planta]','value'=>$value->planta,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
            
            <div class="flex-fill"  {{ in_array("porta",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Porta'),'name'=>$name.'[porta]','value'=>$value->porta,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
        </div>
        <div class="d-flex">
            <div class="flex-fill "  {{ in_array("codi_postal",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.C.P.'),'name'=>$name.'[codi_postal]','value'=>$value->codi_postal,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
            
            <div class="flex-fill"   {{ in_array("provincia",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Provincia'),'name'=>$name.'[provincia]','value'=>$value->provincia,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
           
            
            <div class="flex-fill"   {{ in_array("municipi",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Municipi'),'name'=>$name.'[municipi]','value'=>$value->municipi,"containerclass"=>"rounded-0", "readonly" => $readonly])
            </div>
        </div>
        <div class="d-flex">   
            
            <div class="flex-fill"  {{ in_array("districte",$via_fields)?'':'hidden' }}> 
                @input(['label'=>__('vialer::vialer.Districte'),'name'=>$name.'[districte]',"containerclass"=>"rounded-0", 'readonly'=>true,'value'=>$value->districte])
            </div>
           
            
            <div class="flex-fill"  {{ in_array("seccio",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Secció'),'name'=>$name.'[seccio]',"containerclass"=>"rounded-0", 'readonly'=>true,'value'=>$value->seccio])
            </div>
           
            
            <div class="flex-fill"  {{ in_array("districte_administratiu",$via_fields)?'':'hidden' }}>
                @input(['label'=>__('vialer::vialer.Districte administratiu'),'name'=>$name.'[districte_administratiu]',"containerclass"=>"rounded-0", 'readonly'=>true,'value'=>$value->districte_administratiu])
            </div>
           
            
        </div>
</div>      

@if(!$readonly && $search_via)
<div class="px-2 pb-2 mt-2">  
    @button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'search-button','name'=>'action','value'=>'via',"disabled" => $readonly]) @icon('search') @lang('vialer::vialer.Localitzar') @endbutton
</div> 
{{-- @button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'clear-button','name'=>'action','value'=>'clear']) @icon('times') Netejar @endbutton --}}
@endif    
