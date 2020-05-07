<div class="card-header">
    @tabs(['align'=>'center','align'=>'left','class'=>'card-header-tabs'])
        @tab(['href'=>'#tab-via-'.$name,'active'=>true, 'persist'=>$name.'-vialer-tab'])
            @lang("vialer::vialer.Carrer")
        @endtab
        @if($show_refcat)
            @tab(['href'=>'#tab-refcat-'.$name, 'persist'=>$name.'-vialer-tab'])
                @lang("vialer::vialer.Ref.Cat.")
            @endtab
        @endif
        @if($show_xy)
            @tab(['href'=>'#tab-xy-'.$name, 'persist'=>$name.'-vialer-tab'])
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
