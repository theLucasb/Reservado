<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

class TiposController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        $tipos = Tipo::paginate(25);
        Paginator::useBootstrap();

        return view('tipo.lista', compact('tipos'));
        //$tipos = Tipo::all();
        //return view('tipo', ['tipos' => $tipos]);
    }

    public function create()
    {
        return view('tipo.formulario');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['image.*', 'mimes:jpeg, jpg, gif, png']
        );
        $pasta = public_path('/uploads/tipos');
        if ($request->hasFile('icone')) {
            $foto = $request->file('icone');
            $miniatura = Image::make($foto->path());
            $nomeArquivo = $request->file('icone')->getClientOriginalName();
            if (!$miniatura->resize(
                500,
                500,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->save($pasta . '/' . $nomeArquivo)) {
                $nomeArquivo = 'semfoto.jpg';
            }
        } else {
            $nomeArquivo = 'semfoto.jpg';
        }

        $tipo = new Tipo();
        $tipo->fill($request->all());
        $tipo->icone = $nomeArquivo;
        if ($tipo->save()) {
            $request->session()->flash('mensagem_sucesso', "Tipo salvo!");
        } else {
            $request->session()->flash('mensagem_erro', "Deu erro!");
        }
        return Redirect::to('tipo/create');
    }

    public function update(Request $request, $tipo_id)
    {
        $tipo = Tipo::findOrFail($tipo_id);
        $this->validate(
            $request,
            ['image.*', 'mimes:jpeg, jpg, gif, png']
        );
        $pasta = public_path('/uploads/tipos');
        if ($request->hasFile('icone')) {
            $foto = $request->file('icone');
            $miniatura = Image::make($foto->path());
            $nomeArquivo = $request->file('icone')->getClientOriginalName();
            if (!$miniatura->resize(
                500,
                500,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->save($pasta . '/' . $nomeArquivo)) {
                $nomeArquivo = 'semfoto.jpg';
            }
        } else {
            $nomeArquivo = $tipo->icone;
        }

        $tipo->fill($request->all());
        $tipo->icone = $nomeArquivo;
        if ($tipo->save()) {
            $request->session()->flash('mensagem_sucesso', "Tipo salvo!");
        } else {
            $request->session()->flash('mensagem_erro', "Deu erro!");
        }
        return Redirect::to('tipo/' . $tipo->id);
    }

    public function show($id)
    {
        $tipo = Tipo::findOrFail($id);
        return view('tipo.formulario', compact('tipo'));
    }

    public function deletar(Request $request, $tipo_id)
    {
        $tipo = Tipo::findOrFail($tipo_id);
        $lOk = true;
        if (!empty($tipo->icone)) {
            if ($tipo->icone != 'semfoto.jpg') {
                $lOK = unlink(public_path('uploads/tipos/') . $tipo->icone);
            }
        }
        if ($lOk) {
            $tipo->delete();
            $request->session()->flash(
                'mensagem_sucesso',
                'Tipo removido com sucesso'
            );
            return Redirect::to('tipo');
        }
    }
}
