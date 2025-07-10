<div class="position-relative " style="overflow-x: auto;overflow-y: hidden;">
        
    @tabcontent(['class'=>'bg-white '.(($show_refcat || $show_xy)?'pt-2':'')])
        
        @tabpane(['active'=>true,'id'=>'tab-via-'.$id,'persist'=>$id.'-vialer-tab'])
            @include('vialer::control._form_via')
        @endtabpane
        
        {{-- @if($show_refcat) --}}
            @tabpane(['id'=>'tab-refcat-'.$id,'persist'=>$id.'-vialer-tab'])
                @include('vialer::control._form_refcat')
            @endtabpane
        {{-- @endif --}}
        
        {{-- @if($show_xy) --}}
            @tabpane(['id'=>'tab-xy-'.$id,'persist'=>$id.'-vialer-tab'])
                @include('vialer::control._form_xy')
            @endtabpane
        {{-- @endif --}}
    @endtabcontent
    {{-- {{$btn_clear}} --}}
    @if($btn_clear)
        <div class="clean-btn" {{$readonly?'hidden':''}} >
            @button(['type'=>'button','style'=>($color?$color:'light'),'size'=>'sm','class'=>' clear-button','name'=>'action','value'=>'clear','disabled'=>$readonly]) 
                @icon('eraser') 
                <span class="d-none d-md-inline-block">@lang("vialer::vialer.Netejar")</span>
            @endbutton
        </div>
    @endif
</div>