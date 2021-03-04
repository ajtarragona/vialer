
    @tabcontent(['class'=>'bg-white pt-2'])
        
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
