


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
//var markersLayerPolygon = new L.LayerGroup();

map.addLayer(markersDescartados);
map.addLayer(markersNotificados);
map.addLayer(markesConfirmados);


var ponteiroUnidades = L.layerGroup();
// var poligonoEnfermagem = L.layerGroup();
// var poligonoMedico = L.layerGroup();

// var overlays = {
//     "Unidades": ponteiroUnidades,
//     "Enfermagem": poligonoEnfermagem,
//     "Médico": poligonoMedico
// };

// L.control.layers([], overlays).addTo(map);



// var controlSearch = new L.Control.Search({
//     position: 'topleft',
//     layer: markersLayer,
//     initial: false,
//     zoom: 16,
//     marker: false,
//     textErr: 'Pesquisa não encontrada',
//     minLength: 3,
//     textPlaceholder: 'Pesquisar',
//     textCancel: 'Cancelar',
//     collapsed: false,
//     //propertyName: 'cnes'
//     buildTip: function (text, val) {
//         ///   console.log(val)

//         let element = val.layer.options.element;


//         //cria o icone no mapa para a pesquisa
//         let marker = new L.Marker(new L.latLng([element.latitude, element.longitude]), { icon: icones(element.nome_fantasia.split(' ')[0]), title: `${element.nome_fantasia} - ${element.cnes}`, element }).bindPopup(`<ul>
//     <li>Nome ${element.nome_fantasia}</li>
//     <li>Razão Social ${element.razao_social}</li>
//     <li>CNES ${element.cnes}</li>
//     <li>Rua: ${element.logradouro} ${element.numero} cep(${element.cep})</li>
//     <li>Bairro: ${element.bairro} </li>    
//     </ul>`).on({
//             click: mouseClick,
//             contextmenu: abrirArea
//         }).addTo(map);//se property searched

//         return '<a href="#" >' + text + '<b> ' + val.layer.options.element.tipo_gestao + '</b> </a>';
//     }

// });

//map.addControl(controlSearch);


var carrega =false
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
    map.removeLayer(markersDescartados);
       map.removeLayer(markersNotificados);
        map.removeLayer(markesConfirmados);

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
         //   todos()
            //   map.addLayer(markersLayerPolygon);
            // map.addLayer(unidadePoly);
            // map.addLayer(unidadesCircle);
            // map.addLayer(upasCircle);
            // map.addLayer(markersLayerUpa);
            // map.addLayer(markersLayer);

            
            
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
    console.log(t_not)
    console.log(t_desc)
    console.log(t_conf)
    t_total = t_conf + t_desc + t_not+t_nao;
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



    // filtros = {
    //     'ger': {
    //         'filtro': 'lotacao_gerente', 'cargo': 'Gerente', 'fonte': [
    //             { 'cbo': '142105', 'cargo': 'GERENTE ADMINISTRATIVO' },
    //             { 'cbo': '131210', 'cargo': 'GERENTE DE SERVIÇOS DE SAÚDE' }
    //         ]
    //     },
    //     'med': {
    //         'filtro': 'lotacao_med', 'cargo': 'Medico', 'fonte': [
    //             { 'cbo': '225125', 'cargo': 'MÉDICO CLÍNICO' },
    //             { 'cbo': '2231F9', 'cargo': 'MÉDICO RESIDENTE' },
    //             { 'cbo': '225142', 'cargo': 'MÉDICO DA ESTRATEGIA DE SAUDE DA FAMILIA' },
    //             { 'cbo': '225250', 'cargo': 'MÉDICO GINECOLOGISTA E OBSTETRA' },
    //             { 'cbo': '225124', 'cargo': 'MÉDICO PEDIATRA' },
    //         ]
    //     },
    //     'enf': {
    //         'filtro': 'lotacao_enf', 'cargo': 'Enfermeiro', 'fonte': [
    //             { 'cbo': '223565', 'cargo': 'ENFERMEIRO DA ESTRATEGIA DE SAUDE DA FAMILIA' },
    //             { 'cbo': '223505', 'cargo': 'ENFERMEIRO' },
    //         ]
    //     },
    //     'odo': {
    //         'filtro': 'lotacao_odonto', 'cargo': 'Odonto', 'fonte': [
    //             { 'cbo': '223293', 'cargo': 'CIRURGIAO DENTISTA DA ESTRATEGIA DE SAUDE DA FAMILIA' },
    //             { 'cbo': '223208', 'cargo': 'CIRURGIAO DENTISTA CLINICO GERAL' },
    //             { 'cbo': '223212', 'cargo': 'CIRURGIAO DENTISTA ENDODONTISTA' },
    //         ]
    //     },

    //     'acs': {
    //         'filtro': 'lotacao_a_c_s', 'cargo': 'Agente Comunitário de Saúde', 'fonte': [
    //             { 'cbo': '515105', 'cargo': 'AGENTE COMUNITARIO DE SAUDE' },
    //             { 'cbo': '515140', 'cargo': 'AGENTE DE COMBATE AS ENDEMIAS' },
    //             { 'cbo': '352210', 'cargo': 'AGENTE DE SAUDE PÚBLICA' },

    //         ]
    //     },
    //     'far': {
    //         'filtro': 'lotacao_farm', 'cargo': 'Farmaceutico', 'fonte': [
    //             { 'cbo': '223430', 'cargo': 'FARMACEUTICO EM SAUDE PUBLICA' },
    //             { 'cbo': '223405', 'cargo': 'FARMACEUTICO' },
    //         ]
    //     },
    //     'ass': {
    //         'filtro': 'lotacao_assistente_social', 'cargo': 'Assistente Social', 'fonte': [
    //             { 'cbo': '251605', 'cargo': 'ASSISTENTE SOCIAL' },

    //         ]
    //     },
    // };

    // teste =  $filtros.filter(function(el)  {
    //     return el.includes(id)
    // });
    // alert(teste)


    //     busca = $filtros.filter(function (el) {
    //     console.log(el)
    //     return listacbo.includes(el.key)
    // })

    //     console.log(busca)
    // try {

    //     let listaProfissional = "<span style='color:red'>Sem profissional lotado</span>";
    //     let coorfarma = 'red';

    //     if (element[filtros[id].filtro].length == 0) {
    //         coorfarma = 'red';

    //     } else {
    //         coorfarma = 'green';
    //         listaProfissional = ``;
    //         element[filtros[id].filtro].forEach(prof => {

    //             listaProfissional += `<div> CBO ${prof.co_cbo} - ${prof.nm_prof} - ${prof.co_cns}  </div>`
    //         })
    //         listaProfissional += `<div style='margin-top:5px;'><b>Legenda CBO: </b>`

    //         console.log(filtros[id].fonte)
    //         filtros[id].fonte.forEach(fonte => {
    //             listaProfissional += `<li> CBO: ${fonte.cbo} - ${fonte.cargo} </li>`
    //             console.log(fonte)
    //         })
    //         listaProfissional += `</div>`;

    //         console.log(listaProfissional)
    //     }


    //     let markePolygon = L.polygon(element.camadas, { color: coorfarma }).on({
    //         //  mouseover: mouseOver,
    //         // mouseout: mouseOut,
    //         // click: mouseClick,
    //         //  click: centralizarPoligono,
    //         // contextmenu:   apagarPoligono   

    //     }).bindPopup(` <h4><b> ${element.nome_fantasia} CNES - ${element.cnes}</b> </h4> 
    //     <h4><b> Cargo ${filtros[id].cargo}</b></h4>  ${listaProfissional}`, { maxWidth: 600, maxHeight: 500 }


    //     );//.addTo(map);

    //    markersLayerPolygon.addLayer(markePolygon)

    // var makerCircle = L.circle([element.latitude, element.longitude], {
    //     color: 'blue',
    //     fillColor: '#blue',
    //     fillOpacity: 0.2,
    //     radius: 500,
    //     element
    // }).bindPopup('Voce esta na area da unidade ' + element.nome_fantasia).on({
    //     //  mouseover: mouseOver,
    //     // mouseout: mouseOut,
    //     click: mouseClick,
    //     //  click: centralizarPoligono,
    //     contextmenu: abrirArea
    // });

    // unidadesCircle.addLayer(makerCircle);


    // } catch (error) {
    //     console.log(error)
    // }





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

        }else {
            t_nao++;
        }
    })
}


