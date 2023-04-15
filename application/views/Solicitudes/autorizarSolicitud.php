<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/solicitudes/autorizarSolicitud.js"></script>
<style>
.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 16px;
    line-height: 1.22857;
    margin-left: 3px;
}
</style>
<h1 class="page-title">LISTA DE SOLICITUDES APROBADAS</h1>

<div class="card">
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMaterialesConfirmados" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>SOLICITANTE DIRECCION</th>
                            <th>CORRELATIVO CITE</th>
                            <th>CANTADAD PETICIONES</th>
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
<h1 class="page-title">LISTA DE MATERIALES SOLICITADOS POR DIRECCIÓN PENDIENTES DE AUTORIZACIÓN</h1>
<div class="card">
    <div class="card-body">
        <div class="col-2" id="botonAprobar" >
            <input type="hidden" name="txtIdSolicitudDireccion" id="txtIdSolicitudDireccion">
            <button type="button" id="btnAutorizar" class="btn btn-secondary float-right" onclick='autorizarPedidoDireccion()' ><i class="mdi mdi-pencil"></i> AUTORIZAR SOLICITUD</button>
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
                            <th>CANTIDAD AUTORIZADA</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal " id="editarCantidadSolicitada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1200px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" ><b>EDITAR CANTIDAD DE MATERIAL SOLICITADO</b></h3>
            </div>
            <strong><div id="nombre_producto" name="nombre_producto" class=" col-12 alert alert-warning" role="alert" >
            </div></strong>

            <div class="modal-body">
                <form id="formularioSolicitud">
                    <input type="hidden" name="txtidRegistroSolicitud" id="txtidRegistroSolicitud">
                    <input type="hidden" name="id_material" id="id_material">
                    <div class="col-12 row">
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                                <label for="recipient-name" class="form-control-label">Cantidad Solicitada:</label>
                        </div>
                        <div class="col-lg-4 grid-margin grid-margin-lg-0">
                             <div class="input-group">
                                <input class="form-control" type="text" name="txtCantidad" id="txtCantidad" readonly >
                            </div>
                        </div>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label">Cantidad Autorizada:</label>
                        </div>

                        <div class="col-lg-4 grid-margin grid-margin-lg-0">
                            <div class="input-group">
                                <input class="form-control" type="number" name="txtCantidadAutorizada" id="txtCantidadAutorizada" >
                            </div>
                        </div>

                    </div>
                </form>
                <br><br>
                <div id="idvalidacion" name="idvalidacion" class=" col-12 alert alert-danger" role="alert" style="display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id = "btnGuardar" class="btn btn-success" onclick='editarCantidadAutorizadaSolicitud()'>Editar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal " id="historialMaterialSolicitado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1600px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" ><b>HISTORIAL DE MATERIAL SOLICITADO</b></h3>
            </div>
            
            <div class="modal-body">
                <div class="col-12">
                    <table id="idTablaMaterialesHistoricoSolicitudes" class="table table-striped table-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-dark text-white">
                                    <th>Nro</th>
                                    <th>SOLICITANTE</th>
                                    <th>CODIGO</th>
                                    <th>DESCRIPCION</th>
                                    <th>UNIDAD</th>
                                    <th>PARTIDA</th>                                    
                                    <th>CANTIDAD ENTREGADA</th>
                                    <th>FECHA ENTREGA</th>
                                    <th>ESTADO</th>                            
                                </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>                
            </div>
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