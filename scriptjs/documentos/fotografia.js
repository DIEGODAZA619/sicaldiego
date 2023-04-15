var base_url;
var id_entidad;
var alertaValidacion = '';
function baseurl(enlace,entidad)
{
    base_url = enlace;
    id_entidad = entidad;
}
function historial(bien)
{
    $.ajax({
        url: base_url+"Bienes/Bienes/getTenenciaBienes/"+bien,
        success: function(data) { 
            $('#tabla_historial').html(data);
            $('#historialModal').modal('show');
        }
    });
}

function listaDocumento(bien,clase,idTipoDoc)
{

    cargarTablaDocumentosEscaneados( bien,clase, idTipoDoc);
    $('#documentosModal > .modal-lg ').css("max-width","70%");
    $('#documentosModal').modal('show');

}
function cargarTablaDocumentosEscaneados( bien , clase ,idTipoDoc )
{
    var enlace = base_url + "DocumentoEscaneado/DocumentoEscaneado/cargarTablaDocumentos";
    $('#tablaDocumentos').DataTable({
        "autoWidth": false,
        "columns": [
                    { "width": "8%" },
                    { "width": "30%" },
                    { "width": "20%" },
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "12%" }
                  ],
        destroy: true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 5,
         "ajax": {
            type: "GET",
            url: enlace,
            data: {id_tipodocumento:idTipoDoc,id_bien: bien, id_clase: clase}
        },
    });
}

function cargarArchivoM( material)
{
    $("#idMaterial").val(material);
    $("#fileImg").val('');
    $('#cargarArchivoModal > .modal-dialog').parent().css('z-index', 2000);
    $('#divCapa').addClass('overlay');
    $('#cargarArchivoModal').show(); 
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


function eliminarFoto(nombre)
{
    
    var enlace = base_url + "Fotografias/Fotografias/eliminarfoto";
    $.ajax({
        url: enlace,
        method: 'POST',
        dataType: 'JSON',
        data: {nombre:nombre },
        success: function (data) 
        {
            alert(data.mensaje);
            if(data.resultado == 1){
               cargarTablaMateriales()
            }    
        }
    });
    return false;
}




function verPDF(nombreArchivo, ruta)
{

    $('#divPDF').html('');
    var iframe = document.createElement("iframe");
        iframe.width = '100%';
        iframe.height = '700px';
        iframe.src = base_url+ruta+ nombreArchivo; //Aqui iría el src de tu archivo .PDF
        $('#divPDF').append(iframe);
    $('#divCapa').addClass('overlay');    
    $('#pdfModal > .modal-dialog ').parent().css('z-index', 2000);
    $('#pdfModal').show();     
}
function eliminarDocumentoEscaneado(idBien, idClase, idRegistro, idTipoDocumento, ruta , nombreArchivo)
{   if(confirm("Seguro de eliminar el documento ?")==true){
        var enlace = base_url + "DocumentoEscaneado/DocumentoEscaneado/eliminarDocumentoEscaneado";
        $.ajax({
            type: "POST",
            url: enlace,
            data: {idbien: idBien , idregistro: idRegistro, idtipodocumento :idTipoDocumento , ruta: ruta, nombrearchivo : nombreArchivo},
            dataType: 'JSON',
            success: function(data) {
                alert(data.mensaje);
                cargarTablaDocumentosEscaneados( idBien , idClase ,idTipoDocumento );
                $("#cargarArchivoModal").hide();
                $("#pdfModal").hide();
                $("#divCapa").removeClass("overlay");
            },
            error: function (e) {
                    //$("#output").text(e.responseText);
                    console.log("ERROR : ", e);
                   //$("#btnSubmit").prop("disabled", false);

            }
        });
    }
}
