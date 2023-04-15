<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/solicitudes/historialSolicitud.js"></script>
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

<h1 class="page-title">LISTA DE MATERIALES SOLICITADOS INDIVIDUALMENTE</h1>
<div class="card"  >    

    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMaterialesSolicitudes" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>SOLICITANTE</th>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>UNIDAD</th>
                            <th>PARTIDA</th>
                            <th>CANTIDAD SOLICITADA</th>
                            <th>CANTIDAD AUTORIZADA</th>
                            <th>FECHA SOLICITUD</th>
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