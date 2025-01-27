<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url ('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url ('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url ('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url ('dist/css/skins/_all-skins.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ url ('bower_components/morris.js/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ url ('bower_components/jvectormap/jquery-jvectormap.css"')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ url ('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url ('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- Datatables -->
    <link rel="stylesheet" href="{{ url ('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ url ('bower_components/datatables.net-bs/css/responsive.bootstrap.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url ('bower_components/iCheck/all.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->
    <script src="{{url('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{url('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{ url ('bower_components/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{ url ('bower_components/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{ url ('bower_components/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <!-- Chartset -->
    <script src="{{ url ('bower_components/chart.js/Chart.js')}}"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini login-page">

@if(Auth::user())
    <div class="wrapper">

        @include('modulos.users.cabecera')
        @include('modulos.users.menu')

        @yield('contenido')

    </div>
@else
    @yield('ingresar')
@endif


    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-wrapper -->


<!-- ./wrapper -->


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{ url('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ url('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ url('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ url('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('dist/js/demo.js')}}"></script>
<!-- Datatables -->
<script src="{{ url('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('bower_components/datatables.net-bs/js/dataTables.responsive.min.js')}}"></script>
<!-- Sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- iCheck -->
<script src="{{ url('bower_components/iCheck/icheck.min.js')}}"></script>
<!-- Scripts logica -->
<script src="{{ url('js/plantilla.js') }}"></script>
<script src="{{ url('js/usuarios.js') }}"></script>
<script src="{{ url('js/productos.js') }}"></script>
<script src="{{ url('js/clientes.js') }}"></script>
<script src="{{ url('js/ventas.js') }}"></script>





@if(session('success'))
    <script type="text/javascript">
        Swal.fire({
            title: '{{ session('success')}}',
            icon: "success",
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
@php
    $exp = explode('/', $_SERVER["REQUEST_URI"]);
@endphp

//$exp cambiarla a 3 cuando este en localhost o hosting
@if($exp[1] == 'Reportes' || $exp[1] == 'ReportesFiltrados' )
    <script type="text/javascript">
        //primer grafico
        var line = new Morris.Line({
            element: 'line-chart-ventas',
            resize: true,
            data: [
                @php
                    foreach ($noRepetirFechas as $fecha){
                      $ventas = $sumaPagoMes[$fecha] ?? 0;
                      echo "{ y: '".$fecha."', ventas:".$ventas."},";
                    }
                @endphp
            ],
            xkey: 'y',
            ykeys: ['ventas'],
            labels: ["Ventas"],
            lineColors: ["black"],
            hideHover: 'auto'
        })
        //segundo grafico
        var ColoresFijos = [
          '#ef7869',
          '#00a65a',
            '#3ce0cd',
            '#b6f545',
        ];

        var pieData = [

            @foreach($productosMasVendidos as $index => $producto)
            {
                value: {{$producto->ventas}},
                color: ColoresFijos[{{$index}} % ColoresFijos.length],
                highlight: ColoresFijos[{{$index}} % ColoresFijos.length],
                label: '{{ $producto->descripcion }}'
            },
            @endforeach

        ];
        var pieOptions = {

            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            //String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            //Number - The width of each segment stroke
            segmentStrokeWidth   : 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps       : 100,
            //String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : true,

        };

        var pieChartCanvas = $("#pieChart").get(0).getContext('2d');
        var pieChart = new Chart(pieChartCanvas);
        pieChart.Doughnut(pieData, pieOptions);

        //Tercer Grafico
        var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: [
                    <?php
                    foreach ($noRepetirNombres as $value) {
                        echo "{ y: '".$value."', a:'".$sumaTotalVendedores[$value]."'},";
                    }
                    ?>
            ],
            barColors: ['#0af'],
            xkey: 'y',
            ykeys: 'a',
            labels: ['ventas'],
            preUnits: '$',
            hideHover: 'auto'
        })

        //Cuarto Grafico
        var bar = new Morris.Bar({
            element: 'bar-chart2',
            resize: true,
            data: [
                    <?php
                    foreach ($noRepetirClientes as $value) {
                        echo "{ y: '".$value."', a:'".$sumaTotalClientes[$value]."'},";
                    }
                    ?>
            ],
            barColors: ['#0af'],
            xkey: 'y',
            ykeys: 'a',
            labels: ['ventas'],
            preUnits: '$',
            hideHover: 'auto'
        })
    </script>
@endif

</body>
</html>
