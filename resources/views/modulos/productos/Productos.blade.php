@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Productos</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Crear Producto</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Imagen</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Categoria</th>
                            <th>Stock</th>
                            <th>Precio de Compra</th>
                            <th>Precio de Venta</th>
                            <th>Agregado</th>
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
                                <td>{{ $producto->categoria_nombre }}</td>
                                <td>
                                    @if($producto->stock <= 10)
                                        <button class="btn btn-danger">{{ $producto->stock }}</button>
                                    @elseif($producto->stock >= 11 && $producto->stock <= 15)
                                        <button class="btn btn-warning">{{ $producto->stock }}</button>
                                    @else
                                        <button class="btn btn-success">{{ $producto->stock }}</button>
                                    @endif
                                </td>
                                <td>{{ number_format($producto->precio_compra,2, '.', ',')}}</td>
                                <td>{{ number_format($producto->precio_venta,2, '.', ',') }}</td>
                                <td>{{ $producto->agregado }}</td>
                                <td>
                                    <button class="btn btn-warning btnEditarProducto" data-toggle="modal" data-target="#modalEditarProducto"
                                            idProducto="{{ $producto->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger btnEliminarProducto" categoria="{{ $producto->id }}"
                                            idProducto="{{ $producto->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </section>
    </div>




    <div class="modal fade" id="modalAgregarProducto">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color:white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select name="id_categoria"  id="selectCategoria" class="form-control  input-lg" required>
                                        <option value="">Seleccionar Categoria</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                    <input type="text" class="form-control input-lg" id="codigoProducto"  name="codigo" readonly>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                    <input type="text" class="form-control input-code" placeholder="nombre" name="descripcion" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                    <input type="number" min="0" class="form-control input-code" name="stock"  placeholder="stock" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                        <input type="number" min="0" class="form-control input-code"  id="precioCompra" name="precio_compra"  placeholder="precio_compra" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                        <input type="number" min="0" class="form-control input-code"  id="precioVenta" name="precio_venta" placeholder="precio_venta" required>
                                    </div>


                                    <br>
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox"  class="minimal porcentaje" checked>
                                                Utilizar Porcentaje
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-6" style="padding: 0">
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control input-lg" name="ValorPorcentaje" id="Valorporcentaje" required >
                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                        </div>
                                    </div>
                            </div>

                        </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="panel">SUBIR IMAGEN</div>
                                    <input type="file" class="form-control lg" name="imagen"  placeholder="imagen" >
                                    <img src="{{ url('storage/productos/default.png') }}" class="img-thumbnail" width="100px">
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Agregar Producto
                        </button>
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Salir
                        </button>
                    </div>

                </div>
                </form>
        </div>
    </div>
    </div>

    <div class="modal fade" id="modalEditarProducto">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="Actualizar-Producto" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header" style="background: #ffc107; color:black;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Actualizar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="input-group">

                                    <input type="hidden" class="form-control input-lg" id="idEditar"  name="id" readonly>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select name="id_categoria"  id="selectCategoriaEditar" class="form-control  input-lg" required>
                                        <option value="">Seleccionar Categoria</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                    <input type="text" class="form-control input-code" id="codigoProductoEditar"  name="codigo" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                    <input type="text" class="form-control input-code" placeholder="nombre"  id="descripcionEditar" name="descripcion" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                    <input type="number" min="0" class="form-control input-code" name="stock" id="stockEditar" placeholder="stock" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                        <input type="number" min="0" class="form-control input-code"  id="precioCompraEditar" name="precio_compra"  placeholder="precio_compra" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                        <input type="number" min="0" class="form-control input-code"  id="precioVentaEditar" name="precio_venta" placeholder="precio_venta" required>
                                    </div>


                                    <br>
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox"  class="minimal porcentajeEditar" checked>
                                                Utilizar Porcentaje
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-6" style="padding: 0">
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control input-lg" name="ValorporcentajeEditar" id="ValorporcentajeEditar" required >
                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="panel">SUBIR IMAGEN</div>
                                    <input type="file" class="form-control lg" name="imagen"   placeholder="imagen" >
                                    <img src="{{ url('storage/productos/default.png') }}" class="img-thumbnail" id="imagenEditar" width="100px">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary " type="submit" >
                                Guardar Cambios
                            </button>
                            <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                                Salir
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
