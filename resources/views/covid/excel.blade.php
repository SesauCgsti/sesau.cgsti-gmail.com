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
<div class=" alert-danger text-uppercase text-bold"> 
    atençao remova a primeira linha caso ela contenha os cabeçalhos

</div>
                    <form action="covid/upload/excel" method="post"
                    enctype="multipart/form-data" >
                @csrf
                <label for="excel">Excel</label>
                <input type="file" name="excel">
                <button type="submit">Enviar</button>
            </form>
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
