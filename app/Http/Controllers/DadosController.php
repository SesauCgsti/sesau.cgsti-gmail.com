<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\COVID;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

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

 public function casosDiarios(Request $request) {
  if ('' != $request->inicio && '' != $request->fim) {

   return COVID::where('consultacep', true)
    ->whereDate('dt_coleta', '>=', $request->inicio)
    ->whereDate('dt_coleta', '<=', $request->fim)
    ->get(['cep', 'bairro', 'lat', 'lng', 'sexo', 'idade', 'municipio', 'dt_coleta', 'dt_resultado', 'resultado']);
  }

  $datas = COVID::groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
  //return $datas;

  $dados = COVID::orderBy('dt_coleta')->get(['dt_coleta', 'resultado']);
$lista['confirmados']=[];
$lista['notificados']=[];
$lista['descartados']=[];
$lista['total']=[];
  
  $confirmado = 0;
  $notificado = 0;
  $descartado = 0;
  $total=0;
  $t_confirmado = 0;
  $t_notificado = 0;
  $t_descartado = 0;

  foreach ($datas as $dia) {
   $confirmado = 0;
   $notificado = 0;
   $descartado = 0;

   foreach ($dados as $coleta) {
    $out = new \Symfony\Component\Console\Output\ConsoleOutput();
    $out->writeln($coleta->dt_coleta);
    $out->writeln($dia->dt_coleta);
    $out->writeln($coleta->resultado);

    if ($coleta->dt_coleta == $dia->dt_coleta) {
     if ("DESCARTADO" == $coleta->resultado) {
      $descartado++;
      $total++;
      $t_descartado++;
     }
     if ("CONFIRMADO" == $coleta->resultado) {
      $confirmado++;
      $total++;
      $t_confirmado++;
     }
     if ("AGUARDANDO RESULTADO" == $coleta->resultado) {
      $notificado++;
      $total++;
      $t_notificado++;
     }

    }

    
  
   }
  
   array_push($lista['confirmados'],['data' => $dia->dt_coleta, 'total' => $confirmado]);
   array_push($lista['notificados'],['data' => $dia->dt_coleta, 'total' => $notificado]);
   array_push($lista['descartados'],['data' => $dia->dt_coleta, 'total' => $descartado]);
  //  "notificado" => $notificado, 'descartado' => $descartado]);

   //   $dados[$dia] =$dados->countBy(function ($dias) {
   //     return $dias->dt_coleta == $dia->dt_coleta;

   // });
  }
  array_push($lista['total'],['total'=>$total,'t_notificado'=>$t_notificado,'t_confirmado'=>$t_confirmado,'t_descartado'=>$t_descartado]);

  //$dados; //=$dados->groupBy('resultado');
  return $lista;

 }




 public function casosDiariosSomatorio(Request $request) {
    if ('' != $request->inicio && '' != $request->fim) {
  
     return COVID::where('consultacep', true)
      ->whereDate('dt_coleta', '>=', $request->inicio)
      ->whereDate('dt_coleta', '<=', $request->fim)
      ->get(['cep', 'bairro', 'lat', 'lng', 'sexo', 'idade', 'municipio', 'dt_coleta', 'dt_resultado', 'resultado']);
    }
  
    $datas = COVID::groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
    //return $datas;
  
    $dados = COVID::orderBy('dt_coleta')->get(['dt_coleta', 'resultado']);
  $lista['confirmados']=[];
  $lista['notificados']=[];
  $lista['descartados']=[];
  $lista['total']=[];
    
    $confirmado = 0;
    $notificado = 0;
    $descartado = 0;
    $total=0;
    $t_confirmado = 0;
    $t_notificado = 0;
    $t_descartado = 0;
  
    foreach ($datas as $dia) {
  
     foreach ($dados as $coleta) {
      $out = new \Symfony\Component\Console\Output\ConsoleOutput();
      $out->writeln($coleta->dt_coleta);
      $out->writeln($dia->dt_coleta);
      $out->writeln($coleta->resultado);
  
      if ($coleta->dt_coleta == $dia->dt_coleta) {
       if ("DESCARTADO" == $coleta->resultado) {
        $descartado++;
        $total++;
        $t_descartado++;
       }
       if ("CONFIRMADO" == $coleta->resultado) {
        $confirmado++;
        $total++;
        $t_confirmado++;
       }
       if ("AGUARDANDO RESULTADO" == $coleta->resultado) {
        $notificado++;
        $total++;
        $t_notificado++;
       }
  
      }
  
      
    
     }
    
     array_push($lista['confirmados'],['data' => $dia->dt_coleta, 'total' => $confirmado]);
     array_push($lista['notificados'],['data' => $dia->dt_coleta, 'total' => $notificado]);
     array_push($lista['descartados'],['data' => $dia->dt_coleta, 'total' => $descartado]);
  
    }
    array_push($lista['total'],['total'=>$total,'t_notificado'=>$t_notificado,'t_confirmado'=>$t_confirmado,'t_descartado'=>$t_descartado]);
  
  
    return $lista;
  
   }



  


   public function casosSexo(Request $request) {
  
    $datas = COVID::where('resultado','CONFIRMADO')->groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
    //return $datas;
  
    $dados = COVID::where('resultado','CONFIRMADO')->orderBy('dt_coleta')->get(['dt_coleta', 'sexo']);
  $lista['feminino']=[];
  $lista['masculino']=[];
  $lista['naoInformado']=[];
  
  $lista['total']=[];
    
    $masculino = 0;
    $feminino = 0;
    $naoInformado=0;
    $descartado = 0;
    $total=0;

  $t_naoInformado=0;
  $t_masculino=0;
  $t_feminino=0;
  
  ///funçao para fazer o range de datas
  $min= $datas->min('dt_coleta');

  $dtmin = Carbon::createFromFormat('Y-m-d H:i:s', $min.' 00:00:00');//->format('Y-m-d');
  $dtmax = Carbon::now();
  $datasnot=[];
 
 $dtcorrente=$dtmin;
 $cont=1;
  while ($dtcorrente <= $dtmax) {
 array_push($datasnot,$dtcorrente->format('Y-m-d'));
 $cont++;
 $dtcorrente->addDay(1); 
 
  }
 
 
     $qtddia=1;
 
     foreach ($datasnot as $dia) {

  
     foreach ($dados as $coleta) {
      $out = new \Symfony\Component\Console\Output\ConsoleOutput();
      $out->writeln($coleta->dt_coleta);
      $out->writeln($dia);
      $out->writeln($coleta->sexo);
  
      if ($coleta->dt_coleta == $dia) {
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
    
     array_push($lista['feminino'],['data' => $dia, 'total' => $feminino]);
     array_push($lista['masculino'],['data' => $dia, 'total' => $masculino]);
     array_push($lista['naoInformado'],['data' => $dia, 'total' => $naoInformado]);
  
    }
    array_push($lista['total'],['total'=>$total,'t_masculino'=>$t_masculino,'t_feminino'=>$t_feminino,'t_naoInformado'=>$naoInformado]);
  
  
    return $lista;
  
   }
  



   public function casosIdade(Request $request) {
  
    $datas = COVID::where('resultado','CONFIRMADO')->groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
    //return $datas;
  
    $dados = COVID::where('resultado','CONFIRMADO')->orderBy('dt_coleta')->get(['dt_coleta', 'sexo']);
  $lista['feminino']=[];
  $lista['masculino']=[];
  $lista['naoInformado']=[];
  
  $lista['total']=[];
    
    $masculino = 0;
    $feminino = 0;
    $naoInformado=0;
    $descartado = 0;
    $total=0;

  $t_naoInformado=0;
  $t_masculino=0;
  $t_feminino=0;

  ///funçao para fazer o range de datas
  $min= $datas->min('dt_coleta');

  $dtmin = Carbon::createFromFormat('Y-m-d H:i:s', $min.' 00:00:00');//->format('Y-m-d');
  $dtmax = Carbon::now();
  $datasnot=[];
 
 $dtcorrente=$dtmin;
 $cont=1;
  while ($dtcorrente <= $dtmax) {
 array_push($datasnot,$dtcorrente->format('Y-m-d'));
 $cont++;
 $dtcorrente->addDay(1); 
 
  }
 
 
     $qtddia=1;
 
     foreach ($datasnot as $dia) {

  
     foreach ($dados as $coleta) {
      
      if ($coleta->dt_coleta == $dia) {
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
    
     array_push($lista['feminino'],['data' => $dia, 'total' => $feminino]);
     array_push($lista['masculino'],['data' => $dia, 'total' => $masculino]);
     array_push($lista['naoInformado'],['data' => $dia, 'total' => $naoInformado]);
  
    }
    array_push($lista['total'],['total'=>$total,'t_masculino'=>$t_masculino,'t_feminino'=>$t_feminino,'t_naoInformado'=>$naoInformado]);
  
  
    return $lista;
  
   }



   public function casosConfirmado(Request $request) {
  
    $datas = COVID::where('resultado','CONFIRMADO')->groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
    //return $datas;
  
    $dados = COVID::where('resultado','CONFIRMADO')->orderBy('dt_coleta')->get(['dt_coleta']);
  $lista['confirmado']=[];

  $lista['total']=[];
    
    $confirmado = 0;
 
    $total=0;

 
    foreach ($datas as $dia) {
  
     foreach ($dados as $coleta) {
      $out = new \Symfony\Component\Console\Output\ConsoleOutput();
      $out->writeln($coleta->dt_coleta);
      $out->writeln($dia->dt_coleta);
     
  
      if ($coleta->dt_coleta == $dia->dt_coleta) {
             
        
        $total++;
        
        $confirmado++;
       }
  
     
  
      
    
     }
    
     array_push($lista['confirmado'],['data' => $dia->dt_coleta, 'total' => $confirmado]);
   
  
    }
    array_push($lista['total'],['total'=>$total]);
  
  
    return $lista;
  
   }
  




   public function casosConfirmadoDIA(Request $request) {
  
    $datas = COVID::where('resultado','CONFIRMADO')->groupBy('dt_coleta')->orderBy('dt_coleta')->get('dt_coleta');
    //return $datas;
 
    $dados = COVID::where('resultado','CONFIRMADO')->orderBy('dt_coleta')->get(['dt_coleta']);
  $lista['confirmado']=[];

  $lista['total']=[];
    
    $confirmado = 0;
 
    $total=0;

 $min= $datas->min('dt_coleta');

 $dtmin = Carbon::createFromFormat('Y-m-d H:i:s', $min.' 00:00:00');//->format('Y-m-d');
 $dtmax = Carbon::now();
 $datasnot=[];

$dtcorrente=$dtmin;
$cont=1;
 while ($dtcorrente <= $dtmax) {
array_push($datasnot,$dtcorrente->format('Y-m-d'));
$cont++;
$dtcorrente->addDay(1); 

 }


    $qtddia=1;

    foreach ($datasnot as $dia) {
  
     foreach ($dados as $coleta) {
      $out = new \Symfony\Component\Console\Output\ConsoleOutput();
      $out->writeln($coleta->dt_coleta);
      $out->writeln($dia);
     
  
      if ($coleta->dt_coleta == $dia) {
         
        
        $total++;
        
        $confirmado++;
       }
  
     
  
      
    
     }
    
     array_push($lista['confirmado'],['data' => $dia, 'total' => $confirmado,'qtdia'=>$qtddia++]);
   
  
    }
    array_push($lista['total'],['total'=>$total]);
  
  
    return $lista;
  
   }
  

}
