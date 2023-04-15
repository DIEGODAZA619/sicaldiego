var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    cargarTablaProveedores();
}
function cargarTablaProveedores()
{
    var enlace = base_url + "Materiales/proveedores/cargartablasProveedores";
    $('#idTablaProveedores').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}
function adicionarProveedor()
{
    $('#formProveedor')[0].reset();
    $("#txtcodigo_proveedor").parent().removeClass('has-danger')
    $("#txtcodigo_proveedor").removeClass('form-control-danger')
    $("#txtcodigo_proveedor_error").hide();
    $("#txtnombre_proveedor").parent().removeClass('has-danger')
    $("#txtnombre_proveedor").removeClass('form-control-danger')
    $("#txtnombre_proveedor_error").hide();
    $("#txtlegal_proveedor").parent().removeClass('has-danger')
    $("#txtlegal_proveedor").removeClass('form-control-danger')
    $("#txtlegal_proveedor_error").hide();
    $("#nit").parent().removeClass('has-danger')
    $("#nit").removeClass('form-control-danger')
    $("#nit_error").hide();
    $("#celular").parent().removeClass('has-danger')
    $("#celular").removeClass('form-control-danger')
    $("#celular_error").hide();
    $('#registroProveedorModal').modal({backdrop: 'static', keyboard: false})
    $('#registroProveedorModal').modal('show');
}
function editarProveedor($id)
{
    $('#texto').val('Editar');
    var enlace = base_url + "Materiales/proveedores/idRegistroProveedor";
       $.ajax({
         type: "POST",
         url: enlace,
         data:{id:$id},
        success: function(data) {
         var result = JSON.parse(data);
         $.each(result, function(i, datos){
             $('#id_proveedor').val(datos.id);
             $('#txtcodigo_proveedor').val(datos.codigo);
             $('#txtnombre_proveedor').val(datos.nombre_proveedor);
             $('#txtlegal_proveedor').val(datos.legal_proveedor);
             $('#nit').val(datos.nit);
             $('#correo').val(datos.correo);
             $('#celular').val(datos.celular);
             $('#direccion').val(datos.direccion);
             $('#observacion').val(datos.observaciones);
             $('#txtnombre_proveedor').val(datos.nombre_proveedor);
         });
         }
     });
     $('#registroProveedorModal').modal({backdrop: 'static', keyboard: false})
     $('#registroProveedorModal').modal('show');
}
function guardar()
{
    if(validar())
    {
        var enlace = base_url + "Materiales/proveedores/guardarProveedores";
        var datos = $('#formProveedor').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                    if(datos.resultado == 1)
                    {
                        $('#registroProveedorModal').modal('hide');
                        swal({title: "OK",text: datos.mensaje,icon: "success",button: "OK",});
                        cargarTablaProveedores();
                    }
                    else
                    {
                        swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                    }
                });
            }
        });
    }
}
function validar()
{
    //$("#txtcodigo_proveedor").parent().removeClass('has-danger')
    //$("#txtcodigo_proveedor").removeClass('form-control-danger')
    $("#txtcodigo_proveedor_error").hide();
    $("#txtnombre_proveedor").parent().removeClass('has-danger')
    $("#txtnombre_proveedor").removeClass('form-control-danger')
    $("#txtnombre_proveedor_error").hide();
    $("#txtlegal_proveedor").parent().removeClass('has-danger')
    $("#txtlegal_proveedor").removeClass('form-control-danger')
    $("#txtlegal_proveedor_error").hide();
    $("#nit").parent().removeClass('has-danger')
    $("#nit").removeClass('form-control-danger')
    $("#nit_error").hide();
    $("#celular").parent().removeClass('has-danger')
    $("#celular").removeClass('form-control-danger')
    $("#celular_error").hide();

   /*if($("#txtcodigo_proveedor").val())
   {
    */
       if($("#txtnombre_proveedor").val())
       {
           if($("#txtlegal_proveedor").val())
           {
               if($("#nit").val())
               { var todook = true;
                   /*if($("#celular").val())
                   {
                        var todook = true;
                   }
                   else
                   {
                       $("#celular").parent().addClass('has-danger')
                       $("#celular").addClass('form-control-danger')
                       $("#celular_error").show();
                       var todook = false;
                   }*/
               }
               else
               {
                   $("#nit").parent().addClass('has-danger')
                   $("#nit").addClass('form-control-danger')
                   $("#nit_error").show();
                   var todook = false;
               }
           }
           else
           {
               $("#txtlegal_proveedor").parent().addClass('has-danger')
               $("#txtlegal_proveedor").addClass('form-control-danger')
               $("#txtlegal_proveedor_error").show();
               var todook = false;
           }
       }
       else
       {
           $("#txtnombre_proveedor").parent().addClass('has-danger')
           $("#txtnombre_proveedor").addClass('form-control-danger')
           $("#txtnombre_proveedor_error").show();
           var todook = false;
       }
  /* }
   else
   {
       $("#txtcodigo_proveedor").parent().addClass('has-danger')
       $("#txtcodigo_proveedor").addClass('form-control-danger')
       $("#txtcodigo_proveedor_error").show();
       var todook = false;
   }*/
   alertaValidacion = 'error';
   return todook;
}