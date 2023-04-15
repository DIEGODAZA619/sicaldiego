var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}



function generarReporteDetallado()
{
    var gestionKardex = $('#gestionKardex').val();
    var txtfecha_limite = $('#txtfecha_limite').val();
    if($('#txtfecha_limite').val() != '')
    {
        $('#divtablaValorado').show();
        $('#divtablaPartidas').hide();
        cargarTablaValorado();
    }
    else
    {
        alert("SELECCIONE POR FAVOR RANGO UNA FECHA VÁLIDA");
    }
}

function generarReportePartidas()
{
    var gestionKardex = $('#gestionKardex').val();
    var txtfecha_limite = $('#txtfecha_limite').val();
    if($('#txtfecha_limite').val() != '')
    {
        $('#divtablaValorado').hide();
        $('#divtablaPartidas').show();
        cargarTablaPartidas();
    }
    else
    {
        alert("SELECCIONE POR FAVOR RANGO UNA FECHA VÁLIDA");
    }
}

function cargarTablaValorado()
{
    var txtfecha_limite = $('#txtfecha_limite').val();
    var gestionKardex = $('#gestionKardex').val();  
    var enlace = base_url + "Reportes/ReportesMefp/cargarTablaDetallado";
    $('#idTablaResultadosDetallado').DataTable({
        destroy: true,
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
        "iDisplayLength": 20,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {gestion: gestionKardex, fecIni: txtfecha_limite},
        },
    });
}


function cargarTablaPartidas()
{
    var txtfecha_limite = $('#txtfecha_limite').val();
    var gestionKardex = $('#gestionKardex').val();  
    var enlace = base_url + "Reportes/ReportesMefp/cargarTablaPartidas";
    $('#idTablaResultadosPartidas').DataTable({
        destroy: true,
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
        "iDisplayLength": 20,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {gestion: gestionKardex, fecIni: txtfecha_limite},
        },
    });
}




function generarReporteValoradoReporte()
{
    var txtfecha_limite = $('#txtfecha_limite').val();
    var gestionKardex = $('#gestionKardex').val(); 
    window.open(base_url+"Reportes/ReportesMefp/reporteInventarioValorado/"+gestionKardex+"/"+txtfecha_limite);
}





function generarReportePartidasReporte()
{
    var txtfecha_limite = $('#txtfecha_limite').val();
    var gestionKardex = $('#gestionKardex').val(); 
    window.open(base_url+"Reportes/ReportesMefp/reporteInventarioPartidas/"+gestionKardex+"/"+txtfecha_limite);
}


//FUNCIONES