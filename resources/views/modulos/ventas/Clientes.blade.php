@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Clientes</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">Registrar Cliente</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Total Compras</th>
                            <th>Ultima Compra</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clientes as $key => $cliente)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$cliente->cliente}}</td>
                                <td>{{$cliente->documento}}</td>
                                <td>{{$cliente->email}}</td>
                                <td>{{$cliente->telefono}}</td>
                                <td>{{$cliente->direccion}}</td>
                                <td>{{$cliente->fecha_nac}}</td>
                                <td>{{$cliente->cantidad_compras }}</td>
                                <td>{{$cliente->ultima_compra}}</td>
                                <td>
                                    <button class="btn btn-warning btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente"
                                            idCliente="{{ $cliente->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger btnEliminarCliente" cliente="{{ $cliente->cliente }}"
                                            idCliente="{{ $cliente->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>



    <div class="modal fade" id="modalAgregarCliente">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color:white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input-lg" name="cliente" placeholder="Nombre Cliente" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control input-lg" id="nuevoDocumento" name="documento" placeholder="Ingresar Documento" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control input-lg" name="email" placeholder="Ingresa el email del Cliente" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control input-lg" name="telefono" placeholder="Ingresa el telefono del Cliente"
                                    required data-mask data-inputmask='"mask":"(99) 999-999-999"'>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <input type="text" class="form-control input-lg" name="direccion" placeholder="Ingresa direccion del cliente" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-lg" name="fecha_nac" placeholder="Fecha de nacimiento" required
                                           data-mask data-inputmask="'alias': 'yyyy/mm/dd' ">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Guardar Cliente
                        </button>
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Salir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCliente">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="Actualizar-Cliente">
                    @csrf
                    @method('put')
                    <div class="modal-header" style="background: #ffc107; color:black;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-lg" name="idCliente" id="idEditar" placeholder="Nombre Cliente" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input-lg" name="cliente" id="clienteEditar" placeholder="Nombre Cliente" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control input-lg" id="nuevoDocumentoEditar" name="documento" placeholder="Ingresar Documento" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control input-lg" name="email" id="emailEditar" placeholder="Ingresa el email del Cliente" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control input-lg" name="telefono" id="telefonoEditar" placeholder="Ingresa el telefono del Cliente"
                                           required data-mask data-inputmask='"mask":"(99) 999-999-999"'>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <input type="text" class="form-control input-lg" name="direccion" id="direccionEditar" placeholder="Ingresa direccion del cliente" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-lg" name="fecha_nac" id="fecha_nacEditar" placeholder="Fecha de nacimiento" required
                                           data-mask data-inputmask="'alias': 'yyyy/mm/dd' ">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Modificar Cliente
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
