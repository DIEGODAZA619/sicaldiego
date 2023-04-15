<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/materiales/proveedores.js"></script>

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

<h1 class="page-title">CONTROL DE PROVEEDORES</h1>
<div class="card">
    <div class="card-body">
        <div class="col-12">
            <div class="col-2 col-lg-2 ml-lg-auto">
                <button type="button" name='btnRegistroMaterial' class="btn btn-success" onclick='adicionarProveedor()'><i class="mdi mdi-check"></i>Adicionar Proveedor</button>
            </div>
            <hr>
            <table id="idTablaProveedores" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>CODIGO</th>
                            <th>NOMBRE PROVEEDOR</th>
                            <th>REPRESENTANTE LEGAL</th>
                            <th>NIT</th>
                            <th>CORREO</th>
                            <th>CELULAR</th>
                            <th>DIRECCION</th>
                            <th>Opciones</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal " id="registroProveedorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Registro Proveedor</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formProveedor">
                    <div class="col-12 row">
                        <input type="text" class="form-control" id="texto" name="texto" hidden>
                        <input type="text" class="form-control" id="id_proveedor" name="id_proveedor" hidden>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Codigo:</label>
                            <input type="text" class="form-control" id="txtcodigo_proveedor" name="txtcodigo_proveedor">
                            <div id="txtcodigo_proveedor_error" style="display: none;"><small><label class="error text-danger">El Codigo es requerido.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Nombre Proveedor: *</label>
                            <input type="text" class="form-control" id="txtnombre_proveedor" name="txtnombre_proveedor">
                            <div id="txtnombre_proveedor_error" style="display: none;"><small><label class="error text-danger">El Nombre del Proveedor es requerido.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Representante Legal: * </label>
                            <input type="text" class="form-control" id="txtlegal_proveedor" name="txtlegal_proveedor">
                            <div id="txtlegal_proveedor_error" style="display: none;"><small><label class="error text-danger">El Legal Proveedor es requerido.</label></small></div>
                         </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Nit: *</label>
                            <input type="text" class="form-control" id="nit" name="nit">
                            <div id="nit_error" style="display: none;"><small><label class="error text-danger">El Nit es requerido.</label></small></div>
                      </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Correo:</label>
                            <input type="text" class="form-control" id="correo" name="correo">
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Celular:</label>
                            <input type="text" class="form-control" id="celular" name="celular">
                            <div id="celular_error" style="display: none;"><small><label class="error text-danger">El Celular es requerido.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Dirección: </label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                         </div>
                        <div class="col-8 form-group">
                            <label class="form-control-label">Observaciones:</label>
                            <input type="text" class="form-control" id="observacion" name="observacion">
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
        //cargarCombos();
    });
</script>