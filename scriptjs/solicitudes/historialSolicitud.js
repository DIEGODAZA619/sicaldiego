var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones(tipoSolicitud)
{
    $('#tipo_solicitud').val(tipoSolicitud);
    cargarTablaSolicitudesIndividual();
}

function cargarTablaSolicitudesIndividual()
{
    var enlace = base_url + "Solicitudes/Historial/cargartablasSolicitudesMaterialesAlmacen";
    $('#idTablaMaterialesSolicitudes').DataTable({
        destroy: true,
        "aLengthMenu": [[20, 30, 50, -1], [20, 30, 50, "Todos"]],
        "iDisplayLength": 20,
         "ajax": {
            type: "POST",
            url: enlace,            
        },
    });
}