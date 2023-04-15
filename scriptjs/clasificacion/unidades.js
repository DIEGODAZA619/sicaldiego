var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    cargarTablaUnidades();
}
function cargarTablaUnidades()
{
    var enlace = base_url + "Clasificacion/unidades/cargartablasUnidades";
    $('#idTablaUnidades').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}
function editarUnidad($id)
{
    $("#txtcodigo_unidad").parent().removeClass('has-danger')
    $("#txtcodigo_unidad").removeClass('form-control-danger')
    $("#txtcodigo_unidad_error").hide();
    $("#txtdescripcion_unidad").parent().removeClass('has-danger')
    $("#txtdescripcion_unidad").removeClass('form-control-danger')
    $("#txtdescripcion_unidad_error").hide();

    var enlace = base_url + "Clasificacion/unidades/idRegistroUnidad";
       $.ajax({
         type: "POST",
         url: enlace,
         data:{id:$id},
        success: function(data) {
         var result = JSON.parse(data);
         $.each(result, function(i, datos){
             $('#id_unidad').val(datos.id);
             $('#txtcodigo_unidad').val(datos.codigo);
             $('#txtdescripcion_unidad').val(datos.descripcion);
         });
         }
     });
     $('#registroUnidadModal').modal({backdrop: 'static', keyboard: false})
     $('#registroUnidadModal').modal('show');
}
function guardar()
{
    if(validar())
    {
        var enlace = base_url + "Clasificacion/unidades/guardarUnidad";
        var datos = $('#formUnidad').serialize();
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
                        $('#registroUnidadModal').modal('hide');
                        swal({title: "OK",text: datos.mensaje,icon: "success",button: "OK",});
                    }
                    else
                    {
                        swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                    }
                });
            }
        });
        cargarTablaUnidades();
    }
}
function validar()
{
    $("#txtcodigo_unidad").parent().removeClass('has-danger')
    $("#txtcodigo_unidad").removeClass('form-control-danger')
    $("#txtcodigo_unidad_error").hide();
    $("#txtdescripcion_unidad").parent().removeClass('has-danger')
    $("#txtdescripcion_unidad").removeClass('form-control-danger')
    $("#txtdescripcion_unidad_error").hide();

    if($("#txtcodigo_unidad").val())
   {
       if($("#txtdescripcion_unidad").val())
       {
            var todook = true;
       }
       else
       {
           $("#txtdescripcion_unidad").parent().addClass('has-danger')
           $("#txtdescripcion_unidad").addClass('form-control-danger')
           $("#txtdescripcion_unidad_error").show();
           var todook = false;
       }
   }
   else
   {
       $("#txtcodigo_unidad").parent().addClass('has-danger')
       $("#txtcodigo_unidad").addClass('form-control-danger')
       $("#txtcodigo_unidad_error").show();
       var todook = false;
   }
   alertaValidacion = 'error';
   return todook;
}