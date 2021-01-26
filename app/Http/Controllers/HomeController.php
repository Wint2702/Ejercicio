<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospecto;
use App\Http\Controllers\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prospectos = Prospecto::orderBy('id', 'DESC')->get();
        return \View::make('prospectos.captura',['prospectos'=>$prospectos]);
    }
}
