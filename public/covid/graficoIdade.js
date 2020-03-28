

buscarDadosIdade();

//função para buscar as informaçoes dos dados
async function buscarDadosIdade() {
    await axios.get('/covid/casosIdade', {
        //    params: { inicio, fim }
    })
        .then(response => {
            console.log(response)
           
           
            carregarGraficoIdade(response.data)
        })
        .catch(error => {

        })
}

function formatarData(data) {
    return new Date(data.split('-')[0], data.split('-')[1] - 1, data.split('-')[2], 0, 0, 0)
}


async function carregarGraficoIdade(dados) {
    console.log(dados)


  
    dataPointsidade = dados.idade.map(element => {
        return { label: element.idade, y: element.total }
    })





    var chart = new CanvasJS.Chart("chartContainerIdade", {
        title: {
            text: `CASOS CONFIRMADOS DE COVID-19 POR IDADE (${dados.total})`
        },
        animationEnabled: true,
        theme: "light2",
        axisX:{
            interval: 1
        },
        axisY2:{
            interlacedColor: "rgba(1,77,101,.2)",
            gridColor: "rgba(1,77,101,.1)",
            title: "CASOS"
        },
        data: [{
            type: "bar",
            name: "companies",
            axisYType: "secondary",
            color: "#014D65",
            dataPoints: dataPointsidade
        }]
    });
    chart.render();
    



}



// var x=	new Date("2020-02-25T00:00:00.000000Z").toUTCString();
// console.log(x)
