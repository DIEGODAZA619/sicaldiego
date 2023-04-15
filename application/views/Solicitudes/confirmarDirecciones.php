<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/solicitudes/confirmarDirecciones.js"></script>
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

<h1 class="page-title">LISTA DE SOLICITUDES CONFIRMADAS</h1>
<div class="card"  >
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMaterialesConfirmados" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Nro</th>
                        <th>SOLICITANTE</th>
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
<h1 class="page-title">LISTA DE MATERIALES SOLICITADOS POR ÁREA ORGANIZACIONAL PENDIENTES</h1>

<div class="card"  >
    <div class="card-body">
        <div class="col-12" id="botonAprobar" >
            <button type="button" id="btnrango" class="btn btn-success float-right" onclick='confirmarPedidoDireccion()' ><i class="mdi mdi-pencil"></i> CONFIRMAR SOLICITUDES</button>
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
                            <th>OPCIONES</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal " id="solicitudModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Seleccionar la cantidad a Editar</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form id="formularioSolicitudMaterial">
                    <div  class=" col-lg-12 alert alert-danger"  id="validacionIngreso" style="display: none;"></div>
                    <div class="row">
                        <input type="hidden" class="form-control" id="accion" name="accion" required="required">
                        <input type="hidden" class="form-control" id="id_material" name="id_material" required="required">
                        <input type="hidden" class="form-control" id="id_registro" name="id_registro" required="required">
                        <input type="hidden" class="form-control" id="tipo_solicitud" name="tipo_solicitud" required="required">

                        <div class="col-lg-8">
                            <strong><div id="nombre_producto"> </div></strong><br>
                        </div>
                        <div class="col-lg-4">
                            <label>CANTIDAD SOLICITADA</label>
                            <input type="number" class="form-control" id="txtCantidad" name="txtCantidad" required="required">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                <button id="guardarIngreso" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span>Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="motivoSolicitudModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>MOTIVO Y/O JUSTIFICATIVO</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-lg-12">
                            <label><strong>Ingrese la justificación para el pedido del material a solicitar (Máximo 200 caracteres)</strong></label>
                            <input type="text" class="form-control" id="txtMotivo" name="txtMotivo" required minlength="7" maxlength="200">
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                    <button type="button" id="confirmarSolicitud"  class="btn btn-success" onclick="confirmarPedidoDireccionConMotivo()"><span class="glyphicon glyphicon-floppy-disk"></span>Confirmar</button>
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