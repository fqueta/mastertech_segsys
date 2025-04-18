<div class="col-md-12 d-print-none">
    <div class="card">
        <form action="" id="frm-consulta" method="GET">
            @if (isset($anos))
                {{-- Inicio painel filtro ano --}}
                <div class="row mt-3">
                    <div class="col-md-12 mb-2 ml-2">
                        @include('qlib.filtro_ano',['arr_ano'=>@$anos,'form'=>false,'onclick'=>"$('#frm-consulta').submit();$('#preload').css('display','block')"])
                    </div>
                </div>
                {{-- Fim painel filtro ano --}}
            @endif

            <div class="row mr-0 ml-0">
                {{-- <div class="col-md-2 pt-4 pl-2">
                    <a class="btn @if(isset($_GET['filter'])) btn-link @else btn-default @endif" data-toggle="collapse" href="#busca-id" aria-expanded="false" aria-controls="busca-id">
                        <i class="fas fa-search-location    "></i> @if(isset($_GET['filter'])) Mostrar Critérios de pesquisa @else Pesquisar @endif
                    </a>
                </div> --}}
                {{App\Qlib\Qlib::qForm([
                    'type'=>'select',
                    'campo'=>'limit',
                    'placeholder'=>'',
                    'label'=>'Por página',
                    'ac'=>'alt',
                    'value'=>@$config['limit'],
                    'tam'=>'2',
                    'arr_opc'=>['20'=>'20','50'=>'50','100'=>'100','200'=>'200','500'=>'500','todos'=>'Todos'],
                    'event'=>'onchange=$(\'#frm-consulta\').submit();',
                    'option_select'=>false,
                    'class'=>'text-center',
                    'class_div'=>'text-center',
                ])}}
                {{App\Qlib\Qlib::qForm([
                    'type'=>'radio',
                    'campo'=>'order',
                    'placeholder'=>'',
                    'label'=>false,
                    'ac'=>'alt',
                    'value'=>@$config['order'],
                    'tam'=>'6',
                    'arr_opc'=>['asc'=>'Ordem crescente','desc'=>'Ordem decrescente'],
                    'event'=>'order=true',
                    'class'=>'btn btn-light',
                    'option_select'=>false,
                    'class_div'=>'pt-4 text-right',
                ])}}
                @can('create',$routa)

                <div class="col-md-2 text-right mt-4">
                    @php
                        $r_create = route( $routa.'.create');
                        // if($routa=='leiloes_adm'){
                        //     $r_create = route('quick.add.leilao');
                        // }
                    @endphp
                    <a href="{{ $r_create }}" class="btn btn-success btn-block">
                        <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Cadastrar') }}
                    </a>
                </div>
                @endcan
                <div class="col-md-2 text-right mt-4">
                    <a href="javascript:clica_consulta_cliente()" class="btn btn-warning btn-block">
                        <i class="fas fa-search-location"></i> {{ __('Pesquisar') }}
                    </a>
                </div>
                <div class="collapse" id="busca-id">
                    @if ($routa=='clientes')
                        @include('clientes.busca')
                    @else
                        @include('qlib.busca')
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
