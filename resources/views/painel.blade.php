@extends('layouts.painel')
<style>
    img {
        width: 225px;
        height: 225px;
        align-self: center;

    }

    .card-header {
        padding: 2x !important;
    }

    .numero {
        font-size: 40px;
        margin-bottom: 2px;
    }

    .confirmado {
        color: #f3423d;
        -webkit-text-stroke: thick
    }

    .descartado {
        color: #2b711e;
        -webkit-text-stroke: thick
    }

    .excluido {
        color: #ff7905;
        -webkit-text-stroke: thick
    }

    .suspeito {
        color: #fbdd09;
        -webkit-text-stroke: thick
    }

    .total {
        -webkit-text-stroke: thick;
        color: white;
    }

    .bg-confirmado {
        background-color: black !important;


    }

    a {
        color: black !important;
    }


    /* .caixa-painel {

flex-grow: 0;
flex-shrink: 0;
flex-basis: 14.1857142857%;
max-width: 14.1857142857%%;
position: relative;
width: 100%;
min-height: 1px;
padding-right: 15px;
padding-left: 15px;
box-sizing: border-box;
} */

</style>

@section('content')
<div class="content">
    <div class=" justify-content-center">
        <div class="col-md-12">
            <div class="row">

                <div class=" caixa-painel col-sm-12 mb-1 border-dark   ">
                    <div class="card bg-confirmado text-capitalize text-center confirmado text-bold ">
                        <h5 class="mt-3 pb-3"> CONFIRMADO</h5>
                        <h4 class="numero"> {{$lista['confirmado']}}</h4>
                    </div>
                </div>

                <div class="caixa-painel col-sm-12 mb-1 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center text-warning suspeito  ">
                        <h5 class="mt-2  "> AGUARDANDO RESULTADO </h5>
                        <h4 class="numero " > {{$lista['suspeito']}}</h4>
                    </div>
                </div>
                <div class="caixa-painel col-sm-12 mb-1 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center text-warning suspeito  ">
                        <h5 class="mt-3 pb-3"> SUSPEITO </h5>
                        <h4 class="numero"> {{$lista['suspeitoSuspeito']}}</h4>
                    </div>
                </div>

                <div class="caixa-painel col-sm-12 mb-1 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center descartado  ">
                        <h5 class="mt-3 pb-3"> DESCARTADO</h5>

                        <h4 class="numero"> {{$lista['descartado']}}</h4>
                    </div>
                </div>
                <div class="caixa-painel col-sm-12 mb-1 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center excluido  ">
                        <h5 class="mt-3 pb-3"> EXCLUIDO</h5>

                        <h4 class="numero"> {{$lista['excluido']}}</h4>
                    </div>
                </div>
                <div class="caixa-painel col-sm-12 mb-1 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center text-secondary total   ">
                        <h5 class="mt-3 pb-3">OBITO</h5>

                        <h4 class="numero"> {{$lista['obito']}}</h4>
                    </div>
                </div>
                <div class="caixa-painel col-sm-12 mb-1 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center text-white total ">
                        <h5 class="mt-3 pb-3"> TOTAL</h5>
                        <h4 class="numero"> {{$lista['total']}}</h4>
                    </div>
                </div>
            </div>

            {{-- <div class="card-body"> --}}

            <div class="row">

                <div class="col-sm-12 col-md-4 mb-2">
                    <a target="_blank" href="{{ url('/covid/grafico/evolucaofiltro') }}">
                        <div class="card border-primary">
                            <div class="bg-primary">
                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS CONFIRMADOS /
                                    DIA</h5>
                            </div>

                            <div class="card-body pt-0 pb-0">
                                <div id="chartContainerConfirmado" style="height: 220px; width: 100%;"></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 mb-2">
                    <a target="_blank" href="{{ url('/covid/grafico/diario') }}">
                        <div class="card border-primary">
                            <div class="bg-primary">
                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS
                                    NOT./CONF./DESCART. DIARIOS</h5>
                            </div>

                            <div class="card-body pt-0 pb-0">

                                <div id="chartContainer" style="height: 220px; width: 100%;"></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 mb-2">
                    <a target="_blank" href="{{ url('/covid/grafico/somatorio') }}">
                        <div class="card border-primary">
                            <div class="bg-primary">
                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">TOTAL CASOS
                                    NOT./CONF./DESCART. </h5>
                            </div>

                            <div class="card-body pt-0 pb-0">

                                <div id="chartContainerSomatorio" style="height: 220px; width: 100%;"></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 mb-2">
                    <a target="_blank" href="{{ url('/covid/grafico/sexo') }}">
                        <div class="card border-primary">
                            <div class="bg-primary">
                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">TOTAL CASOS / SEXO
                                </h5>
                            </div>

                            <div class="card-body pt-0 pb-0">

                                <div id="chartContainerSexo" style="height: 220px; width: 100%;"></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 mb-2">
                    <a target="_blank" href="{{ url('/covid/grafico/idade') }}">
                        <div class="card border-primary">
                            <div class="bg-primary">
                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">TOTAL CASOS / IDADE
                                </h5>
                            </div>

                            <div class="card-body pt-0 pb-0">

                                <div id="chartContainerIdade" style="height: 220px; width: 100%;"></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 mb-2">
                    <a target="_blank" href="{{ url('/covid/mapa') }}">
                        <div class="card border-primary ">
                            <div class="bg-primary">
                                <h5 class="card-title mb-1 mt-1 text-uppercase text-bold text-white text-center">Mapa
                                    das notificações </h5>
                            </div>

                            <img src="images/mapa.png" alt="">

                        </div>
                    </a>
                </div>

                {{-- <div class="col-4 mb-2">
                            <a target="_blank" href="{{ url('covid/grafico/evolucaofiltro') }}">
                <div class="card border-primary">
                    <div class="bg-primary">
                        <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS CONFIRMADOS filtro</h4>
                    </div>

                    <div class="card-body pt-0 pb-0">
                        <div id="chartContainerConfirmadoDIA" style="height: 220px; width: 100%;"></div>
                    </div>
                </div>
                </a>
            </div> --}}


            {{-- </ div> --}}



        </div>
    </div>
</div>
</div>
<script src="/leaflet/axios.min.js"></script>
<script src="/js/canvasjs.min.js"></script>
<script src="/covid/home/grafico.js"></script>
<script src="/covid/home/graficoSomatorio.js"></script>
<script src="/covid/home/graficoConfirmado.js"></script>
{{-- <script src="/covid/home/graficoConfirmadoDia.js"></script> --}}
<script src="/covid/home/graficoSexo.js"></script>
<script src="/covid/home/graficoIdade.js"></script>

@endsection