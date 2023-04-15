var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function cargartabla()
{
    var enlace = base_url + "Vacaciones/liquidacion/cargartablas";
    $('#order-listing').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}

function realizarliquidacion()
{
    var enlace = base_url + "Vacaciones/liquidacion/liquidar";    
    $.ajax({
        type: "POST",
        url: enlace,        
        success: function(data)
        {            
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                //alert(datos.mensaje);
                if(datos.resultado == 0)
                {
                    $("#alertaLiquidacion").removeClass("alert-dark");
                    $("#alertaLiquidacion").removeClass("alert-success");
                    $("#alertaLiquidacion").addClass("alert-danger");
                    //$("#alertaLiquidacion").css("color", "alert-danger");
                } else if (datos.resultado == 1) {
                    $("#alertaLiquidacion").removeClass("alert-danger");
                    $("#alertaLiquidacion").removeClass("alert-dark");
                    $("#alertaLiquidacion").addClass("alert-success");
                    //$("#alertaLiquidacion").css("color", "alert-success");
                } else {
                    $("#alertaLiquidacion").removeClass("alert-danger");
                    $("#alertaLiquidacion").removeClass("alert-success");
                    $("#alertaLiquidacion").addClass("alert-dark");
                    //$("#alertaLiquidacion").css("color", "alert alert-info");
                }
                $('#alertaLiquidacion').html(datos.mensaje);
                cargartabla();
            });
        }
    });
    cargartabla();
}

function reliquidacion()
{
    var enlace = base_url + "Vacaciones/liquidacion/reliquidar";    
    $.ajax({
        type: "POST",
        url: enlace,        
        success: function(data)
        {            
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                alert(datos.mensaje);
                /*if(datos.resultado == 1)
                {
                    alert(datos.mensaje);                    
                }
                else
                {
                    alert(datos.mensaje);
                }*/
            });
        }
    });
    cargartabla();
}

