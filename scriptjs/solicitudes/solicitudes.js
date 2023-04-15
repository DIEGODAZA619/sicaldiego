var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones(tipoSolicitud)
{
    $('#tipo_solicitud').val(tipoSolicitud);
    cargarTablaMateriales();
    limpiarFormularioIngreso();
    cargarMaterialesAcumulados();
    habilitarTablasBotones();


}

function habilitarTablasBotones()
{
    $('#guardarIngreso').on('click', function() {
        guardarIngreso();
    });
}

function cargarTablaMateriales()
{
    var enlace = base_url + "Solicitudes/Solicitudes/cargartablasMaterialesAlmacen";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 3,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}


function agregarMateriales(id_ingreso)
{
    $('#txtIdIngreso').val(id_ingreso);
    cargarMaterialesAcumulados();
    $('#tablaIngresos').hide();
    $('#cargarIngresos').show();
}

function cargarMaterialesAcumulados()
{
   var idIngreso = $('#txtIdIngreso').val();
   var enlace = base_url + "Solicitudes/Solicitudes/cargartablasMaterialesAcumulados";
    $('#idTablaAcumulador').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {id_ing: idIngreso}
        },
    });
}

function seleccionarMaterial(id_material)
{
    var enlace = base_url + "Solicitudes/Solicitudes/verificarMaterialSeleccionado";
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
                    $('#solicitudModal').modal({backdrop: 'static', keyboard: false})
                    $('#solicitudModal').modal('show');
                    cargarIngresoMaterial(id_material);
                }
                else
                {
                  limpiarFormularioIngreso();
                  swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                 // alert(datos.mensaje);
                }
            });
        }
    });
}
function cargarIngresoMaterial(id_material)
{
    $('#accion').val('nuevo');
    $('#id_registro').val('');
    $('#txtCantidad').val('');
    $('#id_material').val(id_material);
    $('#guardarIngreso').prop('disabled', false);
    $('#txtCantidad').prop('disabled', false);
    $('#guardarIngreso').text('Agregar');
    descripcionMaterial(id_material);
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

function guardarIngreso()
{
    if (validardatos())
    {
        if(confirm('¿Estas seguro de registrar la cantidad de material?'))
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
                            cargarTablaMateriales();
                            swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                            //alert(datos.mensaje);
                        }
                        else
                        {
                            swal({title: "REGISTRADO",text: datos.mensaje,icon: "success",button: "OK",});
                           // alert('EL MATERIAL FUE REGISTRADO CORRECTAMENTE...!!!');
                           $('#solicitudModal').modal('hide');
                            limpiarFormularioIngreso();
                            cargarTablaMateriales();
                            cargarMaterialesAcumulados();
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
function eliminarIngresoDetalles(id_solicitud)
{
    if(confirm('¿Estas seguro eliminar el registro de material?'))
    {
        var enlace = base_url + "Solicitudes/Solicitudes/eliminarSolicitudMaterial";
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
                        swal({title: "ELIMINADO",text: datos.mensaje,icon: "success",button: "OK",});
                        //alert(datos.mensaje);
                        limpiarFormularioIngreso();
                        cargarTablaMateriales();
                        cargarMaterialesAcumulados();
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

function editarSolicitudMaterial(id_solicitud)
{   $('#solicitudModal').modal({backdrop: 'static', keyboard: false})
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


function init_contadorTa(idtextarea, idcontador, max) {

    $("#" + idtextarea).keyup(function() {
        ContadorTa(idtextarea, idcontador, max);
    });
    $("#" + idtextarea).change(function() {
        ContadorTa(idtextarea, idcontador, max);
    });

}

function ContadorTa(idtextarea, idcontador, max) {
    var contador = $("#" + idcontador);
    var ta = $("#" + idtextarea);
    contador.html("0/" + max);

    contador.html(ta.val().length + "/" + max);
    if (parseInt(ta.val().length) > max)
    {
        ta.val(ta.val().substring(0, max - 1));
        contador.html(max + "/" + max);
    }
}


