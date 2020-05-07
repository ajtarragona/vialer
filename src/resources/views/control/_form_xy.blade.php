<div class="locationform ">
    <div class="row gap-0">
        <div class="col-sm-6">
            @input(['label'=>__('vialer::vialer.Lat.'),'name'=>$name.'[location][lat]','value'=>$value->location->lat ??'',"readonly" => $readonly])
        </div>
        <div class="col-sm-6">
            @input(['label'=>__('vialer::vialer.Lng.'),'name'=>$name.'[location][lng]','value'=>$value->location->lng ??'',"readonly" => $readonly])
        </div>
    </div>
</div>

@if(!$readonly && ($search_xy || $show_map) )
    <div class="px-2 pb-2 mt-2">  
        @if($search_xy)
            @button(['type'=>'button','style'=>'light','size'=>'sm','class'=>' search-button','name'=>'action','value'=>'location',"disabled" => $readonly])  @icon('search') @lang('vialer::vialer.Localitzar') @endbutton
        @endif
        @if($show_map)
            @button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'marker-button',"disabled" => $readonly]) @icon('plus') @lang('vialer::vialer.Afegir marcador') @endbutton
        @endif
    </div>
@endif    

