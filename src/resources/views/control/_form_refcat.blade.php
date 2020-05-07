
<div class="refcatform ">
    @input(['label'=>__('vialer::vialer.Ref.Cat.'),'name'=>$name.'[refcat]','value'=>$value->refcat??'',"readonly" => $readonly])
</div>

@if(!$readonly &&  ($search_refcat || $btn_parcela) )

	<div class="px-2 pb-2 mt-2">  
		@if($search_refcat)
			@button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'search-button','name'=>'action','value'=>'refcat',"disabled" => $readonly]) @icon('search') @lang('vialer::vialer.Localitzar') @endbutton
		@endif
		@if($btn_parcela)
			@button(['type'=>'button','style'=>'light','size'=>'sm','class'=>'refcat-button','disabled'=>true]) @icon('eye') @lang('vialer::vialer.Veure parcela') @endbutton
		@endif
	</div>
@endif