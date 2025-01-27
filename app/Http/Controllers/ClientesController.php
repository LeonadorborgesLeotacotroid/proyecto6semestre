<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
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
        //$clientes = Clientes::where('estado',1)->get();
        //consulta para obtener la canrtidad de compras y la ultima compra en que fecha fue
        $clientes = Clientes::where('clientes.estado',1)->leftJoin('ventas','clientes.id','=','ventas.id_cliente')
            ->select('clientes.id','clientes.cliente','clientes.email','clientes.telefono',
                'clientes.documento','clientes.direccion','clientes.fecha_nac','clientes.estado',
                \DB::raw('COUNT(ventas.id) as cantidad_compras'),
                \DB::raw('MAX(ventas.fecha) as ultima_compra'))
            ->groupBy('clientes.id','clientes.cliente','clientes.email','clientes.telefono',
                'clientes.documento','clientes.direccion','clientes.fecha_nac','clientes.estado')
            ->get();
        return view('modulos.ventas.Clientes', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validarDocumento = request()->validate([
            'documento' => ['unique:clientes']
        ]);
        $datos = request();

        Clientes::create([
            'cliente' => $datos['cliente'],
            'email' => $datos['email'],
            'direccion' => $datos['direccion'],
            'fecha_nac'=>$datos['fecha_nac'],
            'telefono'=>$datos['telefono'],
            'documento'=>$validarDocumento['documento'],
            'estado'=>1,
        ]);

        return redirect('Clientes')->with('success','Cliente Registrado Correctamente');
    }
    public function ValidarDocumento(Request $request)
    {
        if ($request->id == 0){
            $clientes = Clientes::where('documento',$request->documento)->exists();
            if($clientes){
                $respuesta = true;
            }else{
                $respuesta = false;
            }
        }else{
            $cliente = Clientes::find($request->id);
            if ($cliente->documento != $request->documento){
                $documentoExiste = Clientes::where('documento',$request->documento)->exists();
                if($documentoExiste){
                    $respuesta = true;
                }else{
                    $respuesta = false;
                }
            }else{
                $respuesta = false;
            }

        }

        return response()->json($respuesta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_cliente)
    {
        $cliente = Clientes::find($id_cliente);
        return response()->json($cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $datos = request();
        $Cliente = Clientes::find($datos['id']);
        $Cliente->cliente = $datos['cliente'];
        $Cliente->documento = $datos['documento'];
        $Cliente->email = $datos['email'];
        $Cliente->telefono = $datos['telefono'];
        $Cliente->direccion = $datos['direccion'];
        $Cliente->fecha_nac = $datos['fecha_nac'];
        $Cliente->save();

        return redirect('Clientes')->with('success','Cliente Actualizado Correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_clientes)
    {
        $cliente = Clientes::find($id_clientes);
        $cliente->delete();
        return redirect('Clientes')->with('success','El Cliente fue eliminado exitosamente');
    }
}
