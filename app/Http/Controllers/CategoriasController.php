<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = DB::table('categorias')->orderBy('nombre','asc')->get();
        return view('modulos.productos.Categorias',compact('categorias'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('categorias')->insert(['nombre' => $request->nombre]);
        return redirect('Categorias')->with('success', 'Categoria creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_categoria)
    {
        $categoria = DB::table('categorias')->where('id',$id_categoria)->first();
        return response()->json($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::table('categorias')->where('id', $request->id)->update(['nombre'=>$request->nombre]);
        return redirect('Categorias')->with('success', 'Categoria actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('categorias')->where('id', $id)->delete();
        return redirect('Categorias');
    }
}
