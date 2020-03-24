

buscarDadosConfirmados();

//função para buscar as informaçoes dos dados
async function buscarDadosConfirmados() {
    await axios.get('/covid/casosConfirmado', {
        //    params: { inicio, fim }
    })
        .then(response => {
            console.log(response)
            carregarGraficoConfirmado(response.data)
        })
        .catch(error => {

        })
}

function formatarData(data) {
    return new Date(data.split('-')[0], data.split('-')[1] - 1, data.split('-')[2], 0, 0, 0)
}


async function carregarGraficoConfirmado(dados) {
    console.log(dados)


    // var x=	new Date("2020-02-25T00:00:00.000000Z");
    // console.log(x)

    // var day = moment("2020-02-25").;
    // console.log(day);

    confirmado = dados.confirmado;
    dataini = confirmado[0].data;
    datafim = confirmado[confirmado.length - 1].data;
    confirmado
    var dataPointsconfirmado = [];





    dataPointsconfirmado = dados.confirmado.map(element => {
        return { x: formatarData(element.data), y: element.total }
    })


    datainicio = formatarData(dataini).toLocaleDateString();
    //datainicio='dois';


    datafim = formatarData(datafim).toLocaleDateString();



    var chart = new CanvasJS.Chart("chartContainerConfirmado", {
    
        
        animationEnabled: true,
        
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
               //type: "spline",  
                axisYType: "secondary",
                name: `Confirmado ( ${dados.total[0].total} )`,
              
                showInLegend: true,
                markerSize: 5,
                indexLabelFontStyle: "oblique",
                toolTipContent: "<span style=\"color:#C0504E\"><strong>{x} </strong></span> <br><b>{y}<b>",
               // markerType: "square",
             //   lineDashType: "dash",
                dataPoints: dataPointsconfirmado
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
