

buscarDadosConfirmadosDIA();

//função para buscar as informaçoes dos dados
async function buscarDadosConfirmadosDIA() {
    await axios.get('/covid/casosConfirmadoDIA', {
        //    params: { inicio, fim }
    })
        .then(response => {
            console.log(response)
            carregarGraficoConfirmadoDIA(response.data)
        })
        .catch(error => {

        })
}

function formatarData(data) {
    return new Date(data.split('-')[0], data.split('-')[1] - 1, data.split('-')[2], 0, 0, 0)
}


var dataPointsconfirmadoDIA = [];
var dadosDiario;
async function carregarGraficoConfirmadoDIA(dados) {
    console.log(dados)
    dadosDiario = dados;

    // var x=	new Date("2020-02-25T00:00:00.000000Z");
    // console.log(x)

    // var day = moment("2020-02-25").;
    // console.log(day);

   
   
    





    dataPointsconfirmadoDIA = dados.confirmado.map(element => {
        return { x: formatarData(element.data), y: element.total,dia:element.qtdia}
    })




    // confirmado = dados.confirmado;
    // dataini = confirmado[0].data;
    // datafim = confirmado[confirmado.length - 1].data;

    // datainicio = formatarData(dataini).toLocaleDateString();
    // //datainicio='dois';


    // datafim = formatarData(datafim).toLocaleDateString();


    updateChart();
    // var chart = new CanvasJS.Chart("chartContainerConfirmadoDIA", {
    //     title: {
    //         text: `DIA CASOS CONFIRMADOS DE COVID-19 CAMPO GRANDE ${datainicio} a ${datafim} ( ${dados.total[0].total} )`
    //     },
    //     animationEnabled: true,
    //     theme: "light2",
    //     axisX: {
    //         valueFormatString: "DD/MM/YYYY "
    //     },
    //     axisY2: {
    //         title: "CASOS",
    //         //	prefix: "$",
    //         //	suffix: "K"
    //     },
    //     toolTip: {
    //         shared: true
    //     },
    //     legend: {
    //         cursor: "pointer",
    //         verticalAlign: "top",
    //         horizontalAlign: "center",
    //         dockInsidePlotArea: true,
    //         itemclick: toogleDataSeries
    //     },
    //     data: [


    //         {
    //             type: "line",
    //            //type: "spline",  
    //             axisYType: "secondary",
    //             name: `Confirmado ( ${dados.total[0].total} )`,
    //             indexLabel: "({dia}) {y} ",
    //             indexLabelFontSize: 20,
    //             indexLabelMaxWidth: 50,
    //             showInLegend: true,
    //             markerSize: 10,
    //             indexLabelFontStyle: "oblique",
    //             toolTipContent: "<span style=\"color:#C0504E\"><strong>{x} </strong></span> {y}",
    //            // markerType: "square",
    //          //   lineDashType: "dash",
    //             dataPoints: dataPointsconfirmadoDIA
    //         },

         

    //     ]
    // });
    // chart.render();

    // function toogleDataSeries(e) {
    //     if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    //         e.dataSeries.visible = false;
    //     } else {
    //         e.dataSeries.visible = true;
    //     }
    //     chart.render();
 //   }








}


function updateChart(cont = 10) {
    indexLabel = "{dia}, {y} ";
    if (cont > 32) {
        indexLabel = "";
    } 
    let dadosInterno= dataPointsconfirmadoDIA.slice(-cont)
  console.log(dadosInterno)
    
   let dataini = dadosInterno[0].x;
   let datafim = dadosInterno[dadosInterno.length - 1].x;
console.log(dataini)
    datainicio = dataini.toLocaleDateString();
    datafim = datafim.toLocaleDateString();
    //datainicio='dois';


   // 
    var chart = new CanvasJS.Chart("chartContainerConfirmadoDIA", {
      
        animationEnabled: true,
      
        axisX: {
            valueFormatString: "DD/MM/YYYY "
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
               //type: "spline",  
                axisYType: "secondary",
                name: `Confirmado ( ${dadosDiario.total[0].total} )`,
  //              indexLabel: indexLabel,


                showInLegend: true,
                markerSize: 5,
                indexLabelFontStyle: "oblique",
                toolTipContent: "{x}<br><span style=\"color:#C0504E\"><strong>{dia}ª dia </strong></span><br>{y} Not.",
               // markerType: "square",
             //   lineDashType: "dash",
                dataPoints: dadosInterno
            },

         

        ]
    });
    chart.render();

    function toogleDataSeries(e) {
        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chart.render();
    }
}


// var x=	new Date("2020-02-25T00:00:00.000000Z").toUTCString();
// console.log(x)
