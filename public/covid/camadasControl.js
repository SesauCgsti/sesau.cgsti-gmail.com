// control that shows state info on hover
// var info = L.control();

// info.onAdd = function (map) {
//     this._div = L.DomUtil.create('div', 'info');
//     this.update();
//     return this._div;
// };

// info.update = function (props) {
//     this._div.innerHTML = '<h4>Status da Unidade</h4>' +  (props ?
//         '<b>' + props + '</b><br />' + props + ' people / mi<sup>2</sup>'
//         : 'Hover over a state');
// };

// info.addTo(map);



////radio button info
// control that shows state info on hover
var radioInfo=L.control();

function carregaRadio() {
    todos();
    radioInfo.remove(map); 
    
    radioInfo = L.control();
 

    radioInfo.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'radio');
        this.update();
        return this._div;
    };

    radioInfo.update = function (props) {
        this._div.innerHTML = `
    <input type="radio" name="filtro" onclick=" confnot()" value="equipe"> CONFIRMADOS E SUSPEITOS
    <input type="radio" name="filtro" id="todos" onclick=" todos()" checked value="unidade"> TODOS
    <input type="radio" name="filtro" onclick="confirmados()" value="equipe"> CONFIRMADOS
    <input type="radio" name="filtro" onclick=" notificados()" value="equipe"> SUSPEITOS
    <input type="radio" name="filtro" onclick=" descartados()" value="equipe"> DESCARTADOS
    `
    };
   // radioInfo.addTo(map);
}
// function myFunction(valor) {
//     removeAllMarkers()
//     alert('Ainda a implementar')

// }

// function mostrarUnidades(valor) {
//     removeAllMarkers();
//     // map.addLayer(markersLayerUpa);

//     map.addLayer(unidadesCircle);
//     map.addLayer(upasCircle);
//     map.addLayer(markersLayerUpa);
//     map.addLayer(markersLayer);

// }

function todos() {
    removeAllMarkers();

    map.addLayer(markersNotificados);
    map.addLayer(markesConfirmados);
    map.addLayer(markersDescartados);
    map.addLayer(markersExcluidos);
    map.addLayer(markersObitos);
}


function confnot() {
    removeAllMarkers();

    map.addLayer(markersNotificados);
    map.addLayer(markesConfirmados);
 
}


function confirmados() {
    removeAllMarkers();
    map.addLayer(markesConfirmados);

}

function obitos() {
    removeAllMarkers();
    map.addLayer(markersObitos);

}
function excluidos() {
    removeAllMarkers();
    map.addLayer(markersExcluidos);

}

function descartados() {
    removeAllMarkers();
    map.addLayer(markersDescartados);

}

function notificados() {
    removeAllMarkers();
    map.addLayer(markersNotificados);

}

function suspeitos() {
    removeAllMarkers();
    map.addLayer(markersNotificados);

}
//     map.addLayer(markersLayer);
// }


// function upas() {
//     removeAllMarkers()

//     map.addLayer(upasCircle);
//     map.addLayer(markersLayerUpa);
// }








// get color depending on population density value
function getColor(d) {
    return d > 1000 ? '#800026' :
        d > 500 ? '#BD0026' :
            d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                    d > 50 ? '#FD8D3C' :
                        d > 20 ? '#FEB24C' :
                            d > 10 ? '#FED976' :
                                '#FFEDA0';
}

function style(feature) {
    console.log(feature)
    return {
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7,
        //  fillColor: getColor(feature.properties.cnes)
        fillColor: getColor(100)
    };
}

function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
        weight: 5,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }

    info.update(layer.feature.properties);
}

var geojson;

function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}

function onEachFeature(feature, layer) {
    console.log([feature])
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: mouseClick
    });
}


function mouseOver(e) {
    // console.log(e.target)
    var layer = e.target;

    // layer.setStyle({
    //     weight: 5,
    //     color: '#666',
    //     dashArray: '',
    //     fillOpacity: 0.7
    // });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {

    }
    //  layer.bringToBack()	

    // layer.bringToBack();
    //info.update(layer.feature.properties);
    console.log('over')
}
async function mouseClick(e) {
    // console.log(element)
    // console.log(e.target)
    //element=e.target.options.element
    //  map.fitBounds(e.target.getBounds())



    element = e.target.options.element

    // element.cnes
    await axios.get(`http://localhost:8000/maps_ms/${element.cnes}`, {})
        .then(response => {
            console.log(response.data)
            //busca(response.data)
            let marker = new L.Marker(new L.latLng([response.data.lat, response.data.lng]), { icon: icones(response.data.nome.split(' ')[0]), title: `${response.data.nome} - ${response.data.nome}` }).bindPopup(`<ul>
    <li>Nome ${response.data.nome}</li>
    <li>Regiao ${response.data.regiao}</li>
    <li>CNES ${response.data.cnes}</li>
    <li>Endereço: ${response.data.endereco})</li>
    <li>URL mapa: <a target="_blank" href="${response.data.url}"> Clique aqui</a> </li>    
    </ul>`).addTo(map);//se property searched

            L.polygon(response.data.camadas, { color: 'red' }).on({
                //  mouseover: mouseOver,
                // mouseout: mouseOut,
                // click: mouseClick,
                //  click: centralizarPoligono,

            }).bindPopup(`Você esta na area da unidade ${response.data.nome}`).addTo(map);

            buscaEquipeLotacao(response.data.equipes);
            // map.addLayer(unidadesLayer);
            // map.addLayer(unidadePoly);
            // map.addLayer(unidadesCircle);
            // map.addLayer(upasCircle);
            // map.addLayer(markersLayerUpa);
            // map.addLayer(markersLayer);


        })
        .catch(error => {

        })

    e.target.bindPopup(`<ul><h2>Lista das equipes</h2>
    <li>Nome ${element.nome_fantasia}</li>
    <li>Razão Social ${element.razao_social}</li>
    <li>CNES ${element.cnes}</li>
    <li>Rua: ${element.logradouro} ${element.numero} cep(${element.cep})</li>
    <li>Bairro: ${element.bairro} </li>    
    </ul>`)




    //  element=e.sourceTarget.options.element
    //  let marker = new L.Marker(new L.latLng([element.latitude, element.longitude]), { icon: icones(element.nome_fantasia.split(' ')[0]), title: `${element.nome_fantasia} - ${element.cnes}`, element }).bindPopup(`<ul>
    //  <li>Nome ${element.nome_fantasia}</li>
    //  <li>Razão Social ${element.razao_social}</li>
    //  <li>CNES ${element.cnes}</li>
    //  <li>Rua: ${element.logradouro} ${element.numero} cep(${element.cep})</li>
    //  <li>Bairro: ${element.bairro} </li>    
    //  </ul>`);//se property searched




    // e.target.bindPopup(`<ul><h2>outra das equipes</h2>
    // <li>Nome ${element.nome_fantasia}</li>
    // <li>Razão Social ${element.razao_social}</li>
    // <li>CNES ${element.cnes}</li>
    // <li>Rua: ${element.logradouro} ${element.numero} cep(${element.cep})</li>
    // <li>Bairro: ${element.bairro} </li>    
    // </ul>`)


    ///  .setLatLng(e.latlng)

    // L.circle([e.latlng], {
    //     color: 'green',
    //     fillColor: '#blue',
    //     fillOpacity: 0.2,
    //     radius: 200
    // }).addTo(map).bindPopup('Voce esta na area da unidade '+ element.nome_fantasia)
    // new L.Marker(new L.latLng([e.target.getBounds()])).addTo(map)
}


async function abrirArea(e) {


    element = e.target.options.element

    //element.cnes
    await axios.get(`http://localhost:8000/maps_ms/${element.cnes}`, {})
        .then(response => {
            console.log(response.data)

            L.polygon(response.data.camadas, { color: 'red' }).on({
                //  mouseover: mouseOver,
                // mouseout: mouseOut,
                // click: mouseClick,
                //  click: centralizarPoligono,
                contextmenu: apagarPoligono

            }).bindPopup(carregarLotacaoProfissionaisUnidade(response.data)


            ).addTo(map);




        })
        .catch(error => {
            console.log(error)
        })





}


function apagarPoligono(e) {

    e.target.remove()

}



function abrirMicro() {
    alert('buscando micro aared')
}


//===============Funçoes validas===================
function centralizarPoligono(e) {
    map.fitBounds(e.target.getBounds());
    e.target.bringToFront();
}





function mouseOut(e) {
    console.log('out')
    var layer = e.target;
    console.log(layer)

    map.resetStyle(e.target);
    //  info.update();
    // layer.
    //resetStyle(e.target);
    //   info.update();
    //layer.bringToFront();

}

// geojson = L.geoJson(statesData, {
//     style: style,
//     onEachFeature: onEachFeature
// }).addTo(map);

map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');


var legend = L.control({ position: 'bottomright' });

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 10, 20, 50, 100, 200, 500, 1000],
        labels = [],
        from, to;

    for (var i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];

        labels.push(
            '<i style="background:' + getColor(from + 1) + '"></i> ' +
            from + (to ? '&ndash;' + to : '+'));
    }

    div.innerHTML = labels.join('<br>');
    return div;
};

legend.addTo(map);


// var popup = L.popup();

// function onMapClick(e) {
// 	popup
// 		.setLatLng(e.latlng)
// 		.setContent("You clicked the map at " + e.latlng.toString())
// 		.openOn(map);
// }

// map.on('click', onMapClick);


async function buscaEquipeLotacao(equipes) {


    ///se for uma UBS não irá verificar  se tem medico entao a cor fica azul por default
    if (equipes.unidade.nm_fanta.split(' ')[0] == 'UBS') {
        let cor = '#5fc6d8'
        var equipe = L.polygon(equipes.poligono, {
            color: 'blue', fillColor: cor,
            fillOpacity: 0.5, weight: 1.5
        }).on({
            contextmenu: abrirMicro,
        }).bindPopup(carregarLotacaoEquipe(equipes)).addTo(map);

    } else if (equipes.unidade.nm_fanta.split(' ')[0] == 'UBSF') {
        let cor
        ///verifica se a unidade tem a tipologia esf ou esfsb
        if (equipes.tp_equipe == ('01') || equipes.tp_equipe == ('02')) {
            cor = '#5fc6d8';
        }
        else {
            cor = '#a3ad2b';
        }

        var equipe = L.polygon(equipes.poligono, {
            color: 'blue', fillColor: cor,
            fillOpacity: 0.5, weight: 1.5
        }).on({
            contextmenu: abrirMicro,
        }).bindPopup(carregarLotacaoEquipe(equipes)).addTo(map);
    }
    //equipe.bindPopup(equipes), { maxWidth: 600, maxHeight: 500 }).addTo(map);
    // equipe.removeLayer
    //        equipesPoly.addLayer(equipe);

}



async function buscaEquipeLotacaoUnidade(equipes) {


    ///se for uma UBS não irá verificar  se tem medico entao a cor fica azul por default
    if (equipes.unidade.nm_fanta.split(' ')[0] == 'UBS') {
        let cor = '#5fc6d8'
        var equipe = L.polygon(equipes.poligono, {
            color: 'blue', fillColor: cor,
            fillOpacity: 0.5, weight: 1.5
        }).on({
            contextmenu: abrirMicro,
        }).bindPopup(carregarLotacaoEquipe(equipes)).addTo(map);

    } else if (equipes.unidade.nm_fanta.split(' ')[0] == 'UBSF') {
        let cor
        ///verifica se a unidade tem a tipologia esf ou esfsb
        if (equipes.tp_equipe == ('01') || equipes.tp_equipe == ('02')) {
            cor = '#5fc6d8';
        }
        else {
            cor = '#a3ad2b';
        }

        var equipe = L.polygon(equipes.poligono, {
            color: 'blue', fillColor: cor,
            fillOpacity: 0.5, weight: 1.5
        }).on({
            contextmenu: abrirMicro,
        }).bindPopup(carregarLotacaoEquipe(equipes)).addTo(map);
    }
    //equipe.bindPopup(equipes), { maxWidth: 600, maxHeight: 500 }).addTo(map);
    // equipe.removeLayer
    //        equipesPoly.addLayer(equipe);

}




function carregarLotacaoEquipe(lotacao) {


    var texto = `<ul>
    <h3><b> ${lotacao.unidade.nm_fanta}</b> </h3> 
    <h3><b>${lotacao.ds_equipe}</b> </h3> <h3><b> ${lotacao.ds_area}</b></h3>
    <h3><b>INE ${lotacao.co_ine}  - AREA ${lotacao.co_area}</b></h3></<h3>`;



    if (lotacao.lotacao_med == null) {
        // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
        texto += `<li style='color:red'>MED Sem profissional lotado </li>`
    } else {


        texto += `<li>Med ${lotacao.lotacao_med.nm_prof} CBO: ${lotacao.lotacao_med.co_cbo} </li>`

    }


    if (lotacao.lotacao_odonto == null) {
        // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
        texto += `<li style='color:red'>Odonto Sem profissional lotado </li>`
    } else {


        texto += `<li>Odonto ${lotacao.lotacao_odonto.nm_prof} CBO: ${lotacao.lotacao_odonto.co_cbo} </li>`

    }


    if (lotacao.lotacao_enf == null) {
        // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
        texto += `<li style='color:red'>Enf Sem profissional lotado </li>`
    } else {


        texto += `<li>Enf ${lotacao.lotacao_enf.nm_prof} CBO: ${lotacao.lotacao_enf.co_cbo} </li>`

    }
    // let medicos = filterCBO(['225125', '2231F9', '225142'], lotacao.lotacao)

    // let enfermeiro = filterCBO(['223565', '223505'], lotacao.lotacao)
    return texto;

}




function carregarLotacaoProfissionaisUnidade(element) {



    var texto = `<ul>
    <h3><b> ${element.nome_fantasia}</b> </h3> 
    <h3><b>CNES ${element.cnes}</b></h3>`;

    element.lotacao_gerente.forEach(profissional => {

        texto += `<h3><b> ${profissional.nm_prof} cbo:${profissional.co_cbo == '131210' ? 'GERENTE DE SERVIÇOS DE SAÚDE' : 'GERENTE ADMINISTRATIVO'} </b></h3>`
    })

    // if (lotacao.lotacao_med== null) {
    //     // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
    //     texto += `<li style='color:red'>MED Sem profissional lotado </li>`
    // } else {


    //         texto += `<li>Med ${  lotacao.lotacao_med.nm_prof} CBO: ${  lotacao.lotacao_med.co_cbo} </li>`

    // }


    // if (lotacao.lotacao_odonto== null) {
    //     // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
    //     texto += `<li style='color:red'>Odonto Sem profissional lotado </li>`
    // } else {


    //         texto += `<li>Odonto ${  lotacao.lotacao_odonto.nm_prof} CBO: ${  lotacao.lotacao_odonto.co_cbo} </li>`

    // }


    // if (lotacao.lotacao_enf== null) {
    //     // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
    //     texto += `<li style='color:red'>Enf Sem profissional lotado </li>`
    // } else {


    //         texto += `<li>Enf ${  lotacao.lotacao_enf.nm_prof} CBO: ${  lotacao.lotacao_enf.co_cbo} </li>`

    // }
    // let medicos = filterCBO(['225125', '2231F9', '225142'], lotacao.lotacao)

    // let enfermeiro = filterCBO(['223565', '223505'], lotacao.lotacao)
    return texto;

}



function carregarLotacao(lotacao) {


    var texto = `<ul><h3><b>${lotacao.ds_equipe}</b> </h3> <h3><b> ${lotacao.ds_area}</b></h3>
    <h3><b>INE ${lotacao.co_ine}  - AREA ${lotacao.co_area}</b></h3></<h3>`;


    let medicos = filterCBO(['225125', '2231F9', '225142'], lotacao.lotacao)

    let enfermeiro = filterCBO(['223565', '223505'], lotacao.lotacao)

    // let tecEnf = filterCBO(['322245', '322205'], lotacao.lotacao)

    // let acs = filterCBO(['515105'], lotacao.lotacao)



    if (medicos.length == 0) {
        // alert('A equipe esta do ine esta sem medico' +lotacao.co_ine)
        texto += `<li style='color:red'>MED Sem profissional lotado </li>`
    } else {


        medicos.forEach(profissional => {

            texto += `<li>MED ${profissional.nm_prof} CBO: ${profissional.co_cbo} </li>`
        })
    }
    enfermeiro.forEach(profissional => {

        texto += `<li>ENF ${profissional.nm_prof} CBO: ${profissional.co_cbo} </li>`
    })

    tecEnf.forEach(profissional => {

        texto += `<li>Tec enf ${profissional.nm_prof} CBO: ${profissional.co_cbo} </li>`
    })

    acs.forEach(profissional => {

        texto += `<li>ACS ${profissional.nm_prof} MA: ${profissional.microarea} </li>`
    })


    texto + -`</ul>`;

    var teste = document.getElementById('textbox');
    console.log(teste);

    //teste.empty();
    teste.insertAdjacentHTML('afterend', texto);




    return texto;


}

listaCBO = {
    '225125': 'MÉDICO CLÍNICO',
    '2231F9': 'MÉDICO RESIDENTE',
    '225142': 'MEDICO DA ESTRATEGIA DE SAUDE DA FAMILIA',
    '225250': 'MEDICO GINECOLOGISTA E OBSTETRA',
    '225124': 'MEDICO PEDIATRA',
    
    '322430': 'AUXILIAR EM SAUDE BUCAL DA ESTRATEGIA DE SAUDE DA FAMILIA',
    '322415': 'AUXILIAR EM SAUDE BUCAL',
    
    '223293': 'CIRURGIAO DENTISTA DA ESTRATEGIA DE SAUDE DA FAMILIA',
    '223208': 'CIRURGIAO DENTISTA CLINICO GERAL',
    '223212': 'CIRURGIAO DENTISTA ENDODONTISTA',


    '223565': 'ENFERMEIRO DA ESTRATEGIA DE SAUDE DA FAMILIA',
    '223505': 'ENFERMEIRO',

    '322245': 'TECNICO DE ENFERMAGEM DA ESTRATEGIA DE SAUDE DA FAMILIA',
    '322205': 'TÉCNICO DE ENFERMAGEM',

    '515105': 'AGENTE COMUNITARIO DE SAUDE',
    '515140': 'AGENTE DE COMBATE AS ENDEMIAS',
    '352210': 'AGENTE DE SAUDE PÚBLICA',
    
    '142105': 'GERENTE ADMINISTRATIVO',
    '131210': 'GERENTE DE SERVIÇOS DE SAÚDE',

    '411010': 'ASSISTENTE ADMINISTRATIVO',

    '251605': 'ASSISTENTE SOCIAL',
    
    '223430': 'FARMACEUTICO EM SAUDE PUBLICA',
    '223405' :'FARMACEUTICO',
    
    '223710' :'NUTRICIONISTA',

    '251510': 'PSICOLOGO CLINICO',
    '223605': 'FISIOTERAPEUTA GERAL',
    '223810': 'FONOAUDIOLOGO',
    '2241E1' : 'PROFISSIONAL DE EDUCACAO FISICA NA SAUDE',

}



var fruits = ['apple', 'banana', 'grapes', 'mango', 'orange'];





/**
 * Array filters items based on search criteria (query)
 */
function filterCBO(listacbo, profisional) {
    return profisional.filter(function (el) {
        return listacbo.includes(el.co_cbo)
    })
}

// console.log(filterItems('223505', lotacao)); // ['apple', 'grapes']]
// console.log(filterItems(['515105','223505'],lotacao)); // ['apple', 'grapes']

///console.log(filterItems('322245',lotacao)); // ['apple', 'grapes']