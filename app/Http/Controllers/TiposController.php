<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class TiposController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar(){
        $tipos = Tipo::paginate(1);
        Paginator::useBootstrap();

        return view('tipo.lista', compact('tipos'));
        //$tipos = Tipo::all();
        // return view('tipo', ['tipos' => $tipos]);
    }

    public function buscar($id){
        $tipo = Tipo::findOrFail($id);
        echo $tipo;
    }
}
