<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/solicitudes/aprobarSolicitud.js"></script>
<style>

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}
</style>
<h1 class="page-title">LISTA DE SOLICITUDES PENDIENTES DE APROBACIÓN</h1>
<div class="card"  >
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMaterialesConfirmados" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>SOLICITANTE DIRECCION</th>
                            <th>CORRELATIVO CITE</th>
                            <th>CANTIDAD PETICIONES</th>
                            <th>CANTIDAD MATERIALES</th>
                            <th>FECHA</th>
                            <th>MOTIVO</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<h1 class="page-title">LISTA DE MATERIALES SOLICITADOS POR DIRECCIÓN PENDIENTES DE APROBACIÓN</h1>
<div class="card"  >
    <div class="card-body">
        <div class="col-12" id="botonAprobar" >
            <input type="hidden" name="txtIdSolicitudDireccion" id="txtIdSolicitudDireccion">
            <button type="button" id="btnAutorizar" class="btn btn-success float-right" onclick='autorizarPedidoDireccion()' ><i class="mdi mdi-pencil"></i> APROBAR SOLICITUD</button>
        </div>
    </div>

    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>SOLICITANTE</th>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>UNIDAD</th>
                            <th>PARTIDA</th>
                            <th>CANTIDAD SOLICITADA</th>
                            <th>ESTADO</th>
                            
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarfunciones('<?php echo  $tipo_solicitud;?>');

    });
</script>