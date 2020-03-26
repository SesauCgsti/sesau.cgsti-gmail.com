@extends('layouts.grafico')


@section('content')


<div class="border rounded m-2 ">

	<div id="chartContainerSexo" style="height: 300px; width: 100%;"></div>
</div>


<script src="/js/canvasjs.min.js"></script>

<script src="/covid/graficoSexo.js"></script>

@endsection