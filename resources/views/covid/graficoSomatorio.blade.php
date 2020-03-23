<!DOCTYPE HTML>
<html>

<head>
	<script src="{{ asset('js/app.js') }}" defer></script>

	
	<script src="/leaflet/axios.min.js"></script>
	<script>


function formatarData(data){

return	new Date(data.split('-')[0],data.split('-')[1]-1,data.split('-')[2],0,0,0)
}

		async	function carregarGrafico(dados){
	console.log(dados)

	
// var x=	new Date("2020-02-25T00:00:00.000000Z");
// console.log(x)

// var day = moment("2020-02-25").;
// console.log(day);

descartados= await dados.descartados;
dataini=descartados[0].data;
datafim=descartados[descartados.length-1].data;
descartados
var dataPointsDescartados=[];
var dataPointsNotificados=[];
var dataPointsConfirmados=[];





dataPointsDescartados=dados.descartados.map(element=>{
	return { x:formatarData(element.data), y:element.total }
})			 

dataPointsConfirmados=dados.confirmados.map(element=>{
	return { x:formatarData(element.data), y:element.total }
})			 

dataPointsNotificados=dados.notificados.map(element=>{
	return { x:formatarData(element.data), y:element.total }
})			 

datainicio=formatarData(dataini).toLocaleDateString();
//datainicio='dois';


datafim  = formatarData(datafim).toLocaleDateString();



		 var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: `CASOS NOTIFICADOS CAMPO GRANDE ${datainicio} a ${datafim} ( ${dados.total[0].total} )`
	},
	axisX: {
		valueFormatString: "DD/MM/YYYY"
	},
	axisY2: {
		title: "CASOS",
	//	prefix: "$",
	//	suffix: "K"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "top",
		horizontalAlign: "center",
		dockInsidePlotArea: true,
		itemclick: toogleDataSeries
	},
	data: [
	
		{
		type: "line",
		axisYType: "secondary",
		name: `NOTIFICADOS ( ${dados.total[0].t_notificado} )`,
		showInLegend: true,
		markerSize: 0,
	
		dataPoints: dataPointsNotificados
	},

	{
		type: "line",
		axisYType: "secondary",
		name: `CONFIRMADOS ( ${dados.total[0].t_confirmado} )`,
		showInLegend: true,
		markerSize: 0,
	
		dataPoints: dataPointsConfirmados
	},
	{
		type: "line",
		axisYType: "secondary",
		name: `DESCARTADOS ( ${dados.total[0].t_descartado } )`,
		showInLegend: true,
		markerSize: 0,
	
		dataPoints: dataPointsDescartados
	},
	
]
});
chart.render();

function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	chart.render();
}



}
	</script>
</head>

<body>
	<div id="chartContainer" style="height: 300px; width: 100%;"></div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="/covid/graficoSomatorio.js"></script>
</body>

</html>