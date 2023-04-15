var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones(tipoSolicitud)
{
    $('#tipo_solicitud').val(tipoSolicitud);
    cargarTablaConfirmacionsolicitudes();    
    /*limpiarFormularioIngreso();    
    cargarMaterialesAcumulados(); 
    habilitarTablasBotones();*/
    $('#btnAutorizar').hide();


}

function cargarTablaConfirmacionsolicitudes()
{
    var enlace = base_url + "Solicitudes/Aprobar_solicitud/cargartablaSolicitudesConfirmadas";
    $('#idTablaMaterialesConfirmados').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 3,
         "ajax": {
            type: "POST",
            url: enlace,            
        },
    });
}

function cargarTablasolicitudesIdConfirmacion(idConfirmacion)
{
    
    $('#txtIdSolicitudDireccion').val(idConfirmacion);
    $('#btnAutorizar').show();
    var enlace = base_url + "Solicitudes/Aprobar_solicitud/cargarTablasolicitudesIdConfirmacion";
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


function autorizarPedidoDireccion()
{
    var idConfirmacion = $('#txtIdSolicitudDireccion').val();
    if(idConfirmacion > 0)
    {
        var enlace = base_url + "Solicitudes/Aprobar_solicitud/autorizarPedidoDireccion";    
        $.ajax({
            type: "POST",
            url: enlace,   
            data: {id_conf: idConfirmacion},            
            success: function(data)
            {            
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {                
                    if(datos.resultado == 1)
                    {                      
                        $('#btnAutorizar').hide();
                        swal({title: "OK", text:datos.mensaje, icon: "success", button: "OK"});
                        cargarTablaConfirmacionsolicitudes();
                        cargarTablasolicitudesIdConfirmacion(0);
                    }
                    else
                    { 
                        swal({title: "Error", text:datos.mensaje, icon: "error", button: "Cerrar"});
                    }
                });
            }
        });    
    }
    else
    {
        swal({title: "Error", text:"Debe seleccionar una solicitud", icon: "error", button: "Cerrar"});
    }
    
}









