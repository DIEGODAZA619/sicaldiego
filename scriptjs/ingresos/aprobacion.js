var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    $('#idIngreso').val('');
    $('#botonAprobar').hide();
    cargarTablaAprobacion();    
}
function cargarTablaAprobacion()
{
    
    var enlace = base_url + "Ingreso/aprobacion/cargarTablaAprobacion";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[5,10, 15, 20, -1], [5,10, 15, 20, "Todos"]],
        "iDisplayLength": 5,
         "ajax": {
            type: "GET",
            url: enlace,            
        },
    });
}

function cargarMaterialesAcumulado(idIngreso,compra)
{     
    $('#idIngreso').val(idIngreso);    
    $('#nroCompra').html(compra); 
    $('#botonAprobar').show();
    var enlace = base_url + "Ingreso/aprobacion/cargartablasMaterialesAcumulados";
    $('#idTablaAcumuladorAp').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "POST",
            url: enlace,  
            data: {id_ing: idIngreso}          
        },
    });
}

function eliminarIngresoDetalles(id_ingreso)
{   
    if(confirm('¿Estas seguro eliminar el registro de material?'))
    {   
        var enlace = base_url + "Ingreso/ingreso/eliminarIngresoDetalles";        
        $.ajax({
            type: "POST",
            url: enlace,
            data: {id_ing: id_ingreso},
            success: function(data) 
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 0)
                    {
                        alert(datos.mensaje);
                    }
                    else
                    {
                        alert("Se realizo el ingreso de material correctamente");
                        limpiarFormularioIngreso();                            
                        cargarMaterialesAcumulados();                        
                    }
                });
            }
        });
    }
    else
    {        
        return false;
    }    
}

function aprobarIngreso()
{
    var id_ingreso = $('#idIngreso').val();    
    if(confirm('¿Estas de confirmar el ingreso de los materiales seleccionados?'))
    {   
        var enlace = base_url + "Ingreso/aprobacion/aprobarIngresoMateriales";        
        $.ajax({
            type: "POST",
            url: enlace,
            data: {id_ing: id_ingreso},
            success: function(data) 
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 0)
                    {
                        alert(datos.mensaje);
                    }
                    else
                    {
                        alert(datos.mensaje);
                        cargarfunciones();  
                        cargarMaterialesAcumulado(0);                     
                    }
                });
            }
        });
    }
    else
    {        
        return false;
    }        
}