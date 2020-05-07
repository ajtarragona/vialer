@extends('ajtarragona-web-components::layout/modal')

@section('id','modal-seearch-vialer')

@section('title', __("vialer::vialer.Buscador al vialer") )


@section('body')
   
    @include('vialer::modal._form')
    @include('vialer::modal._domicilis-table')

   
@endsection


