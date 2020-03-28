@extends('layouts.grafico')


@section('content')


<div class="border rounded m-2 ">
	
	<div id="chartContainerIdade" class="grafico" style="height: 300px; width: 100%;"></div>
</div>
<div>
	
	<script src="/js/canvasjs.min.js"></script>

	<script src="/covid/graficoIdade.js"></script>

@endsection