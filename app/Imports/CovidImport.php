<?php

namespace App\Imports;

use App\COVID;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class COVIDImport implements ToModel {
 /**
  * @param array $row
  *
  * @return COVID|null
  */
 public function model(array $row) {
  $out = new \Symfony\Component\Console\Output\ConsoleOutput();
  $out->writeln($row[3]);
  $out->writeln($row[4]);
  $coleta = null;

  try {
   $coleta = Carbon::createFromFormat('d/m/Y', $row[4]);
  } catch (\Throwable $th) {
   //throw $th;
  }

  $resultado = null;

  try {
   if ("" != $row[5]) {
    $resultado = Carbon::createFromFormat('d/m/Y', $row[5]);
   }
  } catch (\Throwable $th) {
   //throw $th;
  }

  $out->writeln($coleta);
  $out->writeln($resultado);

  return new COVID([
   'id_caso'      => $row[0],
   'sexo'         => $row[1],
   'idade'        => $row[2],
   'resultado'    => $row[3],
   'dt_coleta'    => $coleta,
   'dt_resultado' => $resultado,
   'cep'          => $row[6],
   'municipio'    => $row[7],
   'bairro'       => $row[8],

  ]);
 }
}
