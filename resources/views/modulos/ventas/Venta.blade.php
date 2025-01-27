@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Administrar Venta - {{$venta->codigo}}</h1>
        </section>
        <section class="content">
            <div class="row">
                <!-- Formulario de Venta -->
                <div class="col-lg-5 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                            <div class="box">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" value="{{$venta->VENDEDOR->name}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input type="text" class="form-control" value="{{$venta->codigo}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                        <input type="text" class="form-control" value="{{$venta->CLIENTE->cliente}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row ProductosVenta">
                                    <input type="hidden" id="idVenta" value="{{$venta->id}}">
                                    <input type="hidden" id="url" value="{{url('')}}">
                                    <input type="hidden" id="estado" value="{{$venta->estado}}">


                                </div>
                                <button class="btn btn-default hidden-lg" data-toggle="modal" data-target="#modalAgregarProductoVenta">
                                    Agregar Producto
                                </button>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-8 pull-right">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Impuesto</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width: 50%">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control input-lg" id="nuevoImpuestoVenta" min="0" placeholder="0" name="" value="{{$venta->impuesto}}"
                                                        @if($venta->estado == 'Finalizada') readonly @endif>
                                                        <input type="hidden" id="nuevoPrecioNeto" >
                                                    </div>
                                                </td>
                                                <td style="width: 50%">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                        <input type="number" class="form-control input-lg" min="0" placeholder="0000" name="" readonly
                                                               id="nuevoPrecioTotal">
                                                    </div>
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <hr>
                                <div class="form-group row">
                                    @if($venta->estado != 'Finalizada' )
                                    <div class="col-xs-6" style="padding-right: 0px;">
                                        <div class="input-group">
                                            <select class="form-control" id="nuevoMetodoPago" required>
                                                <option value="0">Selecciona el metodo de pago</option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="TC">Tarjeta de Credito</option>
                                                <option value="TD">Tarjeta de Debito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cajasMetodoPago"></div>

                                    @else
                                        <div class="col-xs-12" style="padding-right: 0px">
                                            <h4>Metodo de Pago: <b>{{$venta-> metodo_pago}}</b></h4>
                                        </div>
                                    @endif
                                </div>

                                <br>


                            </div>

                        </div>
                        @if($venta -> estado != 'Finalizada')
                            <div class="box-footer" id="btnFinalizarVenta" style="display: none">
                                <button class="btn btn-success">Finalizar Venta</button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Productos -->
                <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
                    <div class="box box-warning">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped dt-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Imagen</th>
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($productos as $key => $producto)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if($producto->imagen == "")
                                                <img src="{{url('storage/productos/default.png')}}" class="img-thumbnail" width="40px">
                                            @else
                                                <img src="{{url('storage/'.$producto->imagen)}}" class="img-thumbnail" width="40px">
                                            @endif
                                        </td>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->descripcion }}</td>
                                        <td>
                                            @if($producto->stock <= 10)
                                                <button class="btn btn-danger">{{ $producto->stock }}</button>
                                            @elseif($producto->stock >= 11 && $producto->stock <= 15)
                                                <button class="btn btn-warning">{{ $producto->stock }}</button>
                                            @else
                                                <button class="btn btn-success">{{ $producto->stock }}</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($venta->estado != 'Finalizada')
                                            @if($producto->stock > 0)
                                                @if($producto->en_venta)
                                                        <button class="btn btn-default" id="producto-{{$producto->id}}">Agregar</button>
                                                    @else
                                                        <button class="btn btn-primary AgregarProducto" idProducto="{{$producto->id}}" id="producto-{{$producto->id}}">Agregar</button>
                                                @endif
                                            @else
                                                <button class="btn btn-default" id="producto-{{$producto->id}}">Agregar</button>
                                            @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <div class="modal fade" id="modalAgregarProductoVenta">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header" style="background: #3c8dbc; color:white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar Producto a la Venta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped dt-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Imagen</th>
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($productos as $key => $producto)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if($producto->imagen == "")
                                                <img src="{{url('storage/productos/default.png')}}" class="img-thumbnail" width="40px">
                                            @else
                                                <img src="{{url('storage/'.$producto->imagen)}}" class="img-thumbnail" width="40px">
                                            @endif
                                        </td>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->descripcion }}</td>
                                        <td>
                                            @if($producto->stock <= 10)
                                                <button class="btn btn-danger">{{ $producto->stock }}</button>
                                            @elseif($producto->stock >= 11 && $producto->stock <= 15)
                                                <button class="btn btn-warning">{{ $producto->stock }}</button>
                                            @else
                                                <button class="btn btn-success">{{ $producto->stock }}</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($venta->estado != 'Finalizada')
                                                @if($producto->stock > 0)
                                                    @if($producto->en_venta)
                                                        <button class="btn btn-default" id="productoModal-{{$producto->id}}">Agregar</button>
                                                    @else
                                                        <button class="btn btn-primary AgregarProducto" idProducto="{{$producto->id}}" id="productoModal-{{$producto->id}}">Agregar</button>
                                                    @endif
                                                @else
                                                    <button class="btn btn-default" id="productoModal-{{$producto->id}}">Agregar</button>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Salir
                        </button>
                    </div>
            </div>
        </div>
    </div>

@endsection
