<?php


namespace App\Http\Controllers;
use App\Imports\COVIDImport;
use App\COVID;
use App\Imports\COVIDImportCollection;
use Excel;
use Illuminate\Http\Request;

class CovidController extends Controller {
  
  /**
   * index abrir formulario para upar excel
   *
   * @return void
   */
  public function index() {

  
        return view('covid.excel');
  }


  public function covidExcel(Request $request) {

  // $upload = $request->excel->storeAs('public/excel', 'covid.xlsx');
  
  //   $out = new \Symfony\Component\Console\Output\ConsoleOutput();
  //   $out->writeln("importando excel");
    //  with('status','importando xml');
  
    $upload = $request->excel->storeAs('public/excel', 'covid.xlsx');
  
    if (!$upload) {
     return redirect()
      ->back()
      ->with('error', 'Falha ao fazer upload')
      ->withInput();
    }
  
    return redirect('covid/excel')->with('status', 'Importando dados para o banco');
  
   }
  

  public function excel() {

  
    //função que lê o excel e persiste os valores no banco 
$url = Excel::import(
  new COVIDImportCollection,
  'storage/excel/covid.xlsx');

//return $url;
  return  redirect('covid/cep')->with('status', 'Atualizando dados de CEP');

  }

  public function mapa() {

  return view('covid.mapa');

  }

  public function mapaAgrupado() {

    return view('covid.mapaAgrupado');
  
    }
  


  public function cep() {

   COVID::updateCep();
    $contador = COVID::where('consultacep',false)->count();

    $notificacoes=COVID::where('lat','=',null)->get();
     return view('covid.tabela',compact(['contador','notificacoes']));
//     redirect('/covid/cep',compact('contador'));

  }


  public function grafico() {
    return view('covid.grafico');

  }


  public function graficosexo() {
    return view('covid.graficosexo');

  }

  public function graficosomatorio() {
    return view('covid.graficosomatorio');

  }
  public function graficodiario() {
    return view('covid.graficodiario');

  }
  public function graficoevolucaofiltro() {
    return view('covid.graficoevolucaofiltro');

  }
  public function graficoevolucao() {
    return view('covid.graficoevolucao');

  }

  public function graficoidade() {
    return view('covid.graficoidade');

  }

  public function graficoconfirmado() {
    return view('covid.graficoconfirmado');

  }

  public function graficoconfirmadodia() {
    return view('covid.graficoconfirmadoDia');

  }

  public function log() {
    return Aihms::log();

  }

  public function causa($causa) {
    return Aihms::causaFiltro($causa);
  }

  public function GPS(Request $x) {
    error_log($x);

    shell_exec(`echo $x >> /home/jonatas/trabalho-projetos/geolocalizacao_aih/AihServer/log/gps.txt`);

  }





// public function covidExcel(Request $request) {

  
//   try {
//     Excel::import(
//       new COVIDImportCollection,
//       $request->excel);
    
//     //return $url;
//       return  redirect('covid/cep')->with('status', 'Atualizando dados de CEP');
  
//   } catch (\Throwable $th) {
//     return redirect()
//     ->back()
//     ->with('error', 'Falha ao fazer upload')
//     ->withInput();
//   }

//  }

}