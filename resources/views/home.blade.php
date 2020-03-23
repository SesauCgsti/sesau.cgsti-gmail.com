@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Menu</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (auth()->user()->admin)
                        
   
<div class=" alert-danger text-uppercase text-bold"> 
<li>   atençao remova a primeira linha caso ela contenha os cabeçalhos</li> 
<li>
    Formate o campo data para ficar como texto
</li>

<li>
        Excel tem q ser no formato .xlsx
    </li>
</div>

                    <form action="covid/upload/excel" method="post"
                    enctype="multipart/form-data" >
                @csrf
                <label for="excel">Excel</label>
                <input type="file" name="excel">
                <button type="submit">Enviar</button>
            </form>
                </div>

                <a class="btn btn-success" target="_blank" href="{{ url('/covid/cep') }}">Ver lista de ceps não carregados </a>
                @endif
                <div class="card-body">
                  <h3>
                    <ul>
                        <li>
                    <a target="_blank" href="{{ url('/covid/mapa') }}">Mapa das notificações geral (TELA CHEIA)</a>
                </li>
                <li>
                    <a target="_blank" href="{{ url('/covid/grafico/diario') }}">Casos diário de notificaçoes e casos confirmados</a>
                </li>
                <li>
                    <a target="_blank" href="{{ url('/covid/grafico/somatorio') }}">Casos somados de notificaçoes e casos confirmados </a>
                </li>
                <li>
                    <a target="_blank" href="{{ url('/covid/grafico/sexo') }}">Casos Confirmados por Sexo (somado) </a>
                </li>
                <li>
                    <a target="_blank" href="{{ url('/covid/grafico/evolucao') }}">Evolução dos casos (somado) </a>

                </li>
                <li>
                    <a target="_blank" href="{{ url('/covid/grafico/evolucaofiltro') }}">Evolução confirmados filtro de dias</a>
                </li>
                <li>
                    <a target="_blank" href="{{ url('/covid/grafico/') }}">Todos gráficos</a>
               
                </ul>
            </h3>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
