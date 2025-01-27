$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})
//llamada libreria inputmask
$('[data-mask]').inputmask();
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder':'dd/mm/yyyy'})

$('#nuevoDocumento').change(function (){
    $(".alert").remove();
    var documento = $(this).val();

    $.ajax({
        url: 'Validar-Documento',
        type: 'POST',
        data: {documento: documento, id:0},
        success: function (respuesta){
            console.log(respuesta);
            if (respuesta == true ){
                $("#nuevoDocumento").parent().after(
                    '<div class="alert alert-danger">Este documento ya se encuentra registrado</div>');
            }

        }
    })
})
//obtener los datos para editar el cliente
$(".table").on('click','.btnEditarCliente', function (){

    var Cid = $(this).attr('idCliente');

    $.ajax({
        url: 'Editar-Cliente/'+Cid,
        type: 'GET',
        success: function (respuesta){
            $('#idEditar').val(respuesta.id);
            $('#nuevoDocumentoEditar').val(respuesta.documento);
            $('#clienteEditar').val(respuesta.cliente);
            $('#emailEditar').val(respuesta.email);
            $('#telefonoEditar').val(respuesta.telefono);
            $('#direccionEditar').val(respuesta.direccion);
            $('#fecha_nacEditar').val(respuesta.fecha_nac);

        }
    })
})

$('#nuevoDocumentoEditar').change(function (){
    $(".alert").remove();
    var documento = $(this).val();
    var Cid = $("#idEditar").val();

    $.ajax({
        url: 'Validar-Documento',
        type: 'POST',
        data: {documento: documento, id: Cid},
        success: function (respuesta){
            console.log(respuesta);
            if (respuesta == true ){
                $("#nuevoDocumentoEditar").parent().after(
                    '<div class="alert alert-danger">Este documento ya se encuentra registrado</div>');
                $("#nuevoDocumentoEditar").val("");
            }

        }
    })
})

//validar para eliminar clientes
$(".table").on('click','.btnEliminarCliente', function (){
    var Cid= $(this).attr('idCliente');

    Swal.fire({
        title: '¿Seguro que deseas eliminar este cliente?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result)=>{
        if(result.isConfirmed){
            window.location = "Eliminar-Cliente/"+Cid;
        }
    })
})
