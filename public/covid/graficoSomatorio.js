
var carrega = false
buscaNotificacoesSomatorio();
var t_not = 0;
var t_conf = 0;
var t_desc = 0;
var t_total = 0;
//função para buscar as informaçoes dos dados
async function buscaNotificacoesSomatorio() {
 

    await axios.get('/covid/casosDiariosSomatorio', {
    //    params: { inicio, fim }
    })
        .then(response => {
            console.log(response)
            carregarGraficoSomatorio(response.data)
          
        })
        .catch(error => {

        })

}


function formatarData(data){

    return	new Date(data.split('-')[0],data.split('-')[1]-1,data.split('-')[2],0,0,0)
    }
    
            async	function carregarGraficoSomatorio(dados){
        console.log(dados)
    
        
    // var x=	new Date("2020-02-25T00:00:00.000000Z");
    // console.log(x)
    
    // var day = moment("2020-02-25").;
    // console.log(day);
    
    descartados= await dados.descartados;
    dataini=descartados[0].data;
    datafim=descartados[descartados.length-1].data;
    descartados
    var dataPointsDescartados = [];
    var dataPointsNotificados = [];
    var dataPointsConfirmados = [];
    var dataPointsObitos = [];
    var dataPointsExcluidos = [];
    
                
    
    
    dataPointsDescartados=dados.descartados.map(element=>{
        return { x:formatarData(element.data), y:element.total }
    })			 
    
    dataPointsConfirmados=dados.confirmados.map(element=>{
        return { x:formatarData(element.data), y:element.total }
    })			 
    
    dataPointsNotificados=dados.notificados.map(element=>{
        return { x:formatarData(element.data), y:element.total }
    })			
    dataPointsObitos = dados.obitos.map(element => {
        return { x: formatarData(element.data), y: element.total }
    })

    dataPointsExcluidos = dados.excluidos.map(element => {
        return { x: formatarData(element.data), y: element.total }
    })            
    
    datainicio=formatarData(dataini).toLocaleDateString();
    //datainicio='dois';
    
    
    datafim  = formatarData(datafim).toLocaleDateString();
    
    
    
             var chart = new CanvasJS.Chart("chartContainerSomatorio", {
        title: {
            text: `CASOS CAMPO GRANDE ${datainicio} a ${datafim} ( ${dados.total[0].total} )`
                 },
                  theme: "light2",
                 
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
            markerSize: 10,
        
            dataPoints: dataPointsNotificados
        },
    
        {
            type: "line",
            axisYType: "secondary",
            name: `CONFIRMADOS ( ${dados.total[0].t_confirmado} )`,
            showInLegend: true,
            markerSize: 10,
        
            dataPoints: dataPointsConfirmados
        },
        {
            type: "line",
            axisYType: "secondary",
            name: `DESCARTADOS ( ${dados.total[0].t_descartado } )`,
            showInLegend: true,
            markerSize: 10,
        
            dataPoints: dataPointsDescartados
            },
            {
                type: "line",
                axisYType: "secondary",
                name: `EXCLUIDOS ( ${dados.total[0].t_excluido} )`,
                showInLegend: true,
                markerSize: 10,
                indexLabel: `{y}`,
                dataPoints: dataPointsExcluidos
            },
            {
                type: "line",
                axisYType: "secondary",
                name: `OBITOS ( ${dados.total[0].t_obito} )`,
                showInLegend: true,
                markerSize: 10,
                indexLabel: `{y}`,
                dataPoints: dataPointsObitos
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


	
// var x=	new Date("2020-02-25T00:00:00.000000Z").toUTCString();
// console.log(x)
