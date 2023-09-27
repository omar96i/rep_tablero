<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * funcion sin documentar
     * @return view
    */
    public function index(){
        return view('home');
    }
}
