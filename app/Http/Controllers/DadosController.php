<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\COVID;

class DadosController extends Controller {

 /**
  * coordenadas retorna os dados para serem plotados no mapa
  * o request com campos de data é opcional caso nao venha nenhum irá buscar todos os dados;
  *
  * precisa validar quando a data inicial e maior q a final (NAO IMPLEMENTANDO AINDA)
  * @param  mixed $request
  * @return void
  */

 public function coordenadas(Request $request) {

  if ('' != $request->inicio && '' != $request->fim) {

   return COVID::whereDate('dt_coleta', '>=', $request->inicio)
    ->whereDate('dt_coleta', '<=', $request->fim)
    ->get(['cep', 'bairro', 'lat', 'lng', 'sexo', 'idade', 'municipio', 'dt_coleta', 'dt_resultado', 'resultado']);
  }

  return COVID::get(['cep', 'bairro', 'lat', 'lng', 'sexo', 'idade', 'municipio', 'dt_coleta', 'dt_resultado', 'resultado']);

 }

 public function coordenadasConfirmado(Request $request) {

  if ('' != $request->inicio && '' != $request->fim) {

   return COVID::whereDate('dt_resultado', '>=', $request->inicio)
    ->whereDate('dt_resultado', '<=', $request->fim)
    ->get(['id_caso', 'cep', 'bairro', 'lat', 'lng', 'sexo', 'idade', 'municipio', 'dt_coleta', 'dt_resultado', 'resultado']);
  }

  return COVID::get(['id_caso', 'cep', 'bairro', 'lat', 'lng', 'sexo', 'idade', 'municipio', 'dt_coleta', 'dt_resultado', 'resultado']);

 }

 public function casosDiarios(Request $request) {


  $dadosc = COVID::resultadoDiario('CONFIRMADO');
  //return $dadosc;
  $lista['confirmados'] = $dadosc['CONFIRMADO'];

  $dadosd= COVID::resultadoDiario('DESCARTADO');
  $dadoso= COVID::resultadoDiario('OBITO');
  $dadose= COVID::resultadoDiario('EXCLUIDO');
  $dadosl= COVID::coletadoDiario('AGUARDANDO RESULTADO');
  $lista['descartados'] = $dadosd['DESCARTADO'];

  $lista['obitos'] = $dadoso['OBITO'];
  $lista['excluidos'] = $dadose['EXCLUIDO'];

  $lista['notificados'] = $dadosl['AGUARDANDO RESULTADO'];
  $lista['total']=[];
  
  array_push($lista['total'],
   ['total'       => (intval($dadosl['total']) + intval($dadosc['total']) + intval($dadosd['total']) + intval($dadoso['total']) + intval($dadose['total'])),
    't_notificado' => $dadosl['total'],
    't_confirmado' => $dadosc['total'],
    't_descartado' => $dadosd['total'],
    't_obito'      => $dadoso['total'],
    't_excluido'   => $dadose['total'],

   ]);
   return $lista;

 }

 public function casosDiariosSomatorio(Request $request) {

  $dadosc = COVID::resultadoSomados('CONFIRMADO');

  $dadosd = COVID::resultadoSomados('DESCARTADO');

  $dadosl = COVID::coletadoSomados('AGUARDANDO RESULTADO');

  $dadose = COVID::resultadoSomados('EXCLUIDO');
  $dadoso = COVID::resultadoSomados('OBITO');

  $lista['descartados'] = $dadosd['DESCARTADO'];

  $lista['confirmados'] = $dadosc['CONFIRMADO'];
  $lista['excluidos']   = $dadose['EXCLUIDO'];
  $lista['obitos']      = $dadoso['OBITO'];

  $lista['notificados'] = $dadosl['AGUARDANDO RESULTADO'];

  $lista['total'] = [];

  array_push($lista['total'],
   ['total'       => (intval($dadosl['total']) + intval($dadosc['total']) + intval($dadosd['total']) + intval($dadoso['total']) + intval($dadose['total'])),
    't_notificado' => $dadosl['total'],
    't_confirmado' => $dadosc['total'],
    't_descartado' => $dadosd['total'],
    't_obito'      => $dadoso['total'],
    't_excluido'   => $dadose['total'],

   ]);

  return $lista;

 }

 public function casosSexo(Request $request) {

  $datas = COVID::where('resultado', 'CONFIRMADO')->groupBy('dt_resultado')->orderBy('dt_resultado')->get('dt_resultado');
  //return $datas;

  $dados                 = COVID::where('resultado', 'CONFIRMADO')->orderBy('dt_resultado')->get(['dt_resultado', 'sexo']);
  $lista['feminino']     = [];
  $lista['masculino']    = [];
  $lista['naoInformado'] = [];

  $lista['total'] = [];

  $masculino    = 0;
  $feminino     = 0;
  $naoInformado = 0;
  $descartado   = 0;
  $total        = 0;

  $t_naoInformado = 0;
  $t_masculino    = 0;
  $t_feminino     = 0;

  ///funçao para fazer o range de datas
  $min = $datas->min('dt_resultado');

  $dtmin    = Carbon::createFromFormat('Y-m-d H:i:s', $min . ' 00:00:00'); //->format('Y-m-d');
  $dtmax    = Carbon::now();
  $datasnot = [];

  $dtcorrente = $dtmin;
  $cont       = 1;
  while ($dtcorrente <= $dtmax) {
   array_push($datasnot, $dtcorrente->format('Y-m-d'));
   $cont++;
   $dtcorrente->addDay(1);

  }
  ///final funcao data

  $qtddia = 1;

  foreach ($datasnot as $dia) {

   foreach ($dados as $coleta) {
    $out = new \Symfony\Component\Console\Output\ConsoleOutput();
    $out->writeln($coleta->dt_resultado);
    $out->writeln($dia);
    $out->writeln($coleta->sexo);

    if ($coleta->dt_resultado == $dia) {
     if ("F" == $coleta->sexo) {
      $feminino++;
      $total++;
      $t_feminino++;
     }
     if ("M" == $coleta->sexo) {
      $masculino++;
      $total++;
      $t_masculino++;
     }
     if ("F" != $coleta->sexo && "M" != $coleta->sexo) {
      $naoInformado++;
      $total++;
      $t_naoInformado++;
     }

    }

   }

   array_push($lista['feminino'], ['data' => $dia, 'total' => $feminino]);
   array_push($lista['masculino'], ['data' => $dia, 'total' => $masculino]);
   array_push($lista['naoInformado'], ['data' => $dia, 'total' => $naoInformado]);

  }
  array_push($lista['total'], ['total' => $total, 't_masculino' => $t_masculino, 't_feminino' => $t_feminino, 't_naoInformado' => $naoInformado]);

  return $lista;

 }

 public function casosIdade(Request $request) {

  $datas = COVID::where('resultado', 'CONFIRMADO')->groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
  //return $datas;

  $dados = COVID::where('resultado', 'CONFIRMADO')->get(['idade']);

  $um     = 0;
  $dois   = 0;
  $tres   = 0;
  $quatro = 0;
  $cinco  = 0;
  $seis   = 0;
  $sete   = 0;
  $oito   = 0;
  $total  = 0;
  foreach ($dados as $idade) {
   $total++;

   if (strstr($idade, 'M') || strstr($idade, 'D')) {
    $um++;
   }

   if ($idade->idade >= 1 && $idade->idade <= 10) {
    $dois++;
   }
   if ($idade->idade >= 11 && $idade->idade <= 20) {
    $tres++;
   }
   if ($idade->idade >= 21 && $idade->idade <= 30) {
    $quatro++;
   }
   if ($idade->idade >= 31 && $idade->idade <= 40) {
    $cinco++;
   }
   if ($idade->idade >= 41 && $idade->idade <= 50) {
    $seis++;
   }
   if ($idade->idade >= 51 && $idade->idade <= 60) {
    $sete++;
   }
   if ($idade->idade > 60) {
    $oito++;
   }

  }

  return ['total' => $total,
   'idade'         => [['total' => $um, 'idade' => 'menor 1 ano'], ['total' => $dois, 'idade' => '1 a 10 anos'], ['total' => $tres, 'idade' => '11 a 20 anos'], ['total' => $quatro, 'idade' => '21 a 30 anos'],
    ['total' => $cinco, 'idade' => '31 a 40 anos'], ['total' => $seis, 'idade' => '41 a 50 anos'], ['total' => $sete, 'idade' => '51 a 60 anos'], ['total' => $oito, 'idade' => 'maior 60 anos']]];

//     $lista['feminino']=[];
  //   $lista['masculino']=[];
  //   $lista['naoInformado']=[];

//   $lista['total']=[];

//     $masculino = 0;
  //     $feminino = 0;
  //     $naoInformado=0;
  //     $descartado = 0;
  //     $total=0;

//   $t_naoInformado=0;
  //   $t_masculino=0;
  //   $t_feminino=0;

//   ///funçao para fazer o range de datas
  //   $min= $datas->min('dt_coleta');

//   $dtmin = Carbon::createFromFormat('Y-m-d H:i:s', $min.' 00:00:00');//->format('Y-m-d');
  //   $dtmax = Carbon::now();
  //   $datasnot=[];

//  $dtcorrente=$dtmin;
  //  $cont=1;
  //   while ($dtcorrente <= $dtmax) {
  //  array_push($datasnot,$dtcorrente->format('Y-m-d'));
  //  $cont++;
  //  $dtcorrente->addDay(1);

//   }

//      $qtddia=1;

//      foreach ($datasnot as $dia) {

//      foreach ($dados as $coleta) {

//       if ($coleta->dt_coleta == $dia) {
  //        if ("F" == $coleta->sexo) {
  //         $feminino++;
  //         $total++;
  //         $t_feminino++;
  //        }
  //        if ("M" == $coleta->sexo) {
  //         $masculino++;
  //         $total++;
  //         $t_masculino++;
  //        }
  //        if ("F" != $coleta->sexo && "M" != $coleta->sexo) {
  //         $naoInformado++;
  //         $total++;
  //         $t_naoInformado++;
  //        }

//       }

//      }

//      array_push($lista['feminino'],['data' => $dia, 'total' => $feminino]);
  //      array_push($lista['masculino'],['data' => $dia, 'total' => $masculino]);
  //      array_push($lista['naoInformado'],['data' => $dia, 'total' => $naoInformado]);

//     }
  //     array_push($lista['total'],['total'=>$total,'t_masculino'=>$t_masculino,'t_feminino'=>$t_feminino,'t_naoInformado'=>$naoInformado]);

//     return $lista;

 }

 public function casosConfirmado(Request $request) {

  $dadosc              = COVID::casosConfirmadoSomados();
  $lista['total']      = [['total' => $dadosc['total']]];
  $lista['confirmado'] = $dadosc['confirmado'];

  return $lista;

 }

 public function casosConfirmadoDIA(Request $request) {

  $lista = COVID::casosConfirmadoSomados();
//
  $datas = COVID::where('resultado', 'CONFIRMADO')->groupBy('dt_resultado')->orderBy('dt_resultado')->get('dt_resultado');
  //return $datas;

  $dados = COVID::where('resultado', 'CONFIRMADO')->orderBy('dt_resultado')->get(['dt_resultado']);
//  $lista['confirmado']=[];

  $lista['total'] = [];

  $confirmado = 0;

  $total = 0;

  $min = $datas->min('dt_resultado');

  $dtmin    = Carbon::createFromFormat('Y-m-d H:i:s', $min . ' 00:00:00'); //->format('Y-m-d');
  $dtmax    = Carbon::now(); //->addDay(300);
  $datasnot = [];

  $dtcorrente = $dtmin;
  $cont       = 1;
  while ($dtcorrente <= $dtmax) {
   array_push($datasnot, $dtcorrente->format('Y-m-d'));
   $cont++;
   $dtcorrente->addDay(1);

  }

  $qtddia = 1;

  foreach ($datasnot as $dia) {
   $out = new \Symfony\Component\Console\Output\ConsoleOutput();
   $out->writeln($dia);
   foreach ($dados as $coleta) {

//      $out->writeln($coleta->dt_resultado);

    if ($coleta->dt_resultado == $dia) {

     $total++;

     $confirmado++;
    }

   }

   //   array_push($lista['confirmado'],['data' => $dia, 'total' => $confirmado,'qtdia'=>$qtddia++]);

  }
  array_push($lista['total'], ['total' => $total]);

  return $lista;

 }

}
