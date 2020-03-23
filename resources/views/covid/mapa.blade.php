<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="/leaflet/leaflet.css" />
    <link rel="stylesheet" href="/leaflet/leaflet-search.css" />
    <script src="/leaflet/jquery.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
      body {
        padding: 0;
        margin: 0;
      }
      html, body, #map {
        height: 100%;
      }
      .imbirussu{
        color:yellow
      }
      .lagoa{
        color:blue
      }
      .segredo{
        color: red
      }
      .bandeira{
        color: green;
        font-size: 56;
      }
      div.circle {
    background-color: #ff7800;
    border-color: black;
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    width:50px;
    height:50px;
}

td >img{
  width: 25px;
  height: 25px;
}
td,th{
  
  text-align: center;
  border-color: black;
  border-style: solid;
  border-width: 2px;
  margin: 1px;
  padding: 2px;
}

#textbox {
  position: absolute;
  top: 400px;
  left: 50px;
  width: 275px;
  height: 100px;
}
.confirmado{
border-style: double;
border-top-color: red;
border-width:3px;
border-bottom:none;
border-left:none;
border-right:none;
}
.notificado{
border-style: double;
border-bottom-color: black;
border-top:none;
border-left:none;
border-right:none;
border-width:3px;

}

.descartado{
border-style: double;
border-left-color: green;
border-top:none;
border-bottom:none;
border-right-color:green;

border-width:3px;

}



#textbox text p {
  font-family: Arial, Helvetica;
  font-size: .8em;
  margin: 0;
}

    </style>

<link rel="stylesheet" href="/leaflet/leafletnew.css" />
  </head>
  <body>
      <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></!--> 
 <div class="row">
 <div class="col">
        <label class="btn " for="">Inicio</label>
      <input type="date" name="inicio" id="inicio">
      <label class="btn" for="">Fim</label>
      <input type="date" name="fim" id="fim">
<button type="submit" id="btn-form" onclick="buscaNotificacoes()" class="btn btn-primary" >Enviar</button>

</div>
<div class="col">


  <table style="" >
    <thead>
    <th>SUSPEITO</th>
    <th>CONFIRMADO</th>
    <th>DESCARTADO</th>
    <th>NÃO LOCALIZADO</th>
    <th>TOTAL</th>
    </thead>
    <tbody>
      <tr>
        <td><img class="notificado" src="/images/covid.png" alt="" srcset=""> <span id="t_not"> 0</span></td>
        <td><img class="confirmado" src="/images/COVID_CONFIRMADO.png" alt="" srcset=""> <span id="t_conf"> 0</span></td>
        <td> <img class="descartado" src="/images/covid.png" alt="" srcset=""> <span id="t_desc">0</span></td>
        <td> <span id="t_nao">0</span></td>
        <td> <span id="t_total">0</span></td>
      </tr>
    </tbody>


  </table>

</div>
</div>
      

     
    <div id="textbox"></div>
    <div id="map"></div>


    <divcontrol></divcontrol>


    <script src="/leaflet/axios.min.js"></script>
    <script src="/leaflet/leafletnew.js"></script>

    <script src="/leaflet/leaflet-search.js"></script>

    <script>


      var initialCoordinates = [-20.4603006, -54.6015407]; // Campo Grande
      var initialZoomLevel = 12;
      
      // create a map in the "map" div, set the view to a given place and zoom
      var map = L.map('map',
          //{ layers: [grayscale, cities]}
      ).setView(initialCoordinates, initialZoomLevel);
      </script>
      
    <!-- <script src="bd.js"></script> -->
  
  <!-- <script src="unidadeteste.js"></script>  -->
    <!-- ARRy de equipes -->
    <!-- <script src="equipes.js"></script> -->


    <script src="/covid/camadasControl.js"></script>

      <script src="/covid/covid.js"></script>
  </body>
</html>