
//select anidado dinamico objetivo que el admin puede administrar cualquier sucursal
$(".selectRol").change(function (){
    var Rol = $(this).val();
    if(Rol != 'Administrador'){
        $(".selectSucursal").show();
    }else{
        $(".selectSucursal").hide();
    }
})

//cambiar el estado de los usuarios a traves del endpoint que comunica al controlador
$(".table").on('click', '.btnEstadoUser', function (){
    var Uid = $(this).attr('Uid');
    var estado = $(this).attr('estado');

    $.ajax({
        url: 'Cambiar-Estado-Usuario/'+Uid+'/'+estado,
        type: 'GET',
        success: function (){
            if (estado == 0){
                $(this).removeClass('btn-success').addClass('btn-danger').attr('estado',1).text('Desactivado');
            }else{
                $(this).removeClass('btn-danger').addClass('btn-success').attr('estado',0).text('Activado');
            }
        }.bind(this)
    })
})

//proceso para obtener los datos del usuario a editar para el modal
$(".table").on('click','.btnEditarUsuario', function (){

    var Uid = $(this).attr('idUsuario');

    $.ajax({
        url: 'Editar-Usuario/'+Uid,
        type: 'GET',
        success: function (respuesta){
            $('#idEditar').val(respuesta.id);
            $('#nameEditar').val(respuesta.name);
            $('#emailEditar').val(respuesta.email);
            $('#rolEditar').val(respuesta.rol);

            if(respuesta.rol !== 'Administrador'){
                $(".selectSucursal").show();
                $('#id_sucursalEditar').val(respuesta.id_sucursal);
            }else{
                $(".selectSucursal").hide();
            }
        }
    })
})

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

//validacion de editar email para evitar duplicaciones
$("#emailEditar").change(function (){
    var emailVerificar = $(this).val();
    var idUser = $("#idEditar").val();

    $(".alert").remove();

    $.ajax({

        url: 'Verificar-Usuario',
        type: 'POST',
        data: {email: emailVerificar, id: idUser},

        success: function (respuesta){
            //console.log(respuesta["emailVerificacion"]);
            if(respuesta["emailVerificacion"] == false){
                $("#emailEditar").parent().after('<div class="alert alert-danger">Esta email ya fue registrado</div>')
                $("#emailEditar").val(""); //si se encontro el email limpia el campo
            }
        }
    })

})

//validar para eliminar usuarios
$(".table").on('click','.btnEliminarUsuario', function (){
    var Uid= $(this).attr('idUsuario');

    Swal.fire({
        title: '¿Seguro que deseas eliminar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result)=>{
        if(result.isConfirmed){
            window.location = "Eliminar-Usuario/"+Uid;
        }
    })
})
