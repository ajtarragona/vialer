<div id="vialer-search-results">
    @if($domicilis && $domicilis->count()>0)

    @if(is_numerero($domicilis))
        <div class="p-3 text-center">
            <h4>@lang("vialer::vialer.Sembla que l'adreça que busques no existeix.")</h4>
            <h5>@lang("vialer::vialer.Potser et refereixes a alguna d'aquestes?")</h5>
        </div>
    @endif

    <div class="table-responsive" style="max-height:80vh" >
        <table class="table table-striped mb-0 table-hover sticky-header" data-clickable="true"  data-numerero="{{ is_numerero($domicilis)?"true":"false" }}"> 
            {{-- data-selectable="true" data-select-single="true"  data-select-style="info"> --}}
            <thead>
                <tr>
                    {{-- <th width="20">&nbsp;</th> --}}
                    <th>@lang("vialer::vialer.Carrer")</th>
                    <th>@lang("vialer::vialer.Núm.")</th>
                    <th>@lang("vialer::vialer.Llet.")</th>
                    <th>@lang("vialer::vialer.Bloc")</th>
                    <th>@lang("vialer::vialer.Esc.")</th>
                    <th>@lang("vialer::vialer.Planta")</th>
                    <th>@lang("vialer::vialer.Porta")</th>
                    <th>@lang("vialer::vialer.Provincia")</th>
                    <th>@lang("vialer::vialer.Municipi")</th>
                    {{-- <th></th> --}}
                    {{-- <th>RC.</th> --}}
                    {{-- <th>XY</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($domicilis as $domicili)
                    <tr data-rc="{{$domicili->rc->completa}}" data-numero="{{$domicili->numero}}" data-url="#">
                        @if($domicili->rustic)
                            <td colspan="7">{{ $domicili->nomVia() }}</td>
                        @else
                            {{-- <td>
                            
                                @radio(['name'=>'item_ids','color'=>'info','value'=>$domicili->rc->completa,'class'=>'row-selector'])
                            </td> --}}
                            <td>{{ $domicili->nomVia() }}</td>
                            <td>{{ $domicili->numero }}</td>
                            <td>{{ $domicili->letra }}</td>
                            <td>{{ $domicili->bloque }}</td>
                            <td>{{ $domicili->escalera }}</td>
                            <td>{{ $domicili->planta }}</td>
                            <td>{{ $domicili->puerta }}</td>
                            {{-- <td>{{ $domicili->cadenaDomicili() }}</td> --}}
                            {{-- <td>{{ $domicili->rc->completa }}</td> --}}
                            {{-- <td>{{ $domicili->xy->lat }},{{ $domicili->xy->lng }}</td> --}}
                        @endif
                        <td>{{ $domicili->provincia }}</td>
                        <td>{{ $domicili->municipi }}</td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <div class="p-2 border-top">
        <button type=submit" class="btn btn-sm btn-secondary add-items-btn" href="#">@icon('check') Seleccionar marcat </button>
    </div> --}}
    @else
    <div class="p-3">
        <h4 class="text-center">@lang("vialer::vialer.Sembla que l'adreça que busques no existeix.")</h4>

        @alert(["style"=>'info','title'=>__("vialer::vialer.Recomanacions d'ús")])
            @lang('vialer::vialer.not_found_helptext')
        @endalert
    </div>
    @endif
</div>