var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function cargarAvatar()
{
    /*var enlace = base_url + "ficha/getDatosPersonales";
    $.ajax({
        type: "POST",
        url: enlace,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                if(datos.foto=='t')
                {
                    cargar_imagen = base_url+'upload/'+datos.id+'/'+datos.id+'_fotoPerfil'+datos.extension_foto;
                    $("#miniatura_foto_perfil").attr("src", cargar_imagen+"?timestamp=" + new Date().getTime());
                }else{
                    $("#miniatura_foto_perfil").attr("src", base_url+'resources/images/faces/face.jpg?timestamp=' + new Date().getTime());
                }
            });
        }
    });*/
}

function cargarTablaIngresosNoAprobados()
{
    var enlace = base_url + "inicio/cargartablaSolicitudesNoAprobados";
    $('#idTablaIngreso').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "POST",
            url: enlace,
        },
    });
}
function cargarMaterialesAcumulados()
{
   var idIngreso = $('#txtIdIngreso').val();
   var enlace = base_url + "inicio/cargartablasMaterialesAcumulados";
    $('#idTablaAcumulador').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "POST",
            url: enlace
        },
    });
}

function verVideotutorial(){
    $('#videoTutorial').modal({backdrop: 'static', keyboard: false})
    $('#videoTutorial').modal('show');
}