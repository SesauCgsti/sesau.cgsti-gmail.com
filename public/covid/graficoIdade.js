

buscarDadosIdade();

//função para buscar as informaçoes dos dados
async function buscarDadosIdade() {
    await axios.get('/covid/casosIdade', {
        //    params: { inicio, fim }
    })
        .then(response => {
            console.log(response)
            carregarGraficoSexo(response.data)
        })
        .catch(error => {

        })
}

function formatarData(data) {
    return new Date(data.split('-')[0], data.split('-')[1] - 1, data.split('-')[2], 0, 0, 0)
}


async function carregarGraficoSexo(dados) {
    console.log(dados)


    // var x=	new Date("2020-02-25T00:00:00.000000Z");
    // console.log(x)

    // var day = moment("2020-02-25").;
    // console.log(day);

    feminino = dados.feminino;
    dataini = feminino[0].data;
    datafim = feminino[feminino.length - 1].data;
    feminino
    var dataPointsfeminino = [];
    var dataPointsmasculino = [];
    var dataPointsnaoInformado = [];





    dataPointsfeminino = dados.feminino.map(element => {
        return { x: formatarData(element.data), y: element.total }
    })

    dataPointsnaoInformado = dados.naoInformado.map(element => {
        return { x: formatarData(element.data), y: element.total }
    })

    dataPointsmasculino = dados.masculino.map(element => {
        return { x: formatarData(element.data), y: element.total }
    })

    datainicio = formatarData(dataini).toLocaleDateString();
    //datainicio='dois';


    datafim = formatarData(datafim).toLocaleDateString();



    var chart = new CanvasJS.Chart("chartContainerSexo", {
        title: {
            text: `CASOS CONFIRMADOS DE COVID-19 POR SEXO CAMPO GRANDE ${datainicio} a ${datafim} ( ${dados.total[0].total} )`
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
                name: `MASCULINO ( ${dados.total[0].t_masculino} )`,
                showInLegend: true,
                markerSize: 0,

                dataPoints: dataPointsmasculino
            },

            {
                type: "line",
                axisYType: "secondary",
                name: `FEMININO ( ${dados.total[0].t_feminino} )`,
                showInLegend: true,
                markerSize: 0,

                dataPoints: dataPointsfeminino
            },
            {
                type: "line",
                axisYType: "secondary",
                name: `NÃO INFORMADO ( ${dados.total[0].t_naoInformado} )`,
                showInLegend: true,
                markerSize: 0,

                dataPoints: dataPointsnaoInformado
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
