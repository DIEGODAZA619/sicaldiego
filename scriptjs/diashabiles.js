var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function cargartabla()
{
    var enlace = base_url + "dias_habiles/cargartablas";
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

function abrirDialogDiasHabiles()
{
    $('#txtaccion').val('nuevo');
    $('#txtidregistro').val('');
    $('#txtgestion').val('');
    $('#txtfecha_dia').val('');
    $('#txttipo_dias').val('');
    $('#txtdescripcion').val('');
    $('#txtalcance').val('');
    $('#txtdepartamento').val('');
    $('#txtrespaldo').val('');

    $('#diasHabilessModal').modal({backdrop: 'static', keyboard: false})
    $('#diasHabilessModal').modal('show');

}
function GuardarRegistro()
{
    if(validarFormulario())
    {
        var enlace = base_url + "dias_habiles/guardardianohabil";
        var datos = $('#formregistrodianohabil').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                    if(datos.resultado == 1)
                    {
                        alert(datos.mensaje);
                        $('#diasHabilessModal').modal('hide');
                    }
                    else
                    {
                        alert(datos.mensaje);
                    }
                });
            }
        });
        cargartabla();
    }
    else
    {
        $('#validacionformulario').text("Verificar: "+alertaValidacion);
        $('#validacionformulario').show();
        alertaValidacion="";
    }
}
function validarFormulario()
{
    var todook = true;
    alertaValidacion = 'error';
    return todook;
}
function editarDiaHabil(idregistro)
{
    $('#txtaccion').val('editar');
    $('#txtidregistro').val(idregistro);
    var enlace = base_url + "dias_habiles/idregistrodiahabil";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                 $('#txtgestion option[value="'+datos.gestion+'"]').prop('selected','selected');
                 $('#txtfecha_dia').val(datos.fecha_dia);
                 $('#txttipo_dias option[value="'+datos.tipo_dias+'"]').prop('selected','selected');
                 $('#txtdescripcion').val(datos.descripcion);                 
                 $('#txtalcance  option[value="'+datos.alcance+'"]').prop('selected','selected');
                 $('#txtdepartamento  option[value="'+datos.departamento+'"]').prop('selected','selected');
                 $('#txtrespaldo').val(datos.respaldo);
            });
            $('#diasHabilessModal').modal({backdrop: 'static', keyboard: false})
            $('#diasHabilessModal').modal('show');
        }
    });
}
