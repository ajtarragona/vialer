<div class="card-header">
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
    <div class="clean-btn" {{$readonly?'hidden':''}} >
        @button(['type'=>'button','style'=>($color?$color:'light'),'size'=>'sm','class'=>' clear-button','name'=>'action','value'=>'clear','disabled'=>$readonly]) 
            @icon('eraser') 
            <span class="d-none d-md-inline-block">@lang("vialer::vialer.Netejar")</span>
        @endbutton
    </div>
</div>
