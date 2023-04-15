var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function cargartabla()
{
    var enlace = base_url + "registro_cas/cargartablas";
    $('#idRegistroCas').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });

}
function cargarTablaCas(idregistro)
{
    var enlace = base_url + "registro_cas/cargarTablasCas?id_registro="+idregistro;
    $('#idVerificarCas').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 5,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
    editarVerificarRegistroCas(idregistro);

}
function cargarTablaFuncionarioPlanta()
{
    var enlace = base_url + "registro_cas/cargarTablasFuncionariosPlanta";
    $('#idFuncionarioPlanta').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function abrirDialogRegistroCas(idregistro)
{
    var enlace = base_url + "registro_cas/verificarCasPendienteFuncionario";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    $('#txtaccion_guardar').val('nuevo');
                    $('#txtidregistro_id').val(idregistro);
                    $('#registroCasModal').modal({backdrop: 'static', keyboard: false})
                    $('#registroCasModal').modal('show');
                 }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
}
function abrirDialogVerCas(idregistro)
{
    $('#verificarCasModal').modal({backdrop: 'static', keyboard: false})
    $('#verificarCasModal').modal('show');
    cargarTablaCas(idregistro);
}
function abrirDialogVerificarCas(idregistro)
{
    $('#txtaccion').val('editar');
    $('#txtidregistro').val(idregistro);
    $funcionario= $('#txtfuncionario_val').val(datos.id_funcionario);
     var enlace = base_url + "registro_cas/idRegistroCas";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                $('#txtfuncionario_val').val(datos.id_funcionario);
                $('#txtfuncionario').html(datos.id_funcionario);
                $('#txtnumero_cas').html(datos.numero_cas);
                $('#txtfechas_cas').html(datos.fecha_cas);
                $('#txtdias').html(datos.dias);
                $('#txtmeses').html(datos.meses);
                $('#txtanhios').html(datos.anhios);
                $('#txtrespaldo').html(datos.respaldo);
                $('#txtdias_calculados').html(datos.dias_vacacion);
             });
            $('#verificarCasModal').modal({backdrop: 'static', keyboard: false})
            $('#verificarCasModal').modal('show');
       }
    });
}
function GuardarRegistro()
{
    if(validarFormulario())
    {
        var enlace = base_url + "registro_cas/guardarRegistroCas";
        var datos = $('#formregistroCas').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 1)
                    {
                        alert(datos.mensaje);
                        $('#registroCasModal').modal('hide');
                    }
                    else
                    {
                        alert(datos.mensaje);
                    }
                });
            }
        });
        //cargartabla();
    }
    else
    {
        $('#validacionformulario').text("Verificar: "+alertaValidacion);
        $('#validacionformulario').show();
        alertaValidacion="";
    }
}
function editarRegistroCas(idregistro)
{
    $('#txtaccion').val('editar');
    $('#txtidregistro').val(idregistro);
     var enlace = base_url + "registro_cas/idRegistroCas";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                 $('#txtnumero_cas').val(datos.numero_cas);
                 $('#txtfechas_cas').val(datos.fecha_cas);
                 $('#txtdias').val(datos.dias);
                 $('#txtmeses').val(datos.meses);
                 $('#txtanhios').val(datos.anhios);
            });
            $('#registroCasModal').modal({backdrop: 'static', keyboard: false})
            $('#registroCasModal').modal('show');
       }
    });
}
function editarVerificarRegistroCas(idregistro)
{
    var enlace = base_url + "registro_cas/idRegistroCasEditar";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {   var result = JSON.parse(data);
            $.each(result, function(i, datos){
                $('#txtidregistro_id_editar').val(datos.id);
                $('#txtnumero_cas_editar').val(datos.numero_cas);
                $('#txtfechas_cas_editar').val(datos.fecha_cas);
                $('#txtdias_editar').val(datos.dias);
                $('#txtmeses_editar').val(datos.meses);
                $('#txtanhios_editar').val(datos.anhios);
                $('#txtrespaldo_editar').val(datos.respaldo);
            });
       }
    });
}
function editarFuncionarioCas()
{
    if(validarFormulario())
    {
        var enlace = base_url + "registro_cas/editarCasFuncionario";
        var datos = $('#formvalidacionCasformulario').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 1)
                    {
                        alert(datos.mensaje);
                        $('#registroVerificarCasModal').modal('hide');
                    }
                    else
                    {
                        alert(datos.mensaje);
                    }
                });
            }
        });
      //  cargarTablaCas();
    }
    else
    {
        $('#validacionformulario').text("Verificar: "+alertaValidacion);
        $('#validacionformulario').show();
        alertaValidacion="";
    }
}
function verificarCas()
{
    if(validarFormularioVerificacion())
    {
        var enlace = base_url + "registro_cas/editarCasFuncionario";
        var datos = $('#formEditarformulario').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 1)
                    {
                        alert(datos.mensaje);
                        $('#verificarCasModal').modal('hide');
                    }
                    else
                    {
                        alert(datos.mensaje);
                    }
                });
            }
        });
       // cargarTablaCas();
    }
    else
    {
        $('#validacionformulario').text("Verificar: "+alertaValidacion);
        $('#validacionformulario').show();
        alertaValidacion="";
    }
}
function validarFormulario()
{
    $("#txtnumero_cas").parent().removeClass('has-danger')
    $("#txtnumero_cas").removeClass('form-control-danger')
    $("#txtnumero_cas_error").hide();
    $("#txtfechas_cas").parent().removeClass('has-danger')
    $("#txtfechas_cas").removeClass('form-control-danger')
    $("#txtfechas_cas_error").hide();
    $("#txtdias").parent().removeClass('has-danger')
    $("#txtdias").removeClass('form-control-danger')
    $("#txtdias_error").hide();
    $("#txtdias_error_mayor").hide();
    $("#txtmeses").parent().removeClass('has-danger')
    $("#txtmeses").removeClass('form-control-danger')
    $("#txtmeses_error").hide();
    $("#txtmeses_error_mayor").hide();
    $("#txtanhios").parent().removeClass('has-danger')
    $("#txtanhios").removeClass('form-control-danger')
    $("#txtanhios_error").hide();
    $("#txtanhios_mayor").hide();

    if($("#txtnumero_cas").val())
    {
        if($("#txtfechas_cas").val())
        {
            if($("#txtdias").val())
            {
                if($("#txtdias").val()<=31)
                {
                    if($("#txtmeses").val())
                    {
                        if($("#txtmeses").val()<=12)
                        {
                            if($("#txtanhios").val())
                            {
                                if($("#txtanhios").val()<=44)
                                {
                                    if($("#txtrespaldo").val())
                                    {
                                        var todook = true;
                                    }
                                    else
                                    {
                                        $("#txtrespaldo").parent().addClass('has-danger')
                                        $("#txtrespaldo").addClass('form-control-danger')
                                        $("#txtrespaldo_error").show();
                                        var todook = false;
                                    }
                                }
                                else
                                {
                                    $("#txtanhios").parent().addClass('has-danger')
                                    $("#txtanhios").addClass('form-control-danger')
                                    $("#txtanhios_error_mayor").show();
                                    var todook = false;
                                }
                             }
                            else
                            {
                                $("#txtanhios").parent().addClass('has-danger')
                                $("#txtanhios").addClass('form-control-danger')
                                $("#txtanhios_error").show();
                                var todook = false;
                            }
                        }
                        else
                        {
                            $("#txtmeses").parent().addClass('has-danger')
                            $("#txtmeses").addClass('form-control-danger')
                            $("#txtmeses_error_mayor").show();
                            var todook = false;
                        }
                    }
                    else
                    {
                        $("#txtmeses").parent().addClass('has-danger')
                        $("#txtmeses").addClass('form-control-danger')
                        $("#txtmeses_error").show();
                        var todook = false;
                    }
                }
                else
                {
                    $("#txtdias").parent().addClass('has-danger')
                    $("#txtdias").addClass('form-control-danger')
                    $("#txtdias_error_mayor").show();
                    var todook = false;
                }
            }
            else
            {
                $("#txtdias").parent().addClass('has-danger')
                $("#txtdias").addClass('form-control-danger')
                $("#txtdias_error").show();
                var todook = false;
            }
        }
        else
        {
            $("#txtfechas_cas").parent().addClass('has-danger')
            $("#txtfechas_cas").addClass('form-control-danger')
            $("#txtfechas_cas_error").show();
            var todook = false;
        }
    }
    else
    {
        $("#txtnumero_cas").parent().addClass('has-danger')
        $("#txtnumero_cas").addClass('form-control-danger')
        $("#txtnumero_cas_error").show();
        var todook = false;
    }
    alertaValidacion = 'error';
    return todook;
}
function validarFormularioVerificacion()
{
    $("#txtrespaldo_editar").parent().removeClass('has-danger')
    $("#txtrespaldo_editar").removeClass('form-control-danger')
    $("#txtrespaldo_error").hide();

    if($("#txtrespaldo_editar").val())
    {
        var todook = true;
    }
    else
    {
        $("#txtrespaldo_editar").parent().addClass('has-danger')
        $("#txtrespaldo_editar").addClass('form-control-danger')
        $("#txtrespaldo_error").show();
        var todook = false;
    }
    alertaValidacion = 'error';
    return todook;
}
