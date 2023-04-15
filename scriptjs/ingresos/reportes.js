var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}
function cargarfunciones()
{
    $('#tablaIngresos').show();
    $('#cargarIngresos').hide();
    cargarTablaIngresos();
}


function cargarTablaIngresos()
{

    var enlace = base_url + "Ingreso/reportes/cargarTablaIngresos";
    $('#idTablaIngreso').DataTable({
        destroy: true,
        "aLengthMenu": [[3,5,10, 15, 20, -1], [3,5,10, 15, 20, "Todos"]],
        "iDisplayLength": 3,
         "ajax": {
            type: "GET",
            url: enlace,
        },
    });
}

function listarMateriales(id_ingreso,e)
{
    $('#txtIdIngreso').val(id_ingreso);
    cargarMaterialesAcumulados();
    $("#orden_compra").html($(e).parents("tr").find("td:nth-child(2)").html());
   // $('#tablaIngresos').hide();
    $('#cargarIngresos').show();
}

function cargarMaterialesAcumulados()
{
var idIngreso = $('#txtIdIngreso').val();
   var enlace = base_url + "Ingreso/reportes/cargartablasMaterialesAcumulados";
    $('#idTablaAcumulador').DataTable({
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

// reportes 
function reporteMaterialIngresado(fil)
{
    window.open(base_url+"Ingreso/reportes/reporteMaterialEntregado/"+fil);
}

