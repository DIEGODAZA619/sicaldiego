<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/clasificacion/unidades.js"></script>

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

<h1 class="page-title">CONTROL DE UNIDADES</h1>
<div class="card">
    <div class="card-body">
        <div class="col-12">
            <!--div class="col-2 col-lg-2 ml-lg-auto">
                <button type="button" name='btnRegistroMaterial' class="btn btn-success" onclick='adicionarMaterial()'><i class="mdi mdi-check"></i>Adicionar Categoria</button>
            </!--div-->
            <!--hr-->
            <table id="idTablaUnidades" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Nro</th>
                        <th>CODIGO</th>
                        <th>DESCRIPCION</th>
                        <th>ESTADO</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal " id="registroUnidadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Unidad</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUnidad">
                    <div class="col-12 row">
                        <input type="text" class="form-control" id="id_unidad" name="id_unidad" hidden>
                        <div class="col-6 form-group">
                            <label class="form-control-label">Codigo:</label>
                            <input type="text" class="form-control" id="txtcodigo_unidad" name="txtcodigo_unidad">
                            <div id="txtcodigo_unidad_error" style="display: none;"><small><label class="error text-danger">El Codigo es requerido.</label></small></div>
                        </div>
                        <div class="col-6 form-group">
                            <label class="form-control-label">Descripción:</label>
                            <input type="text" class="form-control" id="txtdescripcion_unidad" name="txtdescripcion_unidad">
                            <div id="txtdescripcion_unidad_error" style="display: none;"><small><label class="error text-danger">El Descripcion es requerido.</label></small></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick=guardar()>Guardar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarfunciones();
    });
</script>