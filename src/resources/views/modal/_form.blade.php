@if(isset($codivia) && $codivia )
    
    @form(['class'=>'vialer-search-form bg-secondary','method'=>'post','action'=>route('vialer.search',["type"=>"via"])])

        <input type="hidden" name="via[codi]" value="{{$codivia}}" />
        

        <div class="d-flex">
            <div class="p-2 d-none d-sm-block">
                @circleicon('search',['bg-color'=>'transparent','color'=>'gray-500','size'=>'lg'])
            </div>
            <div class="flex-grow-1">
                <div class="d-flex">
                    <div class="w-100">
                        @input(['label'=>__('vialer::vialer.Carrer'),'value'=> $nomvia ,'class'=>'nom_carrer','containerclass'=>'bg-secondary border-0 mb-0','readonly'=>true])
                    </div>
                    <div class="flex-shrink-1">
                        @input(['label'=>__('vialer::vialer.Numero'),'name'=>'numero','value'=>$numero,'containerclass'=>'bg-secondary border-0 mb-0'])
                    </div>
                    <div class="flex-shrink-1">
                        @input(['label'=>__('vialer::vialer.Bloc'),'name'=>'bloc','value'=>$bloc,'containerclass'=>'bg-secondary border-0 mb-0'])
                    </div>
                    <div class="flex-shrink-1">
                        @input(['label'=>__('vialer::vialer.Escala'),'name'=>'escala','value'=>$escala,'containerclass'=>'bg-secondary border-0 mb-0'])
                    </div>
                    <div class="flex-shrink-1">
                        @input(['label'=>__('vialer::vialer.Planta'),'name'=>'planta','value'=>$planta,'containerclass'=>'bg-secondary border-0 mb-0'])
                    </div>
                    <div class="flex-shrink-1">
                        @input(['label'=>__('vialer::vialer.Porta'),'name'=>'porta','value'=>$porta,'containerclass'=>'bg-secondary border-0 mb-0'])
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-light btn-sm" hidden>@icon('search') @lang('vialer::vialer.Buscar')</button>
    @endform
@endif