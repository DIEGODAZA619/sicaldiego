var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones(tipoSolicitud)
{
    $('#tipo_solicitud').val(tipoSolicitud);
    cargarTablaMateriales();
    
    cargarMaterialesAcumulados();
    habilitarTablasBotones();


}

function habilitarTablasBotones()
{
    $('#guardarIngreso').on('click', function() {
        guardarIngreso();
    });
}

function cargarTablaMateriales()
{
    var enlace = base_url + "Reportes/Reportes/cargartablasMaterialesAlmacen";
    $('#idTablaMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 15, 20, -1], [5, 15, 20, "Todos"]],
        "iDisplayLength": 5,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}

function mostrarKardexMaterial(id_material)
{
    var gestion = $('#gestionKardex').val();    
    descripcionMaterial(id_material);    
    karexMaterialGestion(gestion,id_material);
    /*$('#detalleKardexMaterialModal').modal({backdrop: 'static', keyboard: false})
    $('#detalleKardexMaterialModal').modal('show');*/
}

function karexMaterial(id_material)
{
    var enlace = base_url + "Reportes/Reportes/cargartablasKardexMaterialesAlmacen";
    $('#idTablaKardexMateriales').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 20,
         "ajax": {
            type: "GET",
            url: enlace,
            data: {id_mat: id_material},
        },
    });
}

function karexMaterialGestion(gestion,id_material)
{    
    var enlace = base_url + "Reportes/Reportes/cargartablasKardexMaterialesAlmacenGestion";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {ges: gestion, id_mat: id_material},
        success: function(data)
        {
            //alert(data);
            $('#tablaKardex').html(data);
        }
    });
}

function descripcionMaterial(id_material)
{
    var enlace = base_url + "Ingreso/ingreso/getMaterialesId";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id_mat: id_material},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    $('#nombre_producto').text('Producto seleccionado: '+datos.descripcion);
                    $('#nombre_producto_kardex').text('Producto seleccionado: '+datos.descripcion);
                    
                }
                else
                {
                    swal({title: "ERROR",text: datos.mensaje,icon: "error",button: "Error"});

                   // alert(datos.mensaje);
                }
            });
        }
    });
}



