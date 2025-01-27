@extends('welcome')
@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Reporte de Ventas</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <div class="col-md-2">
                            <h3>Fecha Inicial:</h3>
                            <input type="date" id="fechaI" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <h3>Fecha Final:</h3>
                            <input type="date" id="fechaF" class="form-control">
                        </div>
                        @if(auth()->user()->rol == 'Administrador')
                            <div class="col-md-3">
                                <h3>Sucursal: </h3>
                                <select class="form-control" id="id_sucursal">
                                    <option value="0">Seleccionar---</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" id="id_sucursal" value="{{auth()->user()->id_sucursal}}">
                        @endif
                        <div class="col-md-3 btnFiltrar">
                            <h3>&nbsp;</h3>
                            <button class="btn btn-warning btnFiltrarReportes" url="{{ url('') }}" >Filtrar</button>
                        </div>
                    </div>

                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-solid bg-teal-gradient">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Gráfico de Ventas</h3>
                                </div>
                                <div class="box-body border-radius-none nuevoGraficoVentas">
                                    <div class="chart" id="line-chart-ventas" style="height: 250px">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--- segundo grafico -->
                        <div class="col-md-6 col-xs-12">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Productos mas vendidos</h3>
                                </div>
                                <div class="box-body ">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="chart-responsive">
                                                <canvas id="pieChart"  height="150" ></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <ul class="chart-legend clearfix">
                                                <?php
                                                foreach ($productosMasVendidos as $index => $producto) {
                                                    echo '<li>
                                                            <i class="fa fa-circle-o" style="color:' . $colores[$index] . ';"></i>
                                                            '.$producto->descripcion.'
                                                          </li>';
                                                   }
                                                ?>

                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-pills nav-stacked">
                                        <?php
                                        foreach ($productosMasVendidos as $index => $producto) {
                                            if ($producto->imagen == ''){
                                                $imagen = "productos/default.png";
                                            }else{
                                                $imagen = $producto->imagen;
                                            }
                                            echo '<li>
                                                    <a>
                                                        <img src="'.url("storage/".$imagen).'"
                                                        class="img-thumbnail" width="60px"
                                                        style="margin-right: 10px">
                                                        <span class="pull-right" style"color:'.$colores[$index].'">
                                                            '.$producto->porcentaje.' %
                                                        </span>
                                                    </a>

                                                  </li>';
                                           }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tercer Grafico -->
                        <div class="col-md-6 col-xs-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Vendedores</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-responsive">
                                        <div class="chart" id="bar-chart1" style="height: 300px">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cuarto Grafico -->
                        <div class="col-md-6 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Compradores</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-responsive">
                                        <div class="chart" id="bar-chart2" style="height: 300px">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <div class="modal fade" id="modalAgregarSucursal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header" style="background: #3c8dbc; color:white;">
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
                    <div class="modal-footer">
                        <button class="btn btn-primary " type="submit" >
                            Agregar Sucursal
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
