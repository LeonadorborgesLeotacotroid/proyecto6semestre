@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Sucursales</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn-primary" data-toggle="modal" data-target="#modalAgregarSucursal">
                        Agregar Sucursal
                    </button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sucursal</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sucursales as $sucursal)
                            @if($sucursal->estado == 1)
                                <tr>
                                    <td>{{ $sucursal->id }}</td>
                                    <td>{{ $sucursal->nombre }}</td>
                                    <td>
                                        <button class="btn btn-warning btnEditarSucursal" data-toggle="modal" data-target="#modalEditarSucursal"
                                                idSucursal="{{ $sucursal->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="Cambiar-Estado-Sucursal/0/{{ $sucursal->id }}">
                                            <button class="btn btn-danger">
                                                Deshabilitar
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endif


                        @endforeach
                        </tbody>
                    </table>

                    <hr>
                    <h2>Sucursales Deshabilitadas</h2>
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sucursal</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sucursales as $sucursal)
                            @if($sucursal->estado == 0)
                                <tr>
                                    <td>{{ $sucursal->id }}</td>
                                    <td>{{ $sucursal->nombre }}</td>
                                    <td>
                                        <button class="btn btn-warning btnEditarSucursal" data-toggle="modal" data-target="#modalEditarSucursal"
                                                idSucursal="{{ $sucursal->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="Cambiar-Estado-Sucursal/1/{{ $sucursal->id }}">
                                            <button class="btn btn-success">
                                                Habilitar
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endif


                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalAgregarSucursal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color:black;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar Sucursal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar Sucursal" required>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Actualizar Sucursal
                        </button>
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Salir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarSucursal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ url('Actualizar-Sucursal') }}">
                    @csrf
                    @method('put')
                    <div class="modal-header" style="background: #ffc107; color:black;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Sucursal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <input type="text" class="form-control input-lg" name="nombre"  id="nombreEditar" required>
                                    <input type="hidden" class="form-control input-lg" name="id"  id="idEditar" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Guardar Cambios
                        </button>
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
