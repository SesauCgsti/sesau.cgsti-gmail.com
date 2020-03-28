@extends('layouts.grafico')


@section('content')


<div class="border rounded m-2 mb-5 ">

	<div id="chartContainer" style="height: 300px; width: 100%;"></div>
</div>
<div class="border rounded m-2 mb-5 ">
	<div id="chartContainerConfirmado" style="height: 300px; width: 100%;"></div>
</div>
<div class="border rounded m-2 row mb-5 ">
		<div id="chartContainerConfirmadoDIA" style="height: 300px; width: 100%;"></div>
	<button class="btn col ml-2 mr-2 btn-primary " onclick="updateChart(11)">Ultimos 10 dias</button>
	<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(21)">Ultimos 20 dias</button>
	<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(31)">Ultimos 30 dias</button>
	<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(61)">Ultimos 60 dias</button>
	<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(91)">Ultimos 90 dias</button>
	<button class="btn col ml-2 mr-2 btn-primary" onclick="updateChart(10000)">Todos os dias</button>

	
</div>
<div class="border rounded m-2 mb-5 ">
	<div id="chartContainerSomatorio" style="height: 300px; width: 100%;"></div>
</div>
<div class="border rounded m-2 mb-5 ">
	<div id="chartContainerSexo" style="height: 300px; width: 100%;"></div>
</div>
<div class="border rounded m-2 mb-5 ">
	<div id="chartContainerIdade" style="height: 300px; width: 100%;"></div>
</div>

<script src="/js/canvasjs.min.js"></script>

<script src="/covid/grafico.js"></script>
<script src="/covid/graficoConfirmado.js"></script>
<script src="/covid/graficoConfirmadoDia.js"></script>
<script src="/covid/graficoSomatorio.js"></script>
<script src="/covid/graficoSexo.js"></script>

<script src="/covid/graficoIdade.js"></script>

@endsection