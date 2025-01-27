@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Administracion de ventas</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn-primary" data-toggle="modal" data-target="#modalCrearVenta" >Crear Venta</button>
                </div>
                <table class="table table-bordered table-striped table-hover dt-responsive">
                    <thead>
                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Codigo Factura</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Forma de Pago</th>
                        <th>Neto</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                    @foreach($ventas as $key => $venta)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$venta->codigo}}</td>
                            <td>{{$venta-> CLIENTE -> cliente}}</td>
                            <td>{{$venta-> VENDEDOR ->name}}</td>
                            <td>{{$venta->metodo_pago}}</td>
                            <td>{{ number_format($venta->neto, 2, '.', ',') }}</td>
                            <td>{{ number_format($venta->total, 2, '.', ',') }}</td>
                            <td>{{$venta->fecha }}</td>
                            <td>
                                @if($venta->estado != 'Finalizada')
                                    <button class="btn btn-danger btnEliminarVenta" idVenta="{{$venta->id}}"><i class="fa fa-trash"></i></button>
                                @endif
                                <a href="{{ url('Ventas/' . $venta->id) }}">
                                    <button class="btn btn-primary">Administrar</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>



    <div class="modal fade" id="modalCrearVenta">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color:white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear Venta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control input-lg" name="id_vendedor" id="id_vendedor" placeholder="Ingresar Sucursal"
                                       value="{{ auth()->user()->id}}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                    <input type="text" class="form-control input-lg" value="{{ auth()->user()->name}}" readonly>
                                </div>
                            </div>
                            @if(auth()->user()->rol == 'Administrador')
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <select name="id_sucursal" id="id_sucursal" required class="form-control input-lg">
                                        <option value=""> Seleccionar Sucursal</option>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}"> {{ $sucursal->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                                <input type="hidden" class="form-control input-lg" value="{{ auth()->user()->id_sucursal }}" readonly>
                            @endif
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                    <select name="id_cliente" id="id_cliente" required class="form-control input-lg">
                                        <option value=""> Seleccionar Cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"> {{ $cliente->cliente }} - {{ $cliente->documento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Crear Venta
                        </button>
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Salir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
