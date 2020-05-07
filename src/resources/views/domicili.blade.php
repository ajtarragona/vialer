@extends('ajtarragona-web-components::layout/master')

@section('title')
	@lang('Vialer')
@endsection


@section('body')

    <div class="container-fluid"    >

        <div class="row pt-3">
            <div class="col-3">
                
                @include('vialer::_form')

            </div>
            <div class="col-9">
                {{ $domicili->cadenaDomicili() }}
                <br>
                {{ $domicili->xy->lat }},{{ $domicili->xy->lng }}
                <br>
                {{ $domicili->rc->completa }}
                
            </div>

        </div>

    </div>	

@endsection