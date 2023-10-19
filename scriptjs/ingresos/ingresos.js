var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    limpiarFormularioIngreso();
    cargarProveedores();
    habilitarTablasBotones();
    cargarTablaIngresos();
    cargarTablaMateriales();

}

function abrirDialogIngresoMaterial()
{
    limpiarFormularioRegistroIngreso();
    eliminaMensajeError();
    $('#txtaccion').val('nuevo');
    $('#habilitarIngresoMaterial').modal({backdrop: 'static', keyboard: false})
    $('#habilitarIngresoMaterial').modal('show');
}
function limpiarFormularioRegistroIngreso()
{
    $('#txtOrden').val('');
    $('#txtNotaRemision').val('');
    $('#txtNumeroFactura').val('');
    $('#txtfecha_factura').val('');
    cargarProveedores();
    $('#txtmotivo').val('');
}
function cargarProveedores()
{
    var enlace = base_url + "Ingreso/ingreso/cargarProveedores";
    $.ajax({ //
        url: enlace,
        method: 'POST',
        success: function (data) {
            $('#slProveedor').html(data);
        }
    });
}

/*function registrarIngreso()
{
    alert('llega');

}*/

function registrarIngreso()
{
    if (validardatosIngreso())
    {
        if(confirm('¿Estas seguro de confirmar el registro de material?'))
        {
            $('#validacionRegistroIngreso').hide();
            var enlace = base_url + "Ingreso/ingreso/guardarRegistroIngreso";
            var datos = $('#formularioRegistroIngreso').serialize();
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
                            alert(datos.mensaje);
                        }
                        else
                        {
                            cargarTablaIngresos();
                            swal({title: "REGISTRADO",text: 'EL INGRESO DE MATERIAL FUE REGISTRADO CORRECTAMENTE...!!!',icon: "success",button: "OK",});
                        //    alert('EL INGRESO DE MATERIAL FUE REGISTRADO CORRECTAMENTE...!!!');
                            $('#habilitarIngresoMaterial').modal('hide');
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
    else
    {

        $('#validacionRegistroIngreso').text("Debe ingresar algun dato en los campos obligatorios " );
        $('#validacionRegistroIngreso').show();

        // alert("Falta llenar o seleccionar los campos: \n"+alertaValidacion+"\n deberán ser llenados o seleccionados");
        alertaValidacion = "";
    }
}



//------------------INGRESOS DE MATERIALES
function habilitarTablasBotones()
{

    $('#tablaIngresos').show();
    $('#cargarIngresos').hide();

    $('#guardarIngreso').on('click', function() {
        guardarIngreso();
    });
}
function cargarTablaIngresos()
{
    var enlace = base_url + "Ingreso/ingreso/cargarTablaIngresos";
    $('#idTablaIngreso').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}

//#idTablaIngreso > tbody > tr:nth-child(1) > td:nth-child(2)
function agregarMateriales(id_ingreso,e)
{
    $('#txtIdIngreso').val(id_ingreso);
    cargarMaterialesAcumulados();
    $('#tablaIngresos').hide();
    //alert($(e).parents("tr").find("td:nth-child(2)").html())
    $("#orden_compra").html("<b>ORDEN DE COMPRA : </b>"+ $(e).parents("tr").find("td:nth-child(2)").html());
    //$("#proveedor").load(base_url +"Materiales/Proveedores/getNombreProveedor/" + $(e).parents("tr").find("td:nth-child(7)").html());
    $("#proveedor").html("<br><b>PROVEEDOR : </b>"+ $(e).parents("tr").find("td:nth-child(7)").html());
    $("#descripcion").html("<br><b>DESCRIPCION : </b>"+ $(e).parents("tr").find("td:nth-child(8)").html());
    $('#cargarIngresos').show();
    $('#materialSeleccionado').show();

}



function cargarTablaMateriales()
{
    var enlace = base_url + "Ingreso/ingreso/cargartablasMateriales";
    $('#idTablaMateriales').DataTable({
        "autoWidth": false,
        "columns": [
                    { "width": "6%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "30%" },
                    { "width": "8%" },
                    { "width": "16%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "8%" },
                  ],
        destroy: true,
        "aLengthMenu": [[5,10, 15, 20, -1], [5,10, 15, 20, "Todos"]],
        "iDisplayLength": 5,
         "ajax": {
            type: "GET",
            url: enlace,
        },
        "fnRowCallback": function(nRow,aData,iDisplayIndex,iDisplayIndexFull) {
            if(aData[5] < 5 )
            {
                $('td', nRow).addClass('c_critico');
            }
            if(aData[5] >=5 &&  aData[5] < 10 )
            {
                $('td', nRow).addClass('c_semicritico');
            }
            
        }
    });
}
function cargarMaterialesAcumulados()
{
    var idIngreso = $('#txtIdIngreso').val();
   var enlace = base_url + "Ingreso/ingreso/cargartablasMaterialesAcumulados";
    $('#idTablaAcumuladorIn').DataTable({
        "autoWidth": false,
        "columns": [
                    { "width": "6%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "30%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "8%" },
                    { "width": "8%" },
                  ],
        destroy: true,
        "aLengthMenu": [[5,10, 15, 20, -1], [5,10, 15, 20, "Todos"]],
        "iDisplayLength": 5,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {id_ing: idIngreso}
        },
    });
}
function agregarIngreso(id_material)
{

    var id_ingreso = $('#txtIdIngreso').val();
    var enlace = base_url + "Ingreso/ingreso/verificarMaterialSeleccionado";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id_ing:id_ingreso,id_mat: id_material},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                { 
                    $('#formularioIngresoModal > .modal-dialog').parent().css('z-index', 1110);
                    $('#divCapa').addClass('overlay');
                    $('#formularioIngresoModal').modal({backdrop: 'static', keyboard: false})
                    $('#formularioIngresoModal').modal('show');
                    cargarIngresoMaterial(id_ingreso,id_material);
                }
                else
                {
                    limpiarFormularioIngreso();

                    swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                  //  alert(datos.mensaje);

                }
               // $('#materialSeleccionado').show();
            });
        }
    });
}
function cargarIngresoMaterial(id_ingreso, id_material)
{
    $('#accion').val('nuevo');
    $('#id_registro').val('');
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('#id_ingreso').val(id_ingreso);
    $('#id_material').val(id_material);
    $('#guardarIngreso').prop('disabled', false);
    $('#txtCantidad').prop('disabled', false);
    $('#txtPrecio').prop('disabled', false);
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
                    $('#cant_almacen').text('Cantidad en almacen : '+datos.saldo);
                    $('#cant_solicitada').text('Cantidad en reservada : '+datos.cantidad_solicitada);
                    $('#cant_no_solicitada').text('Cantidad no solicitada: '+(datos.saldo-datos.cantidad_solicitada) );
                }
                else
                {
                    alert(datos.mensaje);
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
    $('#txtPrecio').prop('disabled', true);
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('#accion').val('');
    $('#id_ingreso').val('');
    $('#id_material').val('');
    $('#id_registro').val('');
}

function guardarIngreso()
{
    if (validardatos())
    {
        if(confirm('¿Estas seguro de confirmar el registro de material?'))
        {
            $('#validacionpermiso').hide();
            var enlace = base_url + "Ingreso/ingreso/guardarIngresoMateriales";
            var datos = $('#formularioIngresoMaterial').serialize();
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
                            alert(datos.mensaje);
                        }
                        else
                        {
                            $("#formularioIngresoModal ").hide();
                            $("#divCapa").removeClass("overlay");
                            swal({title: "REGISTRADO",text: 'EL MATERIAL FUE REGISTRADO CORRECTAMENTE...!!!',icon: "success",button: "OK",});
                            $('#formularioIngresoModal').modal('hide');
                            // ver lista detalle de material ingresado
                            $('#materialSeleccionado').show();
                            //////////////////////////////////////////
                            limpiarFormularioIngreso();
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
    if ($('#txtPrecio').val() == '') {
        todook = false;
        $('#txtPrecio').closest(".form-group").addClass("has-error");
        alertaValidacion += " Precio Unitario -  \n";
    }
    return todook;
}
function eliminarIngresoDetalles(id_ingreso)
{
    if(confirm('¿Estas seguro eliminar el registro de material?'))
    {
        var enlace = base_url + "Ingreso/ingreso/eliminarIngresoDetalles";
        $.ajax({
            type: "POST",
            url: enlace,
            data: {id_ing: id_ingreso},
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
                     //   alert(datos.mensaje);
                        limpiarFormularioIngreso();
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

function editarIngresoDetalles(id_ingreso)
{
    limpiarFormularioIngreso();
    var enlace = base_url + "Ingreso/ingreso/getIngresoDetalleEditarId";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id_ing: id_ingreso},
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
                    $('#formularioIngresoModal').modal({backdrop: 'static', keyboard: false})
                    $('#formularioIngresoModal').modal('show');
                    $('#accion').val('editar');
                    $('#id_registro').val(id_ingreso);
                    $('#txtCantidad').val(datos.cantidad);
                    $('#txtPrecio').val(datos.precio);
                    $('#guardarIngreso').prop('disabled', false);
                    $('#guardarIngreso').text('Editar');
                    $('#txtCantidad').prop('disabled', false);
                    $('#txtPrecio').prop('disabled', false);
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

function validardatosIngreso()
{
    eliminaMensajeError()
    var respuesta = true;
    $("  input[type=text]").each(function(){
        if( $(this).attr('id') == 'txtNotaRemision'  || $(this).attr('id') == 'txtOrden' || $(this).attr('id') == 'txtNumeroFactura' )
        {
            if(this.value=='' )
            {
                    $(this).parent().addClass('form-group has-danger')
                    $(this).addClass('form-control-danger')
                    $(this).parent().append('<div class="msje_error"><small><label class="error text-danger">El Campo es requerido.</label></small></div> </div>')
                    respuesta = false;
            }
        }       
    });
    $("  input[type=date]").each(function(){
        if($(this).attr('id') == 'txtfecha_factura' || $(this).attr('id') == 'txtfecha_nota_remision'  )
        {
            if(this.value=='' )
            {
                    $(this).parent().addClass('form-group has-danger')
                    $(this).addClass('form-control-danger')
                    $(this).parent().append('<div class="msje_error"><small><label class="error text-danger">La Fecha es requerida.</label></small></div> </div>')
                    respuesta = false;
            }
        }       
    });
    /*$(" select").each(function(){
        if($(this).attr('id')=='slProveedor')
        {
            if(this.value== 0 )
            {
                    $(this).parent().addClass('form-group has-danger')
                    $(this).addClass('form-control-danger')
                    $(this).parent().append('<div class="msje_error"><small><label class="error text-danger">Debe seleccionar un registro.</label></small></div> </div>')
                    respuesta = false;
            }
        }       
    });*/
  
    return respuesta;
}
function eliminaMensajeError()
{
    $('#validacionRegistroIngreso').hide();
    $(".msje_error").each(function(){
        $(this).parent().children('input[type=text]').removeClass('form-control-danger');
        $(this).parent().removeClass('has-danger');
        $(this).remove();
    });
}


function abrirListaMaterialModal()
{
    /*$('#cargarArchivoModal > .modal-dialog').parent().css('z-index', 2000);
    $('#divCapa').addClass('overlay');*/
    $('#listaMaterialModal > .modal-dialog ').css("max-width","80%");
    $('#listaMaterialModal').modal({backdrop: 'static', keyboard: false})
    $('#listaMaterialModal').show(); 
}