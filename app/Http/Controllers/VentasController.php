<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Sucursales;
use App\Models\Ventas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
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
        $sucursales = Sucursales::where('estado', 1)->get();
        $clientes = Clientes::where('estado', 1)->get();
        $ventas = Ventas::all();
        return view('modulos.ventas.Ventas', compact('sucursales','clientes','ventas'));
    }

    public function store(Request $request)
    {
        $datos = request();
        $UltimaVenta = Ventas::orderBy('id', 'desc')->where('id_sucursal', $datos['id_sucursal'])->first();

        if ($UltimaVenta == null) {
            $codigo = $datos['id_sucursal']*10000;
        }else{
            $codigo = $UltimaVenta["codigo"]+1;
        }

        Ventas::create([
            'id_sucursal' => $datos['id_sucursal'],
            'id_vendedor' => $datos['id_vendedor'],
            'id_cliente' => $datos['id_cliente'],
            'codigo' => $codigo,
            'impuesto' => 0,
            'neto' => 0,
            'total' => 0,
            'metodo_pago'=>'',
            'estado' => 'Creado',
        ]);

        $nuevoVenta = Ventas::orderBy('id', 'desc')->first();
        return redirect('Ventas/'.$nuevoVenta["id"]);
    }

    public function AdministrarVenta($id_venta)
    {
        $venta = Ventas::find($id_venta);
        $productos = Productos::leftJoin('venta_productos', function ($join) use ($id_venta) {
            $join->on('productos.id', '=', 'venta_productos.id_producto')
                ->where('venta_productos.id_venta', '=', $id_venta);
        })
            ->select('productos.*','venta_productos.id_producto as en_venta')
            ->get();

        return view('modulos.ventas.Venta', compact('venta','productos'));
    }

    public function AgregarProductoVenta(Request $request)
    {
        $producto = Productos::find($request->idProducto);
        DB::table('venta_productos')->insert([
            'id_venta' => $request->idVenta,
            'id_producto' => $producto->id,
            'cantidad'=>1,
            'precio'=>$producto->precio_venta
        ]);

        Ventas::find($request->idVenta)->update(['estado'=>'En Proceso']);
        return response()->json([
            'id'=>$producto->id,
            'descripcion'=>$producto->descripcion,
            'stock'=>$producto->stock,
            'cantidad'=>1,
            'precio_venta'=>$producto->precio_venta
        ]);

    }

    public function CargarProductosVenta($id_venta)
    {
        $productos = DB::table('venta_productos')
            ->join('productos','venta_productos.id_producto','=','productos.id')
            ->where('venta_productos.id_venta',$id_venta)
        ->get();
        return response()->json([
            'productos'=>$productos
        ]);
    }

    public function QuitarProductoVenta(Request $request, Ventas $ventas)
    {
        DB::table('venta_productos')->where('id_venta', $request->idVenta)
            ->where('id_producto', $request->idProducto)->delete();
    }

    public function FinalizarVenta(Request $request)
    {
        $idVenta = $request->idVenta;
        $productos = $request->productos;
        $pagos = $request->pago[0];

        foreach ($productos as $productoData) {
            $producto = Productos::find($productoData["id"]);

            DB::table('venta_productos')->where('id_venta',$idVenta)
                ->where('id_producto',$productoData["id"])
                ->update([
                    'cantidad'=>$productoData["cantidad"],
                    'precio'=>$productoData["precio"],
                ]);
            $nuevoStock = $producto->stock - $productoData["cantidad"];
            $producto->stock = $nuevoStock;
            $nuevoProductoVenta = $producto->ventas+1;
            $producto->ventas = $nuevoProductoVenta;
            $producto->save();
        }
        $venta = Ventas::find($idVenta);
        $venta->impuesto = $pagos["impuesto"];
        $venta->neto = $pagos["neto"];
        $venta->total = $pagos["total"];
        $venta->metodo_pago = $pagos["metodo_pago"];
        $venta->estado = 'Finalizada';
        $venta->save();
    }
    public function EliminarVenta($id_venta)
    {
        $venta = Ventas::find($id_venta);
        if($venta->estado != 'Finalizada'){
            $venta->delete();
            DB::table('venta_productos')->where('id_venta',$id_venta)->delete();
        }

        return redirect('Ventas');

    }

    public function Reportes()
    {
        if (auth()->user()->rol == 'Administrador') {
            $ventas = Ventas::orderBy('id', 'asc')->get();
        }else{
            $ventas = Ventas::orderBy('id', 'asc')->where('id_sucursal', auth()->user()->id_sucursal)->get();
        }
        //Primer Grafico
        $arrayFechas = array();
        $sumaPagoMes = array();
        foreach ($ventas as $venta) {
            $fecha = substr($venta->fecha, 0, 7);
            $arrayFechas[] = $fecha;

            if (!isset($sumaPagoMes[$fecha])) {
                $sumaPagoMes[$fecha] = 0;
            }

            $sumaPagoMes[$fecha] += $venta->total;
        }

        $noRepetirFechas = array_unique($arrayFechas);

        //segundo grafico
        if (auth()->user()->rol == 'Administrador') {
            $ventas2 = Ventas::pluck('id')->toArray();
        }else{
            $ventas2 = Ventas::orderBy('id', 'asc')->where('id_sucursal', auth()->user()->id_sucursal)->pluck('id')->toArray();;
        }
        $totalVentas = count($ventas2);
        $totalProductosVendidos = db::table('venta_productos')
            ->whereIn('venta_productos.id_venta', $ventas2)
        ->count();

        $productosMasVendidos = DB::table('venta_productos')
            ->join('productos', 'venta_productos.id_producto', '=', 'productos.id')
            ->whereIn('venta_productos.id_venta', $ventas2)
            ->select(
                'venta_productos.id_producto',
                'productos.descripcion',
                'productos.imagen',
                DB::raw('COUNT(*) as ventas'),
                DB::raw('ROUND((COUNT(*) / '.$totalProductosVendidos.') * 100, 2) as porcentaje')
            )
            ->groupBy('venta_productos.id_producto', 'productos.descripcion', 'productos.imagen')
            ->orderByDesc('ventas')
            ->take(10)
            ->get();

        $colores = array( '#ef7869', '#00a65a', '#3ce0cd', '#b6f545');

        //Tercer grafico
        $usuarios = User::all();
        $sumaTotalVendedores = [];
        foreach ($ventas as $valueVentas) {
            foreach ($usuarios as $valueUsuarios) {
                if ($valueUsuarios["id"] == $valueVentas["id_vendedor"]) {
                    $nombreVendedor = $valueUsuarios["name"];
                    if (!isset($sumaTotalVendedores[$nombreVendedor])) {
                        $sumaTotalVendedores[$nombreVendedor] = 0;
                    }
                    $sumaTotalVendedores[$nombreVendedor] += $valueVentas["neto"];
                }
            }
        }
        $noRepetirNombres = array_keys($sumaTotalVendedores);

        //CuartoGrafico
        $clientes = Clientes::all();
        $sumaTotalClientes = [];
        foreach ($ventas as $valueVentas) {
            foreach ($clientes as $valueClientes) {
                if ($valueClientes["id"] == $valueVentas["id_cliente"]) {
                    $nombreCliente = $valueClientes["cliente"];
                    if (!isset($sumaTotalClientes[$nombreCliente])) {
                        $sumaTotalClientes[$nombreCliente] = 0;
                    }
                    $sumaTotalClientes[$nombreCliente] += $valueVentas["neto"];
                }
            }
        }
        $noRepetirClientes = array_keys($sumaTotalClientes);

        $sucursales = Sucursales::where('estado', 1)->get();

        return view('modulos.ventas.Reportes', compact('noRepetirFechas','sumaPagoMes','productosMasVendidos', 'colores',
        'noRepetirNombres','sumaTotalVendedores','noRepetirClientes','sumaTotalClientes', 'sucursales'));
    }

    public function ReportesFiltrados($fechaInicial, $fechaFinal, $idSucursal)
    {
        $fechaInicio = $fechaInicial. ' 00:00';
        $fechaFin = $fechaFinal. ' 23:59';

        if ($idSucursal != 0) {
            $ventas = Ventas::orderBy('id', 'asc')
                ->where('id_sucursal', $idSucursal)
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->get();
        }else{
            $ventas = Ventas::orderBy('id', 'asc')->whereBetween('fecha', [$fechaInicio, $fechaFin])->get();
        }
        //Primer Grafico
        $arrayFechas = array();
        $sumaPagoMes = array();
        foreach ($ventas as $venta) {
            $fecha = substr($venta->fecha, 0, 7);
            $arrayFechas[] = $fecha;

            if (!isset($sumaPagoMes[$fecha])) {
                $sumaPagoMes[$fecha] = 0;
            }

            $sumaPagoMes[$fecha] += $venta->total;
        }

        $noRepetirFechas = array_unique($arrayFechas);

        //segundo grafico
        if ($idSucursal != 0) {
            $ventas2 = Ventas::where('id_sucursal', $idSucursal)->whereBetween('fecha', [$fechaInicio, $fechaFin])->pluck('id')->toArray();
        }else{
            $ventas2 = Ventas::whereBetween('fecha', [$fechaInicio, $fechaFin])->orderBy('id', 'asc')->where('id_sucursal', auth()->user()->id_sucursal)->pluck('id')->toArray();;
        }
        $totalVentas = count($ventas2);
        $totalProductosVendidos = db::table('venta_productos')
            ->whereIn('venta_productos.id_venta', $ventas2)
            ->count();

        $productosMasVendidos = DB::table('venta_productos')
            ->join('productos', 'venta_productos.id_producto', '=', 'productos.id')
            ->whereIn('venta_productos.id_venta', $ventas2)
            ->select(
                'venta_productos.id_producto',
                'productos.descripcion',
                'productos.imagen',
                DB::raw('COUNT(*) as ventas'),
                DB::raw('ROUND((COUNT(*) / '.$totalProductosVendidos.') * 100, 2) as porcentaje')
            )
            ->groupBy('venta_productos.id_producto', 'productos.descripcion', 'productos.imagen')
            ->orderByDesc('ventas')
            ->take(10)
            ->get();

        $colores = array( '#ef7869', '#00a65a', '#3ce0cd', '#b6f545');

        //Tercer grafico
        $usuarios = User::all();
        $sumaTotalVendedores = [];
        foreach ($ventas as $valueVentas) {
            foreach ($usuarios as $valueUsuarios) {
                if ($valueUsuarios["id"] == $valueVentas["id_vendedor"]) {
                    $nombreVendedor = $valueUsuarios["name"];
                    if (!isset($sumaTotalVendedores[$nombreVendedor])) {
                        $sumaTotalVendedores[$nombreVendedor] = 0;
                    }
                    $sumaTotalVendedores[$nombreVendedor] += $valueVentas["neto"];
                }
            }
        }
        $noRepetirNombres = array_keys($sumaTotalVendedores);

        //CuartoGrafico
        $clientes = Clientes::all();
        $sumaTotalClientes = [];
        foreach ($ventas as $valueVentas) {
            foreach ($clientes as $valueClientes) {
                if ($valueClientes["id"] == $valueVentas["id_cliente"]) {
                    $nombreCliente = $valueClientes["cliente"];
                    if (!isset($sumaTotalClientes[$nombreCliente])) {
                        $sumaTotalClientes[$nombreCliente] = 0;
                    }
                    $sumaTotalClientes[$nombreCliente] += $valueVentas["neto"];
                }
            }
        }
        $noRepetirClientes = array_keys($sumaTotalClientes);

        $sucursales = Sucursales::where('estado', 1)->get();

        return view('modulos.ventas.Reportes', compact('noRepetirFechas','sumaPagoMes','productosMasVendidos', 'colores',
            'noRepetirNombres','sumaTotalVendedores','noRepetirClientes','sumaTotalClientes', 'sucursales'));
    }
}
