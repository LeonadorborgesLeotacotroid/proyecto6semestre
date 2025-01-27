//funcion obtener categorias a editar
$(".table").on('click', '.btnEditarCategoria', function (){
    var Cid = $(this).attr('idCategoria');

    $.ajax({
        url: 'Editar-Categoria/'+Cid,
        type: 'GET',
        success: function (respuesta){
            $("#idEditar").val(respuesta["id"]);
            $("#nombreEditar").val(respuesta["nombre"]);
        }
    })
})

//funcion para eliminar categorias con sweetalert
$(".table").on('click','.btnEliminarCategoria', function (){
    var Cid= $(this).attr('idCategoria');
    var categoria = $(this).attr('categoria');

    Swal.fire({
        title: '¿Seguro que deseas eliminar esta categoria: '+categoria+'?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result)=>{
        if(result.isConfirmed){
            window.location = "Eliminar-Categoria/"+Cid;
        }
    })
})

//para generar el codigo de los productos
$("#selectCategoria").change(function (){
    var idCategoria = $(this).val();

    $.ajax({
        url: 'Generar-Codigo-Producto/'+idCategoria,
        type: 'GET',
        success: function (respuesta){
            if(respuesta == 0){
                var nuevoCodigo = idCategoria+"01";
            }else{
                var nuevoCodigo = Number(respuesta["codigo"])+1;
            }
            $("#codigoProducto").val(nuevoCodigo);
        }
    })
})

//utilizan libreria ichek
$('input[type="checkbox"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue'
})

//script para calcular el porcentaje
$("#precioCompra").change(function (){
    if($(".porcentaje").prop('checked')){
        var valorPorcentaje = $("#Valorporcentaje").val();

        var porcentaje = Number(($("#precioCompra").val()*valorPorcentaje/100)) + Number($("#precioCompra").val());

        $("#precioVenta").val(porcentaje);
        $("#precioVenta").prop("redonly", true);

    }
})

//
$("#Valorporcentaje").change(function (){
    if($(".porcentaje").prop('checked')){
        var valorPorcentaje = $("#Valorporcentaje").val();

        var porcentaje = Number(($("#precioCompra").val()*valorPorcentaje/100)) + Number($("#precioCompra").val());

        $("#precioVenta").val(porcentaje);
        $("#precioVenta").prop("readonly", true);

    }
})

$(".porcentaje").on('ifUnchecked', function (){
    $('#precioVenta').prop("readonly", false);
})
//funcion para restablecer la generacion de codigo al momento de editar

$("#selectCategoriaEditar").change(function (){
    var idCategoria = $(this).val();

    $.ajax({
        url: 'Generar-Codigo-Producto/'+idCategoria,
        type: 'GET',
        success: function (respuesta){
            if(respuesta == 0){
                var nuevoCodigo = idCategoria+"01";
            }else{
                var nuevoCodigo = Number(respuesta["codigo"])+1;
            }
            $("#codigoProductoEditar").val(nuevoCodigo);
        }
    })
})

//funcion obtener productos a editar
$(".table").on('click', '.btnEditarProducto', function (){
    var Pid = $(this).attr('idProducto');

    $.ajax({
        url: 'Editar-Producto/'+Pid,
        type: 'GET',
        success: function (respuesta){
            $("#idEditar").val(respuesta["id"]);
            $("#selectCategoriaEditar").val(respuesta.id_categoria);
            $("#codigoProductoEditar").val(respuesta.codigo);
            $("#descripcionEditar").val(respuesta.descripcion);
            $("#stockEditar").val(respuesta.stock);
            $("#precioCompraEditar").val(respuesta.precio_compra);
            $("#precioVentaEditar").val(respuesta.precio_venta);

            if (respuesta.imagen != ''){
                $("#imagenEditar").attr('src','storage/'+respuesta.imagen);
            }else{
                $("#imagenEditar").attr('src','storage/productos/default.png');
            }
        }
    })
})

//funciones para calcular el porcentaje al momento de editar

//script para calcular el porcentaje
$("#precioCompraEditar").change(function (){
    if($(".porcentajeEditar").prop('checked')){
        var valorPorcentaje = $("#ValorporcentajeEditar").val();

        var porcentaje = Number(($("#precioCompraEditar").val()*valorPorcentaje/100)) + Number($("#precioCompraEditar").val());

        $("#precioVentaEditar").val(porcentaje);
        $("#precioVentaEditar").prop("redonly", true);

    }
})

//
$("#ValorporcentajeEditar").change(function (){
    if($(".porcentajeEditar").prop('checked')){
        var valorPorcentaje = $("#ValorporcentajeEditar").val();

        var porcentaje = Number(($("#precioCompraEditar").val()*valorPorcentaje/100)) + Number($("#precioCompraEditar").val());

        $("#precioVentaEditar").val(porcentaje);
        $("#precioVentaEditar").prop("readonly", true);

    }
})

$(".porcentajeEditar").on('ifUnchecked', function (){
    $('#precioVentaEditar').prop("readonly", false);
})

//funcion para eliminar productos con sweetalert
$(".table").on('click','.btnEliminarProducto', function (){
    var Pid= $(this).attr('idProducto');

    Swal.fire({
        title: '¿Seguro que deseas eliminar este producto ?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result)=>{
        if(result.isConfirmed){
            window.location = "Eliminar-Producto/"+Pid;
        }
    })
})
