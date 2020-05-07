@include('vialer::control.__start')


    <div class="row no-gutters">
        <div class="col-sm-{{ $map_columns }}">
            @include('vialer::control._map')
        </div>
        <div class="col-sm-{{12 - $map_columns }}">
            @include('vialer::control._tabs')
            @include('vialer::control._tabcontent')
        </div>
    </div>

@include('vialer::control.__end')
