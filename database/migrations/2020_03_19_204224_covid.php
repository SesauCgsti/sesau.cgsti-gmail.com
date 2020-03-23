<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Covid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('covid', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_caso');
            $table->string('cep')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('sexo')->nullable();
            $table->string('idade')->nullable();
            $table->string('bairro')->nullable();
            $table->string('municipio')->nullable();
            $table->string('resultado')->nullable();
            $table->date('dt_coleta')->nullable();
            $table->date('dt_resultado')->nullable();
            $table->boolean('consultacep')->default(false);
            
            
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('covid');
    }
}
