


// add an OpenStreetMap tile layer
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; Contribuidores do <a href="http://osm.org/copyright">OpenStreetMap</a>'
}).addTo(map);





//  icones para ser injetados no mapa
const NOTIFICADO = L.icon({
    iconUrl: '/images/covid.png',
    iconSize: [25, 25],
    //  iconAnchor: [22, 94],
    className: 'notificado',
    // className:'notificado-shadow'
})

const CONFIRMADO = L.icon({
    iconUrl: '/images/COVID_CONFIRMADO.png',
    iconSize: [35, 35],
    //  iconAnchor: [100, 100],
    className: 'confirmado'
})
const DESCARTADO = L.icon({
    iconUrl: '/images/covid.png',
    iconSize: [35, 25],
    //  iconAnchor: [100, 100],
    className: 'descartado'
})

const SAUDE_NA_HORA = L.icon({
    iconUrl: '../saudeth.jpeg',
    iconSize: [25, 25],
})
const UPA = L.icon({
    iconUrl: '../upa.png',
    iconSize: [25, 25],
})


function icones(text) {
    if (text == 'AGUARDANDO RESULTADO')
        return NOTIFICADO
    if (text == 'CONFIRMADO')
        return CONFIRMADO
    if (text == 'DESCARTADO')
        return DESCARTADO;

    return L.icon({ iconUrl: '/images/covid.png', iconSize: [35, 35], })

}

//criar logo no canto inferior esquerdo
L.Control.Watermark = L.Control.extend({
    onAdd: function (map) {
        var img = L.DomUtil.create('img');

        img.src = '/images/pmcg.png';
        img.style.width = '200px';

        return img;
    },

    onRemove: function (map) {
        // Nothing to do here
    }
});

L.control.watermark = function (opts) {
    return new L.Control.Watermark(opts);
}

L.control.watermark({ position: 'bottomleft' }).addTo(map);

var markesConfirmados = L.markerClusterGroup({ chunkedLoading: true });

map.addLayer(markesConfirmados);


var ponteiroUnidades = L.layerGroup();

var carrega = false
buscaNotificacoes();
var t_not = 0;
var t_conf = 0;
var t_desc = 0;
var t_nao = 0;
var t_total = 0;
//função para buscar as informaçoes dos dados
async function buscaNotificacoes() {
    t_not = 0;
    t_conf = 0;
    t_desc = 0;
    t_nao = 0;
    t_total = 0;

    map.removeLayer(markesConfirmados);


    markesConfirmados = L.markerClusterGroup({
        chunkedLoading: true,
        iconCreateFunction: function(cluster) {
            return L.divIcon({ html: cluster.getChildCount(), className: 'mycluster', iconSize: L.point(40, 40) });        
        }
    });

//        { html: n, className: 'mycluster', iconSize: L.point(40, 40) }


    let inicio
    let fim
    if (carrega) {
        inicio = $('#inicio').val();
        fim = $('#fim').val();

    } else {

        carrega = true;
    }


    await axios.get('/covid/coordenadasConfirmado', { params: { inicio, fim } })
        .then(response => {
            console.log(response)
            busca(response.data)
        })
        .catch(error => {

        })

    if (carrega) {
        let inicio = $('#inicio').val();
        let fim = $('#fim').val();
        console.log(inicio, fim)
        $('#todos').attr('checked');

    } else {

        carrega = true;
    }

    $('#t_not').text(t_not);
    $('#t_desc').text(t_desc);
    $('#t_conf').text(t_conf);
    $('#t_nao').text(t_nao);
    console.log(t_not)
    console.log(t_desc)
    console.log(t_conf)
    t_total = t_conf + t_desc + t_not + t_nao;
    $('#t_total').text(t_total);
    map.addLayer(markesConfirmados);

}




//funçao para formatar a caixa das equipes
function carregarEquipes(equipes) {

    var listaEquipe = `<ul>`;
    equipes.forEach(equipe => {
        listaEquipe += `
            <li><b>${equipe.sg_equipe}</b> INE: ${equipe.co_ine}  AREA  ${equipe.co_area} </li>
            `
    })
    listaEquipe += `</ul>`
    return listaEquipe
}



function carregarPesquisa(element, id) {


    let sexo = element.sexo == "F" ? "FEMININO" : element.sexo == "M" ? "MASCULINO" : "IGNORADO"
    //cria o icone no mapa para a pesquisa
    let marker = new L.Marker(new L.latLng([element.lat, element.lng]), {
        icon: icones(element.resultado),
        title: `${element.resultado} - ${sexo}`, element
    }).bindPopup(`<ul>
    <li>ID CASO ${element.id_caso}</li>
    <li>RESULTADO ${element.resultado}</li>
    <li>IDADE ${element.idade} anos</li>
    <li>SEXO ${sexo}</li>
    <li>CEP: ${element.cep}</li>
    <li>BAIRRO: ${element.bairro} </li>    
    </ul>`).on({
        //  mouseover: mouseOver,
        // mouseout: mouseOut,
        // click: mouseClick,
        //   click: apagarPoligono,
        //     contextmenu: abrirArea
    }).addTo(ponteiroUnidades);;//se property searched
    if (element.resultado == "CONFIRMADO") {
        markesConfirmados.addLayer(marker);
        t_conf++;
    }

    if (element.resultado == "AGUARDANDO RESULTADO") {

        t_not++;
    }
    if (element.resultado == "DESCARTADO") {

        t_desc++;
    }


}



var scale = L.control.scale()
scale.addTo(map)


//funçao utilizada para criar os ponteiros , necessita receber os parametros da requisição
async function busca(data) {
    //injetar valor dos pontos no mapa com a combo
    console.log(data)
    data.forEach(element => {

        if (element.lat != undefined) {
            carregarPesquisa(element);

        } else {
            t_nao++;
        }
    })
}


