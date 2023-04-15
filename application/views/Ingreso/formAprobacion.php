<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/ingresos/aprobacion.js"></script>
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
<h1 class="page-title">APROBAR INGRESO DE MATERIALES</h1>
<div class="card">
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
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
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<h1 class="page-title">MATERIALES SELECCIONADOS</h1>
<div class="card">
    <div class="card-body">
        <input type="hidden" name="idIngreso" id="idIngreso">
        <div class="col-12" id="botonAprobar" style="display:none">
            <div class="float-left fondoClaroNaranja">ORDEN DE COMPRA : <span id="nroCompra" style="font-weight: bolder;"></span></div>
            <button type="button" id="btnrango" class="btn btn-success float-right" onclick='aprobarIngreso()' ><i class="mdi mdi-pencil"></i> Aprobar Ingreso</button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">

            <table id="idTablaAcumuladorAp" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>PARTIDA</th>
                            <th>CODIGO</th>
                            <th>MATERIAL</th>
                            <th>CANTIDAD INGRESO</th>
                            <th>PRECIO UNITARIO</th>
                            <th>PRECIO TOTAL</th>
                            <th>FECHA REGISTRO</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
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
        cargarfunciones();
    });
</script>