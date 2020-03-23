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

 protected $fillable = [ 'id_caso','cep', 'id', 'lat', 'lng', 'consultacep', 'sexo','idade','bairro','resultado','municipio','dt_coleta','dt_resultado'
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


 
}



