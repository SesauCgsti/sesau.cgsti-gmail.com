@extends('layouts.grafico')


@section('content')


<div class="border rounded m-2 ">

	<div id="chartContainerConfirmado" style="height: 400px; width: 100%;"></div>
</div>

<script src="/js/canvasjs.min.js"></script>
<script src="/covid/graficoConfirmado.js"></script>

@endsection