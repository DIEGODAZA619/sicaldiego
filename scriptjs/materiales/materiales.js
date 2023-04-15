var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    cargarTablaMateriales();
}
function cargarCombos()
{
    cargarComboCategoria();
    cargarComboUnidad();
}
function cargarComboCategoria()
{ 
   var enlace = base_url + "Materiales/materiales/listarCategoria";
   $.ajax({
       type: "GET",
       url: enlace,
      success: function(data) {
           $('#cbcategoria').html(data);
       }
   });
}
function cargarComboSubCategoria()
{
   var id = $('#cbcategoria').val();
   var enlace = base_url + "Materiales/materiales/listarSubCategoria";
   $.ajax({
       type: "POST",
       url: enlace,
       data: {id:id},
      success: function(data) {
           $('#cbsubcategoria').html(data);
       }
   });
}
function cargarComboMaterial()
{
   var id = $('#cbsubcategoria').val();
   generarCodigo(id);
   var enlace = base_url + "Materiales/materiales/listarMaterial";
   $.ajax({
       type: "POST",
       url: enlace,
       data: {id:id},
      success: function(data) {
           $('#cbmaterial').html(data);
       }
   });
}
function cargarComboUnidad()
{
   var enlace = base_url + "Materiales/materiales/listarUnidad";
   $.ajax({
       type: "GET",
       url: enlace,
      success: function(data) {
           $('#cbunidad').html(data);
       }
   });
}
function cargarTablaMateriales()
{
    var enlace = base_url + "Materiales/materiales/cargartablasMateriales";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}
function adicionarMaterial()
{
    $('#formMateriales')[0].reset();
    $('#registroMaterialModal').modal({backdrop: 'static', keyboard: false})
    $('#registroMaterialModal').modal('show');
}
function editarMaterial($id)
{
    $('#texto').val('Editar');
    $('#imgSalida').attr('src','');
    
    var enlace = base_url + "Materiales/materiales/idRegistroMaterial";
       $.ajax({
         type: "POST",
         url: enlace,
         data:{id:$id},
        success: function(data) {
         var result = JSON.parse(data);
         $.each(result, function(i, datos){
             $('#id_material').val(datos.id);
             $('#txtcodigo').val(datos.codigo);
             $('#txtdescripcion').val(datos.descripcion);
             $('#cbunidad option[value="'+datos.id_unidad+'"]').prop('selected','selected');
             $('#cbcategoria option[value="'+datos.categoria+'"]').prop('selected','selected');

             var id = $('#cbcategoria').val();
             var enlace = base_url + "Materiales/materiales/listarSubCategoria";
             $.ajax({
                 type: "POST",
                 url: enlace,
                 data: {id:id},
                success: function(data) {
                     $('#cbsubcategoria').html(data);
                     $('#cbsubcategoria option[value="'+datos.subcategoria+'"]').prop('selected','selected');

                     var id_cat = $('#cbsubcategoria').val();
                     var enlace = base_url + "Materiales/materiales/listarMaterial";
                         $.ajax({
                             type: "POST",
                             url: enlace,
                             data: {id:id_cat},
                             success: function(data) {
                                 $('#cbmaterial').html(data);
                                 $('#cbmaterial option[value="'+datos.id_categoria+'"]').prop('selected','selected');
                             }
                         });
                 }
             });
         });
         }
     });
     $('#registroMaterialModal').modal({backdrop: 'static', keyboard: false})
     $('#registroMaterialModal').modal('show');
}
function guardar()
{
    if(validar())
    {
        var enlace = base_url + "Materiales/materiales/guardarMaterial";
        var formData  = new FormData($('#formMateriales')[0]);//$('#formMateriales').serialize();
       // var files = $('#file-input')[0].files[0];
       //formData.append("file"  , files);
        $.ajax({
            type: "POST",
            url: enlace,
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                    if(datos.resultado == 1)
                    {
                        $('#registroMaterialModal').modal('hide');
                        swal({title: "OK",text: datos.mensaje,icon: "success",button: "OK",});
                    }
                    else
                    {
                        swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});
                    }
                });
            }
        });
        cargarTablaMateriales();
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
    $("#cbcategoria").parent().removeClass('has-danger')
    $("#cbcategoria").removeClass('form-control-danger')
    $("#cbcategoria_error").hide();
    $("#cbsubcategoria").parent().removeClass('has-danger')
    $("#cbsubcategoria").removeClass('form-control-danger')
    $("#cbsubcategoria_error").hide();
    $("#cbmaterial").parent().removeClass('has-danger')
    $("#cbmaterial").removeClass('form-control-danger')
    $("#cbmaterial_error").hide();
    $("#cbunidad").parent().removeClass('has-danger')
    $("#cbunidad").removeClass('form-control-danger')
    $("#cbunidad_error").hide();

   /* if($("#txtcodigo").val())
   {*/
       if($("#txtdescripcion").val())
       {
           if($("#cbcategoria").val()>0)
           {
               if($("#cbsubcategoria").val()>0)
               {
                   if($("#cbmaterial").val()>0)
                   {
                       if($("#cbunidad").val()>0)
                       {
                           var todook = true;
                       }
                       else
                       {
                           $("#cbunidad").parent().addClass('has-danger')
                           $("#cbunidad").addClass('form-control-danger')
                           $("#cbunidad_error").show();
                           var todook = false;
                       }
                   }
                   else
                   {
                       $("#cbmaterial").parent().addClass('has-danger')
                       $("#cbmaterial").addClass('form-control-danger')
                       $("#cbmaterial_error").show();
                       var todook = false;
                   }
               }
               else
               {
                   $("#cbsubcategoria").parent().addClass('has-danger')
                   $("#cbsubcategoria").addClass('form-control-danger')
                   $("#cbsubcategoria_error").show();
                   var todook = false;
               }
           }
           else
           {
               $("#cbcategoria").parent().addClass('has-danger')
               $("#cbcategoria").addClass('form-control-danger')
               $("#cbcategoria_error").show();
               var todook = false;
           }
       }
       else
       {
           $("#txtdescripcion").parent().addClass('has-danger')
           $("#txtdescripcion").addClass('form-control-danger')
           $("#txtdescripcion_error").show();
           var todook = false;
       }
  /* }
   else
   {
       $("#txtcodigo").parent().addClass('has-danger')
       $("#txtcodigo").addClass('form-control-danger')
       $("#txtcodigo_error").show();
       var todook = false;
   }*/
   alertaValidacion = 'error';
   return todook;
}
function generarCodigo(idCat)
{
    //alert(idCat);
    var codigo = $('#txtcodigo').val();
    if(codigo.length == 0)
    {
      var enlace = base_url + "Materiales/materiales/generarCodigo";
        $.ajax({
            type: "POST",
            url: enlace,
            data: {codigo:idCat},
            dataType: "json",
            success: function(data)
            {
                if(data.respuesta)
                {
                    $('#txtcodigo').val(data.codigo);
                }
                else
                {
                    swal({title: "ERROR",text: 'No se pudo generar el codigo',icon: "error",button: "Error"});
                }
            }
        });  
    }

     
}
