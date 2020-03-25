<?php

namespace App\Imports;

use App\COVID;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class COVIDImportCollection implements ToCollection {
 /**
  * @param array $row
  *
  * @return COVID|null
  */
 public function collection(Collection $rows) {
  // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
  // $out->writeln($row);

  foreach ($rows as $row) {
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

   COVID::updateOrCreate([
    'id_caso' => $row[0],
   ],
    [
     'sexo'         => $row[1],
     'idade'        => $row[2],
     'cep'          => $row[6],
     'municipio'    => $row[7],
     'bairro'       => $row[8],
     'dt_resultado' => $resultado,
     'dt_coleta'    => $coleta,
     'resultado'    => $row[3],
    ]
   );
  }
 }
}
