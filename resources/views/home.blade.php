@extends('layouts.app')
<style>
    img {
        width: 150px;
        height: 150px;
        align-self: center;

    }

    .card-header {
        padding: 2x !important;
    }

    .numero {
        font-size: 40px;
    }

    .confirmado {
        color: #f3423d;
        -webkit-text-stroke: thick
    }

    .descartado {
        color: #2b711e;
        -webkit-text-stroke: thick
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
                   
                        <div class="col-2 mb-3 border-dark  ">
                            <div class="card  bg-confirmado text-capitalize text-center confirmado text-bold ">
                                <h4 class="mt-3 pb-3"> CONFIRMADO</h4>
                            <h3 class="numero"> {{$lista['confirmado']}}</h3>
                            </div>
                        </div>
        
                        <div class="col-2 mb-3 border-dark  ">
                                <div class="card  bg-confirmado text-capitalize text-center text-warning suspeito  ">
                                    <h4 class="mt-1"> AGUARDANDO RESULTADO </h4>
                                    <h3 class="numero"> {{$lista['suspeito']}}</h3>
                                </div>
                            </div>
        
                            <div class="col-2 mb-3 border-dark  ">
                                    <div class="card  bg-confirmado text-capitalize text-center descartado  ">
                                        <h4 class="mt-3 pb-3"> DESCARTADO</h4>
           
                                        <h3 class="numero"> {{$lista['descartado']}}</h3>
                                    </div>
                                </div>
                                <div class="col-2 mb-3 border-dark  ">
                                        <div class="card  bg-confirmado text-capitalize text-center excluido  ">
                                            <h4 class="mt-3 pb-3"> EXCLUIDO</h4>
               
                                            <h3 class="numero"> {{$lista['excluido']}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-3 border-dark  ">
                                            <div class="card  bg-confirmado text-capitalize text-center text-secondary total   ">
                                                <h4 class="mt-3 pb-3">OBITO</h4>
                   
                                                <h3 class="numero"> {{$lista['obito']}}</h3>
                                            </div>
                                        </div>
                                <div class="col-2 mb-3 border-dark  ">
                                        <div class="card  bg-confirmado text-capitalize text-center text-white total ">
                                                <h4 class="mt-3 pb-3"> TOTAL</h4>
                                            <h3 class="numero"> {{$lista['total']}}</h3>
                                        </div>
                                    </div>
                    </div>
        

            <div class="card ">
                <div class="card-header">Menu</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (auth()->user()->admin)


                    <div class=" alert-danger text-uppercase text-bold">
                        <li> atençao remova a primeira linha caso ela contenha os cabeçalhos</li>
                        <li>
                            Formate o campo data para ficar como texto
                        </li>

                        <li>
                            Excel tem q ser no formato .xlsx
                        </li>
                    </div>

                    <form action="covid/upload/excel" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="excel">Excel</label>
                        <input type="file" name="excel">
                        <button type="submit">Enviar</button>
                    </form>
                </div>

                <a class="btn btn-success" target="_blank" href="{{ url('/covid/cep') }}">Ver lista de ceps não
                    carregados </a>
                @endif
                <div class="card-body">


                    <h3>
                        <ul>
                            <li>

                                <a target="_blank" href="{{ url('/covid/mapa') }}">Mapa das notificações geral (TELA
                                    CHEIA)</a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ url('/covid/grafico/diario') }}">Casos diário de
                                    notificaçoes e
                                    casos confirmados</a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ url('/covid/grafico/somatorio') }}">Casos somados de
                                    notificaçoes e casos confirmados </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ url('/covid/grafico/sexo') }}">Casos Confirmados por Sexo
                                    (somado) </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ url('/covid/grafico/evolucao') }}">Evolução dos casos
                                    (somado)
                                </a>

                            </li>
                            <li>
                                <a target="_blank" href="{{ url('/covid/grafico/evolucaofiltro') }}">Evolução
                                    confirmados
                                    filtro de dias</a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ url('/covid/grafico/') }}">Todos gráficos</a>

                        </ul>
                    </h3>
                </div>

                {{-- <div class="card-body"> --}}
               
            </div>
        </div>
    </div>
    <script src="/leaflet/axios.min.js"></script>
    <script src="/js/canvasjs.min.js"></script>
    <script src="/covid/home/grafico.js"></script>
    <script src="/covid/home/graficoSomatorio.js"></script>
    <script src="/covid/home/graficoConfirmado.js"></script>
    <script src="/covid/home/graficoSexo.js"></script>
    @endsection