<?php

namespace App;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class COVID extends Model {

 protected $table = 'covid';

//  protected $casts = [
 //     'dt_coleta' => 'datetime:d-m-Y',
 // ];

 protected $fillable = ['id_caso', 'cep', 'id', 'lat', 'lng', 'consultacep', 'sexo', 'idade', 'bairro', 'resultado', 'municipio', 'dt_coleta', 'dt_resultado',
 ];
 public $timestamps = true;

 public static function updateCep() {

  $lista_sem_cep = COVID::where('consultacep', false)->where('cep', '!=', null)->select(['id', 'cep', 'lat', 'lng'])->take(10)->get();

  foreach ($lista_sem_cep as $causa) {
   shell_exec('echo ' . $causa . ' >> /home/jonatas/trabalho-projetos/geolocalizacao_aih/covid/log/covid.txt');
   $consulta = CepAberto::where('cep', $causa->cep)->first();

   if ($consulta) {
    error_log('dados do banco');
    error_log($consulta);
    $causa->lat         = $consulta->lat;
    $causa->lng         = $consulta->lng;
    $causa->consultacep = true;
    $causa->save();
    //return $consulta;
   } else {

    $client = new \GuzzleHttp\Client();
    $busca;
    $api_key = 'Token token=94ba7ff2aa84b7f5d6588dbd4a8a26f7';
    $url     = 'http://www.cepaberto.com/api/v3/cep?cep=' . $causa->cep;

    try {
     error_log('Realizando a consulta 1');
     $busca = $client->request(
      'GET',
      $url,
      ['headers' => [
       "Content-Type"  => "application/json",
       "Authorization" => $api_key,
      ],
      ]
     );
     sleep(4);

    } catch (\Throwable $th) {
     // dd($th);
     error_log($th);
     try {
      error_log('Realizando a consulta 2');
      sleep(8);
      $busca = $client->request(
       'GET',
       $url,
       ['headers' => [
        "Content-Type"  => "application/json",
        "Authorization" => $api_key,
       ],
       ]
      );
      sleep(4);
     } catch (\Throwable $th) {
      error_log($th);
     }
    }
    try {
     //code...

     $conteudo = $busca->getBody()->getContents();
     error_log($conteudo);
     error_log($busca->getStatusCode());

     if ($busca->getStatusCode() === 200) {
      if ('{}' == $conteudo) {
       error_log('Cep nao encontrado');
       shell_exec(`echo $causa->cep >> /home/jonatas/trabalho-projetos/geolocalizacao_aih/covid/log/cepnaoencontrados.txt`);
       shell_exec(`echo $causa >> /home/jonatas/trabalho-projetos/geolocalizacao_aih/covid/log/causassemcep.txt`);
       $causa->consultacep = true;
       $causa->save();
       continue;
       //return 1;
      } else {
       $retorno = json_decode($conteudo);
       if ($retorno->cep && $retorno->latitude) {
        $consulta = CepAberto::create([
         'cep'        => $retorno->cep,
         'logradouro' => $retorno->logradouro,
         'bairro'     => $retorno->bairro,
         'lat'        => $retorno->latitude,
         'lng'        => $retorno->longitude,
         'altitude'   => $retorno->altitude,
         'ddd'        => $retorno->cidade->ddd,
         'cidade'     => $retorno->cidade->nome,
         'estado'     => $retorno->estado->sigla,
         'ibge'       => $retorno->cidade->ibge,
        ]);

        $causa->lat         = $consulta->lat;
        $causa->lng         = $consulta->lng;
        $causa->consultacep = true;
        $causa->save();
       }
      }
     }

    } catch (\Throwable $th) {
     //throw $th;
    }
   }
  }

  //return redirect('/covid');
 }

 public static function casosConfirmadoSomados() {
  $datas               = COVID::where('resultado', 'CONFIRMADO')->get('dt_resultado')->min('dt_resultado');
  $dados               = COVID::where('resultado', 'CONFIRMADO')->orderBy('dt_resultado')->get(['dt_resultado']);
  $lista['confirmado'] = [];
  $lista['total']      = [];
  $confirmado          = 0;
  $total               = 0;
  $min                 = $datas;

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

   foreach ($dados as $coleta) {

    if ($coleta->dt_resultado == $dia) {
     $total++;
     $confirmado++;
    }
   }
   array_push($lista['confirmado'], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
  }
  array_push($lista['total'], $total);
  return $lista;

 }

 public static function casosDescartadoDIA() {
  $datas               = COVID::where('resultado', 'DESCARTADO')->get('dt_resultado')->min('dt_resultado');
  $dados               = COVID::where('resultado', 'DESCARTADO')->orderBy('dt_resultado')->get(['dt_resultado']);
  $lista['descartado'] = [];
  $lista['total']      = [];
  $confirmado          = 0;
  $total               = 0;
  $min                 = $datas;

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
   $confirmado = 0;
   foreach ($dados as $coleta) {

    if ($coleta->dt_resultado == $dia) {
     $total++;
     $confirmado++;
    }
   }
   array_push($lista['descartado'], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
  }
  array_push($lista['total'], $total);
  return $lista;

 }

 public static function casosDescartadoSomados() {
  $datas               = COVID::where('resultado', 'DESCARTADO')->get('dt_resultado')->min('dt_resultado');
  $dados               = COVID::where('resultado', 'DESCARTADO')->orderBy('dt_resultado')->get(['dt_resultado']);
  $lista['descartado'] = [];
  $lista['total']      = [];
  $confirmado          = 0;
  $total               = 0;
  $min                 = $datas;

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
   //    $confirmado = 0;
   foreach ($dados as $coleta) {

    if ($coleta->dt_resultado == $dia) {
     $total++;
     $confirmado++;
    }
   }
   array_push($lista['descartado'], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
  }
  array_push($lista['total'], $total);
  return $lista;

 }

 public static function casosConfirmadoDiarios() {
  $datas               = COVID::where('resultado', 'CONFIRMADO')->get('dt_resultado')->min('dt_resultado');
  $dados               = COVID::where('resultado', 'CONFIRMADO')->orderBy('dt_resultado')->get(['dt_resultado']);
  $lista['confirmado'] = [];
  $lista['total']      = [];
  $confirmado          = 0;
  $total               = 0;
  $min                 = $datas;

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
   $confirmado = 0;
   foreach ($dados as $coleta) {

    if ($coleta->dt_resultado == $dia) {
     $total++;
     $confirmado++;
    }

   }
   array_push($lista['confirmado'], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
  }
  array_push($lista['total'], $total);
  return $lista;

 }

 public static function painel() {

  $dados               = COVID::get('resultado');
  $lista['confirmado'] = 0;
  $lista['suspeito']   = 0;
  $lista['descartado'] = 0;
  $lista['excluido']   = 0;
  $lista['obito']      = 0;
  $lista['total']      = 0;

  foreach ($dados as $key => $resultado) {
   if ('CONFIRMADO' == $resultado->resultado) {
    $lista['confirmado']++;
    $lista['total']++;
   }
   if ('EXCLUIDO' == $resultado->resultado) {
    $lista['excluido']++;
    $lista['total']++;
   }
   if ('AGUARDANDO RESULTADO' == $resultado->resultado) {
    $lista['suspeito']++;
    $lista['total']++;
   }
   if ('DESCARTADO' == $resultado->resultado) {
    $lista['descartado']++;
    $lista['total']++;
   }
   if ('OBITO' == $resultado->resultado) {
    $lista['obito']++;
    $lista['total']++;
   }

  }
  return $lista;
 }

 public static function obitosSomados() {
  $datas          = COVID::where('resultado', 'OBITO')->get('dt_resultado')->min('dt_resultado');
  $dados          = COVID::where('resultado', 'OBITO')->orderBy('dt_resultado')->get(['dt_resultado']);
  $lista['obito'] = [];
  $lista['total'] = [];
  $confirmado     = 0;
  $total          = 0;
  $min            = $datas;

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
   //    $confirmado = 0;
   foreach ($dados as $coleta) {

    if ($coleta->dt_resultado == $dia) {
     $total++;
     $confirmado++;
    }
   }
   array_push($lista['obito'], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
  }
  array_push($lista['total'], $total);
  return $lista;

 }

 public static function resultadoSomados($valor) {
  $datas = COVID::where('resultado', $valor)->get('dt_resultado')->min('dt_resultado');
  if ($datas == null) {
   $lista          = [];
   $lista[$valor]  = [['data' => Carbon::now()->format('Y-m-d'), 'total' => 0, 'qtdia' => 0]];
   $lista['total'] = 0;
   return $lista;
  }

  $dados          = COVID::where('resultado', $valor)->orderBy('dt_resultado')->get(['dt_resultado']);
  $lista[$valor]  = [];
  $lista['total'] = [];
  $confirmado     = 0;
  $total          = 0;
  $min            = $datas;

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
   //    $confirmado = 0;
   foreach ($dados as $coleta) {

    if ($coleta->dt_resultado == $dia) {
     $total++;
     $confirmado++;
    }
   }
   array_push($lista[$valor], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
  }
  $lista['total']= $total;
  return $lista;

 }

 public static function coletadoSomados($valor) {
    $datas = COVID::where('resultado', $valor)->get('dt_coleta')->min('dt_coleta');
    if ($datas == null) {
     $lista          = [];
     $lista[$valor]  = [['data' => Carbon::now()->format('Y-m-d'), 'total' => 0, 'qtdia' => 0]];
     $lista['total'] = 0;
     return $lista;
    }
  
    $dados          = COVID::where('resultado', $valor)->orderBy('dt_coleta')->get(['dt_coleta']);
    $lista[$valor]  = [];
    $lista['total'] = [];
    $confirmado     = 0;
    $total          = 0;
    $min            = $datas;
  
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
     //    $confirmado = 0;
     foreach ($dados as $coleta) {
  
      if ($coleta->dt_coleta == $dia) {
       $total++;
       $confirmado++;
      }
     }
     array_push($lista[$valor], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
    }
    $lista['total']= $total;
    return $lista;
  
   }
  

   public static function resultadoDiario($valor) {
    $datas = COVID::where('resultado', $valor)->get('dt_resultado')->min('dt_resultado');
    if ($datas == null) {
     $lista          = [];
     $lista[$valor]  = [['data' => Carbon::now()->format('Y-m-d'), 'total' => 0, 'qtdia' => 0]];
     $lista['total'] = 0;
     return $lista;
    }
  
    $dados          = COVID::where('resultado', $valor)->orderBy('dt_resultado')->get(['dt_resultado']);
    $lista[$valor]  = [];
    $lista['total'] = [];
    $confirmado     = 0;
    $total          = 0;
    $min            = $datas;
  
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
        $confirmado = 0;
     foreach ($dados as $coleta) {
  
      if ($coleta->dt_resultado == $dia) {
       $total++;
       $confirmado++;
      }
     }
     array_push($lista[$valor], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
    }
    $lista['total']= $total;
    return $lista;
  
   }

   public static function coletadoDiario($valor) {
    $datas = COVID::where('resultado', $valor)->get('dt_coleta')->min('dt_coleta');
    if ($datas == null) {
     $lista          = [];
     $lista[$valor]  = [['data' => Carbon::now()->format('Y-m-d'), 'total' => 0, 'qtdia' => 0]];
     $lista['total'] = 0;
     return $lista;
    }
  
    $dados          = COVID::where('resultado', $valor)->orderBy('dt_coleta')->get(['dt_coleta']);
    $lista[$valor]  = [];
    $lista['total'] = [];
    $confirmado     = 0;
    $total          = 0;
    $min            = $datas;
  
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
        $confirmado = 0;
     foreach ($dados as $coleta) {
  
      if ($coleta->dt_coleta == $dia) {
       $total++;
       $confirmado++;
      }
     }
     array_push($lista[$valor], ['data' => $dia, 'total' => $confirmado, 'qtdia' => $qtddia++]);
    }
    $lista['total']= $total;
    return $lista;
  
   }
  


}