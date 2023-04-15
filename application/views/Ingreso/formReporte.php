<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/ingresos/reportes.js"></script>
<style>

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 16px;
    line-height: 1.22857; margin-left: 3px;
}
</style>

<h1 class="page-title">INGRESO DE MATERIALES APROBADOS</h1>
<div class="card" id="tablaIngresos" style="display:none">
    
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaIngreso" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>ORDEN DE COMPRA</th>
                            <th>NOTA_REMISION</th>
                            <th>NRO_FACTURA</th>
                            <th>FECHA_FACTURA</th>
                            
                            <th>PROVEEDOR</th>
                            <th>DESCRIPCION</th>
                            <th>FECHA INGRESO</th>
                           <!-- <th>ESTADO</th>-->
                            <th>OPCIONES</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="txtIdIngreso" id="txtIdIngreso">
<h1 class="page-title">MATERIALES SELECCIONADOS A DETALLE DE LA ORDEN DE COMPRA <span id="orden_compra" style="color:#000" class="fondoClaroNaranja"></span></h1>
    <div class="card">
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaAcumulador" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>CODIGO</th>
                            <th>MATERIAL</th>
                            <th>CANTIDAD INGRESO</th>
                            <th>PRECIO UNITARIO</th>
                            <th>PRECIO TOTAL</th>
                            <th>FECHA REGISTRO</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    </div>

<!--
<div class="modal " id="formularioIngresoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Formulario de Ingreso</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form id="formularioIngresoMaterial">
                    <div  class=" col-lg-12 alert alert-danger"  id="validacionIngreso" style="display: none;"></div>

                    <div class="row">
                        <input type="hidden" class="form-control" id="accion" name="accion" required="required">
                        <input type="hidden" class="form-control" id="id_ingreso" name="id_ingreso" required="required">
                        <input type="hidden" class="form-control" id="id_material" name="id_material" required="required">
                        <input type="hidden" class="form-control" id="id_registro" name="id_registro" required="required">

                        <div class="col-lg-6">
                            <strong><div id="nombre_producto"> </div></strong><br>
                        </div>
                        <div class="col-lg-3">
                        <label>CANTIDAD DE INGRESO</label>
                            <input type="number" class="form-control" id="txtCantidad" name="txtCantidad" required="required">
                        </div>
                        <div class="col-lg-3">
                            <label>PRECIO UNITARIO</label>
                            <input type="number" class="form-control" id="txtPrecio" name="txtPrecio" required="required">
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
-->
<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarfunciones();
    });
</script>