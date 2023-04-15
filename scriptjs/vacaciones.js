var base_url;
var alertaValidacion = '';
var fecha_inicio_rango;
var fecha_fin_rango;
function baseurl(enlace)
{
    base_url = enlace;
}
$('#validacionformulario').hide();

function cargarfunciones()
{
    getRangoFechasValidacion();
    getRangoFechasValidacionIndividual();
    recuperardiasvacacion();
    calculardias();
    VacacionCabecera();
    cargarTablaGestionVacacion();

    var fecha_inicio_rango=$('#txtfecha_inicio_rango').datepicker({
        autoclose:true,
        daysOfWeekDisabled: [0, 6],
        format: "yyyy-mm-dd",
        //orientation: "back left",
        language: "es",
        //todayHighlight: true,
        //startDate: new Date($("#anioclock").val(), parseInt($("#mesclock").val()) - 1, parseInt($("#diaclock").val())),
        startDate: '2022-01-02',
        //endDate: new Date($("#anioclock").val(), parseInt($("#mesclock").val()) - 1, parseInt($("#diaclock").val()) + 5)
        endDate: '2022-12-31',
    });
    var fecha_fin_rango=$('#txtfecha_fin_rango').datepicker({
        autoclose:true,
        daysOfWeekDisabled: [0, 6],
        format: "yyyy-mm-dd",
        //orientation: "back left",
        language: "es",
        //todayHighlight: true,
        //startDate: new Date($("#anioclock").val(), parseInt($("#mesclock").val()) - 1, parseInt($("#diaclock").val())),
        startDate: '2022-01-02',
        //endDate: new Date($("#anioclock").val(), parseInt($("#mesclock").val()) - 1, parseInt($("#diaclock").val()) + 5)
        endDate: '2022-12-31',
    });
}

function iniciarDatepicker(){
    $('#txtfecha_inicio_rango').datepicker().on('changeDate', function(ev) {
        $('#txtfecha_fin_rango').datepicker('setStartDate', $('#txtfecha_inicio_rango').val());         
    });
}



function cargarTablaVaciones()
{
    var enlace = base_url + "Vacaciones/vacaciones/cargartablas2";
    $('#idRegistroVacaciones').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function cargartabla()
{
    var enlace = base_url + "Vacaciones/vacaciones/cargartablas";
    $('#idRegistroVacaciones').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
         "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function cargarTablaGestionVacacion()
{
    var enlace = base_url + "Vacaciones/vacaciones/getVacacionCabecera";
    $('#idVacaciones').DataTable({
        "bPaginate": false,
        paging: false,
        searching: false,
        "processing": false,
        destroy: true,
         "ajax": {
            type: "GET",
            url: enlace
        },
    });
}
function cargarTablaUsoVacaciones()
{
    var gestion = $("#txtgestion").val();
    var enlace = base_url + "Vacaciones/vacaciones/cargarTablaUsoVacaciones";
    $('#idUsoVacaciones').DataTable({
        destroy: true,
        "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
        "iDisplayLength": 20,
         "ajax": {
            type: "GET",
            url: enlace,
            data: {gestion: gestion}
        },
    });
}

function cargarTablaVacacionesProgramadas()
{
    var enlace = base_url + "Vacaciones/vacaciones/getListarVacaciones";
    $('#programacionVacaciones').DataTable({
        destroy: true,
        paging: false,
        searching: false,
        info: false,
        "processing": false,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });

}

function abrirDialogRegistrarVacaciones()
{
  $('#txtaccion').val('nuevo');
  $('#txtidregistro').val('');
  $('#habilitarVacacionesModal').modal({backdrop: 'static', keyboard: false})
  $('#habilitarVacacionesModal').modal('show');
}

function GuardarRegistro()
{
    if(validarFormulario())
    {
        var enlace = base_url + "Vacaciones/vacaciones/guardarregistrovacacion";
        var datos = $('#formregistrohabilitacionvaciones').serialize();
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
                        $('#habilitarVacacionesModal').modal('hide');
                    }
                    else
                    {
                        alert(datos.mensaje);
                    }
                });
            }
        });
        cargarTablaVaciones();
    }
    else
    {
        $('#validacionformulario').text("Verificar: "+alertaValidacion);
        $('#validacionformulario').show();
        alertaValidacion="";
    }
}

function editarHabiVacacion(idregistro)
{
    $('#txtaccion').val('editar');
    $('#txtidregistro').val(idregistro);
    var enlace = base_url + "Vacaciones/vacaciones/idregistroconfigutacion";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {id:idregistro},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                 $('#txtdescripcion').val(datos.descripcion);
                 $('#txtgestion option[value="'+datos.gestion+'"]').prop('selected','selected');
                 $('#txtfecha_inicio').val(datos.valor1);
                 $('#txtfecha_fin').val(datos.valor2);
                 $('#txtfecha_inicio_programacion').val(datos.valor3);
                 $('#txtfecha_fin_programacion').val(datos.valor4);
                 $('#txtrespaldo').val(datos.respaldo);
                 $('#txtporcentaje_programacion option[value="'+datos.valor6+'"]').prop('selected','selected');
                 $('#txtprogramacion_individual option[value="'+datos.valor7+'"]').prop('selected','selected');
            });
            $('#habilitarVacacionesModal').modal({backdrop: 'static', keyboard: false})
            $('#habilitarVacacionesModal').modal('show');
        }
    });
}
function validarFormulario()
{
    var todook = true;
    alertaValidacion = 'error';
    return todook;
}
function abrirDialogDiasProgramados()
{
    $('#habilitarDiasProgramadoModal').modal({backdrop: 'static', keyboard: false})
    $('#habilitarDiasProgramadoModal').modal('show');
}
function abrirDialogRangoProgramado()
{
    $('#habilitarProgramacionRangoModal').modal({backdrop: 'static', keyboard: false})
    $('#habilitarProgramacionRangoModal').modal('show');
}
function abrirDialogIndividualProgramado()
{
    $('#habilitarProgramacionIndividualModal').modal({backdrop: 'static', keyboard: false})
    $('#habilitarProgramacionIndividualModal').modal('show');
}
function getRangoFechasValidacion()
{
    var enlace = base_url + "Vacaciones/vacaciones/getFechasLimites";
    $.ajax({
        type: "POST",
        url: enlace,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i,datos)
            {
                if(datos.resultado==1)
                {
                    $('#idalerta').hide();
                    $("#btnconfirmar").css("visibility", "visible");
                    $("#btnrango").css("visibility", "visible");
                }
                else
                {
                    $("#btnconfirmar").css("visibility", "hidden");
                    $("#btnrango").css("visibility", "hidden");
                }
           });
        }
    });
}
function getRangoFechasValidacionIndividual()
{
    var enlace = base_url + "Vacaciones/vacaciones/getFechasLimitesIndividual";
    $.ajax({
        type: "POST",
        url: enlace,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i,datos)
            {
                if(datos.resultado=='0')
                {
                    $('#btnindividual').hide();
                }
            });
        }
    });
}
/*RANGO DE FECHAS DIAS*/
function recuperardiasvacacion()
{
    var enlace = base_url + "Vacaciones/vacaciones/getdiasvacacion";
    $.ajax({
        type: "POST",
        url: enlace,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i,datos)
            {
                if(datos.resultado==1)
                {
                    $('#idalerta').hide();
                    $('#saldopasado').text(datos.saldopasado);
                    $('#diasgestion').text(datos.diasgestion);
                    $('#diastotal').text(datos.diastotal);
                    $('#diasmaxprogramar').text(datos.diasmaxprogramar);
                    $('#diasminprogramar').text(datos.diasminprogramar);
                    $('#diasprogramados').text(datos.diasprogramados);
                    $('#diasporprogramar').text(datos.diasporprogramar);

                    $('#txtsaldopasado').val(datos.saldopasado);
                    $('#txtdiasgestion').val(datos.diasgestion);
                    $('#txtdiastotal').val(datos.diastotal);
                    $('#txtdiasmaxprogramar').val(datos.diasmaxprogramar);
                    $('#txtdiasminprogramar').val(datos.diasminprogramar);
                    $('#txtdiasprogramados').val(datos.diasprogramados);
                    $('#txtdiasporprogramar').val(datos.diasporprogramar);

                    $('#diasprogramados2').text(datos.diasprogramados);
                    $('#diasporprogramar2').text(datos.diasporprogramar);
                    $('#txtdiasprogramadosprevio').val(datos.diasporprogramar);
                }
                else
                {
                    $('#idalerta').show();
                    $('#idalerta').text(datos.mensaje);
                }

            });
        }
    });
}
function VacacionCabecera()
{
    var enlace = base_url + "Vacaciones/vacaciones/getVacacionCabecera";
    $.ajax({
        type: "POST",
        url: enlace,
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i,datos)
            {
                $('#idvacacion').text(datos.id_vacacion);
            });
        }
    });
}
function calculardias()
{
    $('#txtfecha_inicio_rango').change(function ()
    {
        var fechaini = $('#txtfecha_inicio_rango').val();
        var tipoini = 'inicio';
        validarfechas(fechaini,tipoini);
        //$('#txtfecha_fin_rango').val(fechaini);
        //alert(fecha);
    });
    $('#txtfecha_fin_rango').change(function ()
    {
       var fechafin = $('#txtfecha_fin_rango').val();
       var tipofin = 'fin';
       validarfechas(fechafin,tipofin);
    });
}

function validarfechas(fechadato,tipofecha)
{
    var enlace = base_url + "Vacaciones/vacaciones/validarfecha";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {fecha:fechadato, tipo:tipofecha},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                if(datos.resultado == 0)
                {
                    $('#diasseleccionados').text(0);
                    $('#txtdiasseleccionados').val(0);
                    $('#txtacumulado').val('');
                    $('#idvalidacion').show();
                    $('#idvalidacion').text(datos.mensaje);
                }
                else
                {
                    verificarfechas();
                }
            });
        }
    });
}
function verificarfechas()
{
    var fechaini = $('#txtfecha_inicio_rango').val();
    var fechafin = $('#txtfecha_fin_rango').val();
    if(fechaini <= fechafin)
    {
        cantidad_dias(fechaini,fechafin);
    }
    else
    {
        $('#diasseleccionados').text(0);
        $('#txtdiasseleccionados').val(0);
        $('#txtacumulado').val('');
        $('#idvalidacion').show();
        $('#idvalidacion').text("LA fecha FIN debe ser mayor o igual a la fecha INICIO");
    }
}
function cantidad_dias(fechaini,fechafin)
{
    var diasprogramados = $('#txtdiasprogramadosprevio').val();
    var enlace = base_url + "Vacaciones/vacaciones/cantidad_dias";
    $.ajax({
        type: "POST",
        url: enlace,
        data: {fecha1:fechaini, fecha2:fechafin, dias:diasprogramados},
        success: function(data)
        {
            var result = JSON.parse(data);
            $.each(result, function(i, datos){
                if(datos.resultado == 0)
                {
                    $('#idvalidacion').show();
                    $('#idvalidacion').text(datos.mensaje);
                    $('#diasseleccionados').text(0);
                    $('#txtdiasseleccionados').val(0);
                    $('#txtacumulado').val('');
                    $('#btnGuardar').hide();
                }
                else
                {
                    $('#idvalidacion').hide();
                    $('#btnGuardar').show();
                    $('#diasseleccionados').text(datos.dias);
                    $('#txtdiasseleccionados').val(datos.dias);
                    $('#txtacumulado').val(datos.acumulador);
                    $('#txtdiassaldos').val(datos.diassaldo);
                }
            });
        }
    });
}
function guardardias()
{
    var dias = $('#txtdiasseleccionados').val();
    if (dias > 0)
    {
        var enlace = base_url + "Vacaciones/vacaciones/guardardias";
        var datos = $('#formdiasvacacion').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                    if(datos.resultado == 0)
                    {
                        $('#idvalidacion').show();
                        $('#idvalidacion').text(datos.mensaje);
                    }
                    else
                    {
                        $('#idvalidacion').hide();
                        $('#diasseleccionados').text(0);
                        $('#txtdiasseleccionados').val(0);
                        $('#txtacumulado').val('');
                        $('#habilitarProgramacionRangoModal').modal('hide');
                        recuperardiasvacacion();
                        cargartabla();
                    }
                });
            }
        });
    }
    else
    {
        $('#idvalidacion').show();
        $('#idvalidacion').text('Debe seleccionar días de vacación válidos.');
    }
}

function eliminarVacacion(id_dia)
{
    var enlace = base_url + "Vacaciones/vacaciones/eliminardiavacacion";
        $.ajax({
            type: "POST",
            url: enlace,
            data: {id:id_dia},
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                    if(datos.resultado == 0)
                    {
                        alert(datos.mensaje);
                    }
                    else
                    {
                        recuperardiasvacacion();
                        cargartabla();
                    }
                });
            }
        });
}

function confirmardias()
{
    if(confirm('¿Estas seguro de confirmar el registro de sus vacaciones?'))
    {
        var enlace = base_url + "Vacaciones/vacaciones/confirmarprogramacion";
        var datos = $('#datosprogramacion').serialize();
        $.ajax({
            type: "POST",
            url: enlace,
            data: datos,
            success: function(data)
            {
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                    if(datos.resultado == 0)
                    {
                        alert(datos.mensaje);
                        $("#btnconfirmar").css("visibility", "visible");
                        $("#btnrango").css("visibility", "visible");
                    }
                    else
                    {
                        alert(datos.mensaje);
                        $('#idvalidacion').hide();
                        $('#diasseleccionados').text(0);
                        $('#txtdiasseleccionados').val(0);
                        $('#txtacumulado').val('');
                        $('#habilitarProgramacionRangoModal').modal('hide');
                        $("#btnconfirmar").css("visibility", "hidden");
                        $("#btnrango").css("visibility", "hidden");
                        recuperardiasvacacion();
                        cargartabla();
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
