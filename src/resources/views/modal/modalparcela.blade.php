@extends('ajtarragona-web-components::layout/modal')

@section('id','modal-parcela')

@section('title', $refcat )


@section('body')
	
<div class="embed-responsive embed-responsive-4by3">
    <iframe class="embed-responsive-item" src="https://www1.sedecatastro.gob.es/Cartografia/mapa.aspx?refcat={{$refcat}}"></iframe>
</div>
@endsection


