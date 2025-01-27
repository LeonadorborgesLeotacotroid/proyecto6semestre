<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use Illuminate\Http\Request;

class SucursalesController extends Controller
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
        if (auth()->user()->rol != 'Administrador') {
            return redirect('Inicio');
        }
        $sucursales = Sucursales::all();
        return view('modulos.users.Sucursales', compact('sucursales'));
    }

    public function store(Request $request)
    {
        Sucursales::create([
            'nombre'=>$request->nombre,
            'estado'=>1
        ]);
        return redirect('Sucursales')->with('success',' La Sucursal se ha registrado correctamente');
    }

    /**
     * Encuentra los datos y lo devuelve en json para procesarlo en ajax
     */
    public function edit($id_sucursal)
    {
        $sucursal = Sucursales::find($id_sucursal);
        return response()->json($sucursal); //respuesta en json para la comunicacion con el endpoint
    }

    /**
     * Actualizarm las sucursales
     */
    public function update(Request $request)
    {
        //a traves del id busca y actualiza nombre
        Sucursales::where('id',$request->id)->update(['nombre'=>$request->nombre]);
        return redirect('Sucursales')->with('success','La Sucursal se ha actualizado correctamente');
    }

    /**
     * Cambiar Estado booleano
     */
    public function CambiarEstado($estado, $id_sucursal)
    {
        Sucursales::find($id_sucursal)->update(['estado'=>$estado]);
        return redirect('Sucursales');
    }
}
