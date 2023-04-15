var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function cargarTablaDireccion()
{
    var enlace = base_url + "Vacaciones/confirmacion/cargarTablaDireccion";
    $('#idConfirmacionDireccion').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function cargarTablaUnidad()
{
    var enlace = base_url + "Vacaciones/confirmacion/cargarTablaUnidad";
    $('#idVerificacionUnidad').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function cargarTablaRRHH()
{
    var enlace = base_url + "Vacaciones/confirmacion/cargarTablaRRHH";
    $('#idConsolidarVacacion').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function cargarTablaDirectores()
{
    var enlace = base_url + "Vacaciones/confirmacion/cargarTablaDirectores";
    $('#idConfirmacionDirectores').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function confirmarRegistro(idregistro)
{    
    $('#txtidregistro').val(idregistro);
    $('#habilitarConfirmacionDireccion').modal({backdrop: 'static', keyboard: false})
    $('#habilitarConfirmacionDireccion').modal('show');

}
function editarRegistroConfirmacionRrhh()
{
    
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistroConfirmarRrhh";
    var datos = $('#formregistroconfirmacion').serialize();

    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionDireccion').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaRRHH();
}
function editarRegistroConfirmacion()
{
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistroConfirmar";
    var datos = $('#formregistroconfirmacion').serialize();
    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionDireccion').modal('hide');
                    cargarTablaDirectores();
                    cargarTablaDireccion();
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
}
function editarRegistroVerificacion()
{
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistroVerificar";
    var datos = $('#formregistroverificacion').serialize();
    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionDireccion').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaUnidad();
}

function rechazarRegistroConfirmacionRrhh(idregistro)
{
    var enlace = base_url + "Vacaciones/confirmacion/rechazarRegistroVerificar";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionDireccion').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaRRHH();
}
function rechazarRegistroVerificacion(idregistro)
{
    var enlace = base_url + "Vacaciones/confirmacion/rechazarRegistroVerificar";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionDireccion').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaUnidad();
}
function rechazarRegistroDireccion(idregistro)
{
    var enlace = base_url + "Vacaciones/confirmacion/rechazarRegistroVerificar";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionDireccion').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaDireccion();
}
function rechazarRegistroDirectores(idregistro)
{
    if(confirm('¿Estas seguro de rechazar el registro de vacación?'))
    {
        var enlace = base_url + "Vacaciones/confirmacion/rechazarRegistroVerificar";
        $.ajax({
            type: "POST",
            url: enlace,
            data: {id:idregistro},
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
                    if(datos.resultado == 1)
                    {
                        alert(datos.mensaje);
                        $('#habilitarConfirmacionDirectores').modal('hide');
                    }
                    else
                    {
                        alert(datos.mensaje);
                    }
                });
            }
        });
        cargarTablaDirectores();
    }
    else
    {
      return false;
    }
}
function aprobarRegistros()
{
    $('#habilitarConfirmacionRegistros').modal({backdrop: 'static', keyboard: false})
    $('#habilitarConfirmacionRegistros').modal('show');
}
function aprobarRegistrosUnidad()
{
    $('#habilitarConfirmacionRegistrosUnidad').modal({backdrop: 'static', keyboard: false})
    $('#habilitarConfirmacionRegistrosUnidad').modal('show');
}
function aprobarRegistrosDirectores()
{
    $('#habilitarRegistrosDirectores').modal({backdrop: 'static', keyboard: false})
    $('#habilitarRegistrosDirectores').modal('show');
}
function aprobarRegistrosRrhh()
{
    $('#habilitarConfirmacionRegistrosRrhh').modal({backdrop: 'static', keyboard: false})
    $('#habilitarConfirmacionRegistrosRrhh').modal('show');
}
function guardarRegistrosConfirmadosRrhh()
{
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistrosMasivosRrhh";
    var datos = $('#idConsolidarVacacion').serialize();
    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionRegistrosRrhh').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaRRHH();
}
function guardarRegistrosConfirmados()
{
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistrosMasivosDireccion";
    var datos = $('#idConfirmacionDireccion').serialize();
    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionRegistros').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaDireccion();
}
function guardarRegistrosDirectores()
{
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistrosMasivosDirectores";
    var datos = $('#idConfirmacionDirectores').serialize();
    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarRegistrosDirectores').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaDirectores();
}
function guardarRegistrosConfirmadosUnidad()
{
    var enlace = base_url + "Vacaciones/confirmacion/editarRegistrosMasivosUnidad";
    var datos = $('#idVerificacionUnidad').serialize();
    $.ajax({
        type: "POST",
        url: enlace,
        data: datos,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos)
            {
                if(datos.resultado == 1)
                {
                    alert(datos.mensaje);
                    $('#habilitarConfirmacionRegistrosUnidad').modal('hide');
                }
                else
                {
                    alert(datos.mensaje);
                }
            });
        }
    });
    cargarTablaUnidad();
}

