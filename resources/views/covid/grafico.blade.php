<!DOCTYPE HTML>
<html>

<head>
	<script src="{{ asset('js/app.js') }}" defer></script>

	
	<script src="/leaflet/axios.min.js"></script>
	<script>


	</script>
</head>

<body>
	<div>
	<div id="chartContainer" style="height: 300px; width: 100%;"></div>
</div>
<div>
		<div id="chartContainerConfirmado" style="height: 300px; width: 100%;"></div>
	</div>
	<div>
		<button onclick="updateChart(11)">Ultimos 10 dias</button>
		<button onclick="updateChart(21)">Ultimos 20 dias</button>
		<button onclick="updateChart(31)">Ultimos 30 dias</button>
		<button onclick="updateChart(61)">Ultimos 60 dias</button>
		<button onclick="updateChart(91)">Ultimos 90 dias</button>
		<button onclick="updateChart(10000)">Todos os dias</button>

			<div id="chartContainerConfirmadoDIA" style="height: 300px; width: 100%;"></div>
		</div>
<div>
	<div id="chartContainerSomatorio" style="height: 300px; width: 100%;"></div>
</div>
<div>
		<div id="chartContainerSexo" style="height: 300px; width: 100%;"></div>
	</div>
	<div>
			<div id="chartContainerIdade" style="height: 300px; width: 100%;"></div>
		</div>
	<script src="/js/canvasjs.min.js"></script>
	
	<script src="/covid/grafico.js"></script>
	<script src="/covid/graficoConfirmado.js"></script>
	<script src="/covid/graficoConfirmadoDia.js"></script>
	<script src="/covid/graficoSomatorio.js"></script>
	<script src="/covid/graficoSexo.js"></script>

	{{-- <script src="/covid/graficoIdade.js"></script> --}}
</body>

</html>