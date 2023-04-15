var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones(tipoSolicitud)
{
    $('#tipo_solicitud').val(tipoSolicitud);
    cargarTablaConfirmacionsolicitudes();
    cargarTablasolicitudes();
    /*limpiarFormularioIngreso();    
    cargarMaterialesAcumulados(); */
    habilitarTablasBotones();


}
function habilitarTablasBotones()
{
    $('#guardarIngreso').on('click', function() {
        guardarIngreso();
    });
}
function cargarTablaConfirmacionsolicitudes()
{
    var enlace = base_url + "Solicitudes/Confirmar_direccion/cargartablaSolicitudesConfirmadas";
    $('#idTablaMaterialesConfirmados').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 3,
         "ajax": {
            type: "POST",
            url: enlace,            
        },
    });
}

function cargarTablasolicitudes()
{
    var enlace = base_url + "Solicitudes/Confirmar_direccion/cargartablasMaterialesSolicitados";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[15, 20, 50, -1], [15, 20, 50, "Todos"]],
        "iDisplayLength": 15,
         "ajax": {
            type: "POST",
            url: enlace,            
        },
    });
}


function cargarTablasolicitudesIdConfirmacion(idConfirmacion)
{
    var enlace = base_url + "Solicitudes/Confirmar_direccion/cargarTablasolicitudesIdConfirmacion";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 3,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {id_conf: idConfirmacion},           
        },
    });
}

function confirmarPedidoDireccion()
{
    $('#txtMotivo').val('');
    $('#motivoSolicitudModal').modal({backdrop: 'static', keyboard: false})
    $('#motivoSolicitudModal').modal('show');
}

function confirmarPedidoDireccionConMotivo()
{
    var motivo = $('#txtMotivo').val();
    if(motivo.length>7){
        var enlace = base_url + "Solicitudes/Confirmar_direccion/confirmarPedidoDireccion";

        $.ajax({
            type: "POST",
            url: enlace,
            data: {motivo: motivo},
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 1)
                    {
                        $('#motivoSolicitudModal').modal('hide');
                        swal({title: "OK", text:datos.mensaje, icon: "success", button: "OK"})
                            .then((value) => {
                                cargarTablaConfirmacionsolicitudes();
                                cargarTablasolicitudes();
                            });
                    }
                    else
                    {
                        swal({title: "Error", text:datos.mensaje, icon: "error", button: "Cerrar"});
                    }
                });
            }
        });
    } else {
        swal({title: "Error", text:"El Motivo debe tener al menos 7 caracteres para registrarse correctamente", icon: "error", button: "Cerrar"})
    }

}

// reportes 
function reporteMaterialConfirmado(fil)
{
    window.open(base_url+"Solicitudes/Confirmar_direccion/reporteMaterialConfirmado/"+fil);
}

function reporteMaterialEntregado(fil)
{
    window.open(base_url+"Solicitudes/Reporte_entregas/reporteMaterialEntregado/"+fil);
}


function recharSolicitudDetalles(id_solicitud)
{
    if(confirm('¿Estas seguro de rechar el registro de solicitud de material?'))
    {
        var enlace = base_url + "Solicitudes/Confirmar_direccion/rechazarSolicitudMaterial";
        $.ajax({
            type: "POST",
            url: enlace,
            data: {id_sol: id_solicitud},
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 0)
                    {
                        alert(datos.mensaje);
                    }
                    else
                    {
                        swal({title: "Rechazado",text: datos.mensaje,icon: "success",button: "OK",});
                        //alert(datos.mensaje);
                        cargarTablaConfirmacionsolicitudes();
                        cargarTablasolicitudes();
                    }
                });
            }
        });
    }
    else
    {
        return false;
    }
}

function limpiarFormularioIngreso()
{
    $('#nombre_producto').text('Producto seleccionado: ');
    $('#guardarIngreso').prop('disabled', true);
    $('#txtCantidad').prop('disabled', true);
    $('#txtCantidad').val('');
    $('#accion').val('');
    $('#id_ingreso').val('');
    $('#id_material').val('');
    $('#id_registro').val('');
}
function editarSolicitudMaterial(id_solicitud)
{       
    $('#solicitudModal').modal({backdrop: 'static', keyboard: false})
    $('#solicitudModal').modal('show');
    limpiarFormularioIngreso();
    var enlace = base_url + "Solicitudes/Solicitudes/getSolicitudMaterialesId";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id_sol: id_solicitud},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 0)
                {
                    alert(datos.mensaje);
                }
                else
                {
                    $('#accion').val('editar');
                    $('#id_material').val(datos.id_material);
                    $('#id_registro').val(id_solicitud);
                    $('#txtCantidad').val(datos.cantidad_solicitada);
                    $('#guardarIngreso').prop('disabled', false);
                    $('#guardarIngreso').text('Editar');
                    $('#txtCantidad').prop('disabled', false);
                    descripcionMaterial(datos.id_material);
                }
            });
        }
    });

}

function descripcionMaterial(id_material)
{
    var enlace = base_url + "Ingreso/ingreso/getMaterialesId";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id_mat: id_material},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    $('#nombre_producto').text('Producto seleccionado: '+datos.descripcion);
                }
                else
                {
                    swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});

                   // alert(datos.mensaje);
                }
            });
        }
    });
}


function guardarIngreso()
{
    if (validardatos())
    {
        if(confirm('¿Estas seguro de editar la cantidad de material?'))
        {
            $('#validacionpermiso').hide();
            var enlace = base_url + "Solicitudes/Solicitudes/guardarSolicitudMateriales";
            var datos = $('#formularioSolicitudMaterial').serialize();
            $.ajax({
                type: "POST",
                url: enlace,
                data: datos,
                success: function(data)
                {
                    var result = JSON.parse(data);
                    $.each(result, function(i, datos)
                    {
                        if(datos.resultado == 0)
                        {
                            //cargarTablaMateriales();
                            swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                            //alert(datos.mensaje);
                        }
                        else
                        {
                            swal({title: "REGISTRADO",text: datos.mensaje,icon: "success",button: "OK",});
                           // alert('EL MATERIAL FUE REGISTRADO CORRECTAMENTE...!!!');
                            $('#solicitudModal').modal('hide');
                            limpiarFormularioIngreso();
                            cargarTablaConfirmacionsolicitudes();
                            cargarTablasolicitudes();
                        }
                    });
                }
            });
        }
        else
        {
            $('#idvalidacion').hide();
            return false;
        }
    }
    else
    {

        $('#validacionIngreso').text("Ingresar: " + alertaValidacion);
        $('#validacionIngreso').show();

        // alert("Falta llenar o seleccionar los campos: \n"+alertaValidacion+"\n deberán ser llenados o seleccionados");
        alertaValidacion = "";
    }
}
function validardatos()
{
    var todook = true;
    if ($('#txtCantidad').val() == '') {
        todook = false;
        $('#txtCantidad').closest(".form-group").addClass("has-error");
        alertaValidacion += " Cantidad de ingreso -  \n";
    }
    return todook;
}


