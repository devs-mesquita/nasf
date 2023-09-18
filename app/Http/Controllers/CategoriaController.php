<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();

        return view('categoria.index', compact('categorias'));
    }

    public function create()
    {

        return view('categoria.create');
    }

    public function store(Request $request)
    {

        $categoria = new Categoria;

        $categoria->nome = $request->nome;

        $categoria->save();

        return redirect()->route('categoria.index');
    }

    public function edit($id)
    {
        $categoria = Categoria::find($id);

        return view('categoria.edit',compact('categoria'));
    }

    public function update(Request $request,$id)
    {
        $categoria = Categoria::find($id);

        $categoria->nome = $request->nome;

        $categoria->save();

        return redirect()->route('categoria.index');    
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        $categoria->delete();
    }
}
