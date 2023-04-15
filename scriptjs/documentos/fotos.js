var base_url;
var alertaValidacion = '';
function baseurlFotos(enlace)
{
    base_url = enlace;
}


function cargarImagen(id_material)
{
    alert(id_material);

    $('#idMaterial').val();    
    $('#cargarArchivoModal').modal({backdrop: 'static', keyboard: false})
    $('#cargarArchivoModal').modal('show');
}


function guardarArchivoM()
{
    $("#cargarArchivoModal").hide();
    //$("#pdfModal").hide();
    var archivo = $("#fileImg").val();
    var extensiones = archivo.substring(archivo.lastIndexOf("."));
   /* if(extensiones != ".jpeg" || extensiones != ".png" || extensiones != ".jpg")
    {
        $("#divCapa").removeClass("overlay");
        swal({title: "ALERTA",text:"El archivo de tipo ' " + extensiones + " '  no es válido! \n Debe subir sólo archivos con extension png , jpeg ,jpg ",icon: "warning",button: "OK",});
        //alert("El archivo de tipo " + extensiones + " no es válido");
        return false;
    }*/
    $('#loading').show();
    var formData = new FormData($('#formRegistroArchivo')[0]);
    var enlace = base_url + "Fotografias/Fotografias/guardarDocumentoImg";
    $.ajax({
        type: "POST",
        url: enlace,
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        dataType: 'JSON',
        success: function(data) {
            $("#divCapa").removeClass("overlay");
            $('#loading').hide();
            alert(data.mensaje);
            var idBien = $("#idMaterial").val();
            cargarTablaMateriales()
            
        },
        error: function (e) {
                //$("#output").text(e.responseText);
                console.log("ERROR : ", e);
        }
    });

}