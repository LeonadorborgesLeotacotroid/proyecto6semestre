@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Categorias</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">Crear Categoria</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categorias as $key => $categoria)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $categoria->nombre }}</td>
                                <td>
                                    <button class="btn btn-warning btnEditarCategoria" data-toggle="modal" data-target="#modalEditarCategoria"
                                    idCategoria="{{ $categoria->id }}">
                                    <i class="fa fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger btnEliminarCategoria" categoria="{{ $categoria->nombre }}"
                                            idCategoria="{{ $categoria->id }}">
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



    <div class="modal fade" id="modalAgregarCategoria">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color:white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar Categoria" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Agregar Categoria
                        </button>
                        <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">
                            Salir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCategoria">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="Actualizar-Categoria">
                    @csrf
                    @method('put')
                    <div class="modal-header" style="background: #ffc107; color:Black;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Actualizar Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <input type="hidden" class="form-control input-lg" id="idEditar" name="id" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <input type="text" class="form-control input-lg" id="nombreEditar" name="nombre" placeholder="Ingresar Categoria" required>
                                </div>
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
                </form>
            </div>
        </div>
    </div>

@endsection
