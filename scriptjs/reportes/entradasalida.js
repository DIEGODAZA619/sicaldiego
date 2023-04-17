var base_url;
var alertaValidacion = '';
function baseurl(enlace)
{
    base_url = enlace;
}



function generarReporte()
{
    var tipoReporte = $('#tipoReporte').val();
    var inicio = $('#txtfecha_inicio').val();
    var fin    = $('#txtfecha_fin').val();

    if($('#txtfecha_inicio').val() != '' && $('#txtfecha_fin').val() != '')
    {
        if(tipoReporte == 'ING') 
        {
            $('#divtablaIngresos').show();
            $('#divtablaSalidas').hide();
            cargarTablaIngresos();
            cargarVista('INGRESOS');
        }
        else
        {
            $('#divtablaIngresos').hide();
            $('#divtablaSalidas').show();
            cargarTablaSalidas();
            cargarVista('SALIDAS');
        }        
    }
    else
    {
        alert("SELECCIONE POR FAVOR RANGO DE FECHAS VALIDAS");
    }

}

function cargarTablaIngresos()
{
    var inicio = $('#txtfecha_inicio').val();
    var fin    = $('#txtfecha_fin').val();

    /*var enlace = base_url + "Reportes/IngresosSalidas/cargarTablaIngresos";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {fecIni: inicio, fecFin: fin},
        success: function(data)
        {
            alert(data);            
        }
    });*/
    var enlace = base_url + "Reportes/IngresosSalidas/cargarTablaIngresos";
    $('#idTablaResultadosIngresos').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {fecIni: inicio, fecFin: fin},
        },
    });
}

function cargarTablaSalidas()
{
    var inicio = $('#txtfecha_inicio').val();
    var fin    = $('#txtfecha_fin').val();
    var enlace = base_url + "Reportes/IngresosSalidas/cargarTablaSalidas";
    $('#idTablaResultadosSalidas').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "POST",
            url: enlace,
            data: {fecIni: inicio, fecFin: fin},
        },
    });
}


function cargarVista(tipo)
{
    var inicio = $('#txtfecha_inicio').val();
    var fin    = $('#txtfecha_fin').val();
    $('#tipoReporteText').text('TIPO REPORTE: '+tipo+' |      DESDE EL: '+inicio+' AL: '+fin);
}


function generarReporteIngresos()
{
    var inicio = $('#txtfecha_inicio').val();
    var fin    = $('#txtfecha_fin').val();
    window.open(base_url+"Reportes/IngresosSalidas/reporteMaterialIngresos/"+inicio+"/"+fin);
}


function generarReporteSalidas()
{
    var inicio = $('#txtfecha_inicio').val();
    var fin    = $('#txtfecha_fin').val();
    window.open(base_url+"Reportes/IngresosSalidas/reporteMaterialEntregado/"+inicio+"/"+fin);
}