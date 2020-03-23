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
                    <div class=" alert-warnning text-uppercase text-bold">
                          os dados são processados de 10 em 10 requisiçoes atualize ate terminar o processo;
    
                        </div>
                    <div class=" alert-danger text-uppercase text-bold">
                        atençao existem {{$contador}} ceps não mapeados aperte para reprocessar e aguarde o resultado <a
                            class="btn btn-primary" href="/covid/cep"> PROCESSSAR</a>

                    </div>
                    <div class="card-body">
<label for="">Lista de ceps nao encontrados</label>
                            <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">CEP</th>
                                        <th scope="col">BAIRRO</th>
                                        <th scope="col">MUNICIPIO</th>
                                        <th scope="col">DATA COLETA</th>
                                        <th scope="col">SEXO</th>
                                        <th scope="col">IDADE</th>
                                        <th scope="col">BUSCA</th>
                       

                                      </tr>
                                    </thead>
                                    <tbody>
                                      
                                          @foreach ($notificacoes as $notificao)
                                          <tr>
                                              
                                         
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$notificao->cep}}</td>
                                        <td>{{$notificao->bairro}}</td>
                                        <td>{{$notificao->municipio}}</td>
                                        <td>{{$notificao->dt_coleta}}</td>
                                        <td>{{$notificao->sexo}}</td>
                                        <td>{{$notificao->idade}}</td>
                                        <td>{{$notificao->consultacep?'SIM':'NÃO'}}</td>

                                    
                                      </tr>
                                      @endforeach
                                    
                                    </tbody>
                                  </table>

                           
        
                        </div>
                   
                </div>

                <div class="card-body">

                    <a target="_blank" href="{{ url('/covid/mapa') }}"></a>

                    <a target="_blank" href="{{ url('/covid/mapa') }}">Mapa das notificações geral (TELA CHEIA)</a>

                </div>



            </div>
        </div>
    </div>
</div>
@endsection