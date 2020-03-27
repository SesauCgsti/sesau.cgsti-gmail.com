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
  $lista = COVID::painel();

  return view('painel', compact('lista'));
 }

 public function index() {
  $lista = COVID::painel();
  return view('home', compact('lista'));
 }
}
