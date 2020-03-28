@extends('layouts.painel')
<style>
    img {
        width: 225px;
        height: 225px;
        align-self: center;

    }

.card-header{
    padding: 2x !important;
}

    .numero {
        font-size: 40px;
    }

    .confirmado {
        color: #f3423d;
        -webkit-text-stroke:thick
    }
    .descartado{
        color: #2b711e;
        -webkit-text-stroke:thick
    }
    .excluido{
        color: #ff7905;
        -webkit-text-stroke:thick
    }
    .suspeito{
        color:#fbdd09;
        -webkit-text-stroke:thick
    }
    .total{
        -webkit-text-stroke:thick;
        color:white;
    }

    .bg-confirmado {
        background-color: black !important;
 
 
    }

    a {
        color: black !important;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                   
                <div class="col-sm-12 col-md-2 mb-3 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center confirmado text-bold ">
                        <h4 class="mt-3 pb-3"> CONFIRMADO</h4>
                    <h3 class="numero"> {{$lista['confirmado']}}</h3>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2 mb-3 border-dark  ">
                        <div class="card  bg-confirmado text-capitalize text-center text-warning suspeito  ">
                            <h4 class="mt-1"> AGUARDANDO RESULTADO </h4>
                            <h3 class="numero"> {{$lista['suspeito']}}</h3>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2 mb-3 border-dark  ">
                            <div class="card  bg-confirmado text-capitalize text-center descartado  ">
                                <h4 class="mt-3 pb-3"> DESCARTADO</h4>
   
                                <h3 class="numero"> {{$lista['descartado']}}</h3>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2 mb-3 border-dark  ">
                                <div class="card  bg-confirmado text-capitalize text-center excluido  ">
                                    <h4 class="mt-3 pb-3"> EXCLUIDO</h4>
       
                                    <h3 class="numero"> {{$lista['excluido']}}</h3>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 mb-3 border-dark  ">
                                    <div class="card  bg-confirmado text-capitalize text-center text-secondary total   ">
                                        <h4 class="mt-3 pb-3">OBITO</h4>
           
                                        <h3 class="numero"> {{$lista['obito']}}</h3>
                                    </div>
                                </div>
                        <div class="col-sm-12 col-md-2 mb-3 border-dark  ">
                                <div class="card  bg-confirmado text-capitalize text-center text-white total ">
                                        <h4 class="mt-3 pb-3"> TOTAL</h4>
                                    <h3 class="numero"> {{$lista['total']}}</h3>
                                </div>
                            </div>
            </div>

            {{-- <div class="card-body"> --}}

                    <div class="row">
                  
                    <div class="col-sm-12 col-md-4 mb-2">
                            <a target="_blank" href="{{ url('/covid/grafico/confirmado') }}">
                                <div class="card border-primary">
                                        <div class="bg-primary">
                                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS CONFIRMADOS / DIA</h5>
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
                                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS NOT./CONF./DESCART. DIARIOS</h5>
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
                                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">TOTAL CASOS NOT./CONF./DESCART. </h5>
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
                                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">TOTAL CASOS / SEXO</h5>
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
                                                <h5 class="card-title mb-1 mt-1 text-bold text-white text-center">TOTAL CASOS / IDADE</h5>
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
                                            <h5 class="card-title mb-1 mt-1 text-uppercase text-bold text-white text-center">Mapa das notificações </h5>
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
    <script src="/covid/home/graficoConfirmadoDia.js"></script>
    <script src="/covid/home/graficoSexo.js"></script>
    <script src="/covid/home/graficoIdade.js"></script>

@endsection