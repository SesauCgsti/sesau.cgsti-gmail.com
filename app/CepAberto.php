<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CepAberto extends Model
{
    
 protected $table = 'coordenadas';
 protected $connection = 'cepaberto';
 protected $fillable = [
    'cep' ,
    'logradouro' ,
    'bairro' ,
    'lat' ,
    'lng' ,
    'altitude' ,
    'ddd' ,
    'cidade' ,
    'estado' ,
    'ibge' ,
    'id'
 ];
 public $timestamps = false;


}
