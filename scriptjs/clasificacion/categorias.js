var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    cargarTablaCategoria();
}
function cargarTablaCategoria()
{
    var enlace = base_url + "Clasificacion/categorias/cargartablasCategoria";
    $('#idTablaCategoria').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}
function editarCategoria($id)
{
    $("#txtcodigo").parent().removeClass('has-danger')
    $("#txtcodigo").removeClass('form-control-danger')
    $("#txtcodigo_error").hide();
    $("#txtdescripcion").parent().removeClass('has-danger')
    $("#txtdescripcion").removeClass('form-control-danger')
    $("#txtdescripcion_error").hide();

    var enlace = base_url + "Clasificacion/categorias/idRegistroCategoria";
       $.ajax({
         type: "POST",
         url: enlace,
         data:{id:$id},
        success: function(data) {
         var result = JSON.parse(data);
         $.each(result, function(i, datos){
             $('#id_categoria').val(datos.id);
             $('#txtcodigo').val(datos.codigo);
             $('#txtdescripcion').val(datos.descripcion);
         });
         }
     });
     $('#registroCategoriaModal').modal({backdrop: 'static', keyboard: false})
     $('#registroCategoriaModal').modal('show');
}
function guardar()
{
    if(validar())
    {
        var enlace = base_url + "Clasificacion/categorias/guardarCategoria";
        var datos = $('#formCategoria').serialize();
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
                        $('#registroCategoriaModal').modal('hide');
                        swal({title: "OK",text: datos.mensaje,icon: "success",button: "OK",});
                    }
                    else
                    {
                        swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                    }
                });
            }
        });
        cargarTablaCategoria();
    }
}
function validar()
{
    $("#txtcodigo").parent().removeClass('has-danger')
    $("#txtcodigo").removeClass('form-control-danger')
    $("#txtcodigo_error").hide();
    $("#txtdescripcion").parent().removeClass('has-danger')
    $("#txtdescripcion").removeClass('form-control-danger')
    $("#txtdescripcion_error").hide();

    if($("#txtcodigo").val())
   {
       if($("#txtdescripcion").val())
       {
            var todook = true;
       }
       else
       {
           $("#txtdescripcion").parent().addClass('has-danger')
           $("#txtdescripcion").addClass('form-control-danger')
           $("#txtdescripcion_error").show();
           var todook = false;
       }
   }
   else
   {
       $("#txtcodigo").parent().addClass('has-danger')
       $("#txtcodigo").addClass('form-control-danger')
       $("#txtcodigo_error").show();
       var todook = false;
   }
   alertaValidacion = 'error';
   return todook;
}