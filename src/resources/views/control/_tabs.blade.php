
@if($show_refcat || $show_xy)
    <div class="card-header" >
        @tabs(['align'=>'center','align'=>'left','class'=>'card-header-tabs'])
            @tab(['href'=>'#tab-via-'.$id,'active'=>true, 'persist'=>$id.'-vialer-tab'])
                @if($icon)
                    @icon($icon) 
                @endif
                @if($label)
                    {{ $label }}
                @else
                    @lang("vialer::vialer.Carrer")
                @endif

            @endtab
            @if($show_refcat)
                @tab(['href'=>'#tab-refcat-'.$id, 'persist'=>$id.'-vialer-tab'])
                    @lang("vialer::vialer.Ref.Cat.")
                @endtab
            @endif
            @if($show_xy)
                @tab(['href'=>'#tab-xy-'.$id, 'persist'=>$id.'-vialer-tab'])
                    @lang("vialer::vialer.Lat/Lng")
                @endtab
            @endif
        @endtabs
    </div>  
@else
    @if($label && $label!=__("vialer::vialer.Carrer"))
        <h5 class="field-title pt-3 pl-3 mb-0">
            @if($icon)
                @icon($icon) 
            @endif
            @if($label)
                {{ $label }}
            @else
                @lang("vialer::vialer.Carrer")
            @endif
        </h5>
    @endif
@endif

