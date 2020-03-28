


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
    iconSize: [25, 25],
  //  iconAnchor: [100, 100],
    className:'confirmado'
})
const DESCARTADO = L.icon({
    iconUrl: '/images/covid.png',
    iconSize: [35, 25],
  //  iconAnchor: [100, 100],
    className:'descartado'
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



// var popup = L.popup();






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




//caixa de pesquisa adicionada
var markersNotificados = new L.LayerGroup();	//layer contain searched elements
var markesConfirmados = new L.LayerGroup();
var markersDescartados= new L.LayerGroup();
var markersExcluidos = new L.LayerGroup();
var markersObitos= new L.LayerGroup();



map.addLayer(markersDescartados);
map.addLayer(markersNotificados);
map.addLayer(markesConfirmados);
map.addLayer(markersObitos);
map.addLayer(markersExcluidos);


var ponteiroUnidades = L.layerGroup();



var carrega =false
buscaNotificacoes();
var t_not = 0;
var t_conf = 0;
var t_desc = 0;
var t_nao = 0;
var t_obt = 0;
var t_exc = 0;
var t_total = 0;
//função para buscar as informaçoes dos dados
async function buscaNotificacoes() {
     t_not = 0;
     t_conf = 0;
    t_desc = 0;
    t_nao = 0;
    t_total = 0;
    t_exc = 0;
    t_obt = 0;
    removeAllMarkers();
   markersNotificados = new L.LayerGroup();	//layer contain searched elements
   markesConfirmados = new L.LayerGroup();
    
    //var markersLayerPolygon = new L.LayerGroup();
    
    
    // map.addLayer(markersNotificados);
    // map.addLayer(markesConfirmados);
    
    let inicio 
    let fim 
    if (carrega) {
        inicio = $('#inicio').val();
         fim = $('#fim').val();
        
    } else {
       
        carregaRadio()       
        carrega = true; 
    }
  
 
    await axios.get('/covid/coordenadas', { params: { inicio, fim } })
        .then(response => {
            console.log(response)
            busca(response.data)         
            
        })
        .catch(error => {

        })
    
        if (carrega) {
            let inicio = $('#inicio').val();
            let fim = $('#fim').val();
            console.log(inicio,fim)
            $('#todos').attr('checked');
            carregaRadio()       
        } else {
           
            carregaRadio()       
            carrega = true; 
        }
    
    $('#t_not').text(t_not);
    $('#t_desc').text(t_desc);
    $('#t_conf').text(t_conf);
    $('#t_nao').text(t_nao);
    $('#t_obt').text(t_obt);
    $('#t_exc').text(t_exc);
    console.log(t_not)
    console.log(t_desc)
    console.log(t_conf)
    t_total = t_conf + t_desc + t_not+t_nao+t_obt+t_exc;
    $('#t_total').text(t_total);
  
    
}

// var unidadesLayer = new L.FeatureGroup();
// var makerEquipes = new L.FeatureGroup();
// var unidadesUpaLayer = new L.FeatureGroup();

// var unidadePoly = new L.FeatureGroup();
// var unidadesCircle = new L.FeatureGroup();
// var upasCircle = new L.FeatureGroup();




async function adicionarPoligonoUnidade(y, map) {
    const x = [];
    console.log(y)
    // y.camadas.forEach(caminhopol => {
    //     x.push([Number(caminhopol.lat), Number(caminhopol.lng)])
    // });

    /// criando o click do mouse para indicar o nome da unidade que está
    var unidade = L.polygon(x, { color: 'red' }).on({
        //  mouseover: mouseOver,
        // mouseout: mouseOut,
        // click: mouseClick,
        //  click: centralizarPoligono,
        contextmenu: abrirArea
    }).bindPopup(`Você esta na area da unidade ${y.nome}`)
    unidadePoly.addLayer(unidade);

}


function removeAllMarkers() {
   
    map.removeLayer(markersDescartados);
    map.removeLayer(markersNotificados);
    map.removeLayer(markesConfirmados);
    map.removeLayer(markersObitos);
    map.removeLayer(markersExcluidos);

}

// document.querySelector('button').onclick = function () { removeAllMarkers() };



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



let sexo = element.sexo=="F"?"FEMININO":element.sexo=="M"?"MASCULINO":"IGNORADO"
    //cria o icone no mapa para a pesquisa
    let marker = new L.Marker(new L.latLng([element.lat, element.lng]), {
        icon: icones(element.resultado),
        title: `${element.resultado} - ${sexo}`, element
    }).bindPopup(`<ul>
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
        markersNotificados.addLayer(marker);
        t_not++;
    }
    if (element.resultado == "DESCARTADO") {
        markersDescartados.addLayer(marker);
        t_desc++;
    }

    if (element.resultado == "OBITO") {
        markersObitos.addLayer(marker);
        t_obt++;
    }

    if (element.resultado == "EXCLUIDO") {
        markersExcluidos.addLayer(marker);
        t_exc++;
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
            console.log(element)
            t_nao++;
        }
    })
}


