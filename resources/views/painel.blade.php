@extends('layouts.painel')
<style>
    img {
        width: 150px;
        height: 150px;
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
    .suspeito{
        color:#fbdd09;
        -webkit-text-stroke:thick
    }
    .total{
        -webkit-text-stroke:thick
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
                   
                <div class="col-3 mb-3 border-dark  ">
                    <div class="card  bg-confirmado text-capitalize text-center confirmado text-bold ">
                        <h3 class="mt-3"> CONFIRMADOS</h3>
                    <h3 class="numero"> {{$lista['confirmado']}}</h3>
                    </div>
                </div>

                <div class="col-3 mb-3 border-dark  ">
                        <div class="card  bg-confirmado text-capitalize text-center text-warning suspeito  ">
                            <h3 class="mt-3"> SUSPEITOS</h3>
                            <h3 class="numero"> {{$lista['suspeito']}}</h3>
                        </div>
                    </div>

                    <div class="col-3 mb-3 border-dark  ">
                            <div class="card  bg-confirmado text-capitalize text-center descartado  ">
                                <h3 class="mt-3"> DESCARTADOS</h3>
   
                                <h3 class="numero"> {{$lista['descartado']}}</h3>
                            </div>
                        </div>
                        <div class="col-3 mb-3 border-dark  ">
                                <div class="card  bg-confirmado text-capitalize text-center text-white  ">
                                    <h3 class="mt-3"> TOTAL</h3>
                                    <h3 class="numero"> {{$lista['total']}}</h3>
                                </div>
                            </div>
            </div>

            {{-- <div class="card-body"> --}}

                    <div class="row">
                  
                    <div class="col-4 mb-3">
                            <a target="_blank" href="{{ url('/covid/grafico/confirmado') }}">
                                <div class="card border-primary">
                                        <div class="bg-primary">
                                                <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS CONFIRMADOS</h4>
                                            </div>                       
                                    
                                    <div class="card-body pt-0 pb-0">
                                        	<div id="chartContainerConfirmado" style="height: 220px; width: 100%;"></div>
                                    </div>
                                </div>
                            </a>
                    </div>
                   
                    <div class="col-4 mb-3">
                            <a target="_blank" href="{{ url('/covid/grafico/diario') }}">
                                <div class="card border-primary">
                                        <div class="bg-primary">
                                                <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS DIARIOS</h4>
                                            </div>                       
                                    
                                    <div class="card-body pt-0 pb-0">

                                        	<div id="chartContainer" style="height: 220px; width: 100%;"></div>
                                    </div>
                                </div>
                            </a>
                    </div>

                    <div class="col-4 mb-3">
                            <a target="_blank" href="{{ url('/covid/grafico/somatorio') }}">
                                <div class="card border-primary">
                                        <div class="bg-primary">
                                                <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS SOMADOS</h4>
                                            </div>                       
                                    
                                    <div class="card-body pt-0 pb-0">

                                        	<div id="chartContainerSomatorio" style="height: 220px; width: 100%;"></div>
                                    </div>
                                </div>
                            </a>
                    </div>

                    <div class="col-4 mb-3">
                            <a target="_blank" href="{{ url('/covid/grafico/sexo') }}">
                                <div class="card border-primary">
                                        <div class="bg-primary">
                                                <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS SEXO</h4>
                                            </div>                       
                                    
                                    <div class="card-body pt-0 pb-0">

                                        	<div id="chartContainerSexo" style="height: 220px; width: 100%;"></div>
                                    </div>
                                </div>
                            </a>
                    </div>

                    <div class="col-4 mb-3">
                            <a target="_blank" href="{{ url('/covid/grafico/idade') }}">
                                <div class="card border-primary">
                                        <div class="bg-primary">
                                                <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">CASOS IDADE</h4>
                                            </div>                       
                                    
                                    <div class="card-body pt-0 pb-0">

                                        	<div id="chartContainerIdade" style="height: 220px; width: 100%;"></div>
                                    </div>
                                </div>
                            </a>
                    </div>

                    <div class="col-4 mb-3">
                            <a target="_blank" href="{{ url('/covid/mapa') }}">
                                <div class="card border-primary ">
                                    <div class="bg-primary">
                                            <h4 class="card-title mb-1 mt-1 text-bold text-white text-center">Mapa das notificações </h4>
                                    </div>

                                    <img src="images/mapa.png" alt="">
                                    <div class="card-body pt-0 pb-0">

                                        <p class="card-text">Possivel visualizar as notificaçoes por status de acordo
                                            com o cep fornecido identificando o centro da rua</p>
                                       
                                    </div>
                                </div>
                            </a>
                    </div>

                    <div class="col-4 mb-3">
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
                    </div>


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