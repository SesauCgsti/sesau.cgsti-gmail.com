<?php

namespace App\Http\Controllers;

use \App\COVID;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function painel() {
        $dados               = COVID::get('resultado');
        $lista['confirmado'] = 0;
        $lista['suspeito']   = 0;
        $lista['descartado'] = 0;
        $lista['total']      = 0;

//$lista['total']=0;

        foreach ($dados as $key => $resultado) {
            if ('CONFIRMADO' == $resultado->resultado) {
                $lista['confirmado']++;
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

        }

        return view('painel', compact('lista'));
    }

    public function index() {
        $dados               = COVID::get('resultado');
        $lista['confirmado'] = 0;
        $lista['suspeito']   = 0;
        $lista['descartado'] = 0;
        $lista['total']      = 0;

//$lista['total']=0;

        foreach ($dados as $key => $resultado) {
            if ('CONFIRMADO' == $resultado->resultado) {
                $lista['confirmado']++;
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

        }

        return view('home', compact('lista'));
    }
}
