<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            img{
                width: 200px;
                height: 200px;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .login > a {
                color: #636b6f;
                padding: 10 25px;
                font-size: 25px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Entrar</a>
                    @else
                        <a href="{{ route('login') }}">Entrar</a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class=" m-b-md">
                        <a target="_blank" href="{{ url('/painel') }}">
                    <img src="images/web.png" alt=""> 
                        </a>
                    <div class="login ">
                  
                <a target="_blank" href="{{ url('/painel') }}">Visualizar painel</a>
     

                    </div>
                      <div class="title">
                            Notifica Campo Grande
                          </div> 
                </div>

                <div class="links">
                    <a target="_blank" href="http://www.campogrande.ms.gov.br/sesau/covid19/">Página covid-19 PMCG</a>
                  
                   
                        @auth
                            <a  href="{{ url('/home') }}">Carregar Dados</a>
                            <a target="_blank" href="{{ url('/painel') }}">Visualizar painel</a>
                            <a target="_blank" href="{{ url('/painel') }}">Visualizar MAPA</a>
                        @else
                        <a href="{{ route('login') }}">Login</a>
                        <a target="_blank" href="{{ url('/painel') }}">Visualizar painel</a>
                        <a target="_blank" href="{{ url('/covid/mapaAgrupado') }}">VISUALIZAR MAPA</a>
 
    
                            {{-- @if (Route::has('registloginer'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif --}}
                        @endauth
                   
               
                
                </div>
            </div>
        </div>
    </body>
</html>
