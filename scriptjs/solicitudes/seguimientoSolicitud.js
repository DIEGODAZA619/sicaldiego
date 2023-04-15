var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones(tipoSolicitud)
{
    $('#tipo_solicitud').val(tipoSolicitud);    
    cargaEstadoSolicitud();
    activarCombos();
    /*limpiarFormularioIngreso();    
    cargarMaterialesAcumulados(); 
    habilitarTablasBotones();*/
    $('#btnAutorizar').hide();


}

function activarCombos()
{
    $('#estadoSolicitud').change(function () 
    {
        cargarTablaConfirmacionsolicitudes();
        cargarTablasolicitudesIdConfirmacion(0);
    });
}
function cargaEstadoSolicitud()
{    
    var enlace = base_url + "Solicitudes/Seguimiento_solicitud/getEstadoSolicitud";
    $.ajax({ //
        url: enlace,
        method: 'POST',
        success: function (data) {
            $('#estadoSolicitud').html(data);            
        }
    });
}
function cargarTablaConfirmacionsolicitudes()
{
    var estado = $('#estadoSolicitud').val();
    var enlace = base_url + "Solicitudes/Seguimiento_solicitud/cargartablaSolicitudesConfirmadas";
    $('#idTablaMaterialesConfirmados').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 3,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {est: estado},           
        },
    });
}

function cargarTablasolicitudesIdConfirmacion(idConfirmacion)
{
    
    $('#txtIdSolicitudDireccion').val(idConfirmacion);
    $('#btnAutorizar').show();
    var enlace = base_url + "Solicitudes/Seguimiento_solicitud/cargarTablasolicitudesIdConfirmacion";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[15, 20, 50, -1], [15, 20, 50, "Todos"]],
        "iDisplayLength": 15,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {id_conf: idConfirmacion},           
        },
    });
}