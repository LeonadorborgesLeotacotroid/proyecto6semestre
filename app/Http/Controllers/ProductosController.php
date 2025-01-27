<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
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

        $productos =DB::table('productos')
            ->leftJoin('categorias','productos.id_categoria','=','categorias.id')
            ->select('productos.*','categorias.nombre as categoria_nombre')
            ->get();

        return view('modulos.productos.Productos', compact('categorias','productos'));
    }

    public function GenerarCodigo($id_categoria)
    {
        $producto = Productos::where('id_categoria', $id_categoria)->orderBy('id','desc')->first();

        if($producto == null){
            $respuesta = 0;
        }else{
            $respuesta = $producto;
        }
        return response()->json($respuesta);
    }

    public function AgregarProducto(Request $request)
    {
        $datos = request();
        if (request('imagen')){
            $rutaImg = $datos['imagen']->store('productos', 'public');
        }else{
            $rutaImg = "";
        }
        Productos::create([
           'id_categoria' => $datos['id_categoria'],
           'codigo' => $datos["codigo"],
           'descripcion' => $datos['descripcion'],
            'stock' => $datos['stock'],
            'precio_compra' => $datos['precio_compra'],
            'precio_venta' => $datos['precio_venta'],
            'imagen' => $rutaImg,
            'ventas'=>0
        ]);

        return redirect('Productos')->with('success','El producto fue agregado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_producto)
    {
        $producto = Productos::find($id_producto);
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $datos = request();

        $producto = Productos::find($request->id);
        if (request('imagen')){
            $path = storage_path('app/public/'.$producto->imagen);
            unlink($path);

            $rutaImg = $datos['imagen']->store('productos', 'public');
        }else{
            $rutaImg = $producto->imagen;
        }

        Productos::where('id', $datos['id'])->update([
            'id_categoria' => $datos['id_categoria'],
            'codigo' => $datos['codigo'],
            'descripcion' => $datos['descripcion'],
            'stock' => $datos['stock'],
            'precio_compra' => $datos['precio_compra'],
            'precio_venta' => $datos['precio_venta'],
            'imagen' => $rutaImg,
        ]);

        return redirect('Productos')->with('success','El producto fue actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_producto)
    {
        $producto = Productos::find($id_producto);

        if($producto->imagen != ''){
            $path = storage_path('app/public/'.$producto->imagen);
            unlink($path);
        }
        $producto->delete();
        return redirect('Productos')->with('success','El producto fue eliminado exitosamente');
    }
}
