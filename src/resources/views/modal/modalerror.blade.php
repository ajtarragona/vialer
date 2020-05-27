@extends('ajtarragona-web-components::layout/modal')

@section('id','modal-seearch-vialer')

@section('title', __("vialer::vialer.Error") )


@section('body')
   
    @alert(['class'=>'m-3','type'=>'danger', 'title'=>__("vialer::vialer.Error") ])
        {!! $error ?? __("vialer::vialer.Error desconegut") !!}
    @endalert
@endsection


