@extends('layouts.grafico')


@section('content')




		<div class="border rounded m-2 row ">
			<div id="chartContainerConfirmadoDIA" style="height: 300px; width: 100%;"></div>
			<button class="btn col ml-2 mr-2 btn-primary " onclick="updateChart(11)">Ultimos 10 dias</button>
			<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(21)">Ultimos 20 dias</button>
			<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(31)">Ultimos 30 dias</button>
			<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(61)">Ultimos 60 dias</button>
			<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(91)">Ultimos 90 dias</button>
			<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(10000)">Todos os dias</button>
		
			
		</div>



	<script src="/js/canvasjs.min.js"></script>


	<script src="/covid/graficoConfirmadoDia.js"></script>

@endsection