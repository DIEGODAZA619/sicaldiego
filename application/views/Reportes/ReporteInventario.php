<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/reportes/inventario.js"></script>
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

<h1 class="page-title">LISTA DE MATERIALES DISPONIBLES EN ALMACEN--</h1>
<div class="card">
    <div class="card-body">
        <div class="container-fluid">            
            <div class="row">                    
                <div class="col-1 form-group" align="right">
                    <label>Gestión: </label>
                </div>
                <div class="col-2 form-group">
                    <select name="gestionKardex" id="gestionKardex" class="form-control">
                        <option value="2023">2023</option>
                    </select>
                </div>
            </div>                            
            <hr>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Nro</th>
                        <th>CODIGO</th>
                        <th>DESCRIPCION</th>
                        <th>UNIDAD</th>
                        <th>PARTIDA</th>
                        <th>CANT EN ALMACEN</th>
                        <th>CANT EN SOLICITADA</th>
                        <th>CANT DISPONIBLE</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>


    <div class="card-body">
        <div class="col-12">
            <strong><div id="nombre_producto_kardex"> </div></strong><br>
            <table id="idTablaMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                        <th rowspan="2">Nro</th>
                        <th rowspan="2">FECHA</th>
                        <th rowspan="2">TIPO</th>
                        <th rowspan="2">NRO CORRELATIVO <BR> INGRESO</th>
                        <th rowspan="2">NRO CORRELATIVO <BR> SALIDA</th>
                        <th rowspan="2">DIRECCIÓN <BR> SOLICITANTE</th>
                        <th colspan="3">INGRESOS</th>
                        
                        <th colspan="3">SALIDAS</th>                        
                        <th colspan="2">SALDOS</th>                        
                        
                    </tr>
                    <tr class="bg-dark text-white">
                                                
                        
                        <th style="background: #638090;">CANT</th>
                        <th style="background: #638090;">PRECIO U</th>
                        <th style="background: #638090;">TOTAL</th>
                        <th style="background: #1983BD;">CANT</th>
                        <th style="background: #1983BD;">PRECIO U</th>
                        <th style="background: #1983BD;">TOTAL</th>
                        <th>SALDOS</th>                        
                        <th>TOTAL</th>                        
                    </tr>
                </thead>
                <tbody id = "tablaKardex">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal " id="detalleKardexMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Kardex del Material</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong><div id="nombre_producto"> </div></strong><br>
                <div class="col-12">
                    <table id="idTablaKardexMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>NRO</th>
                                <th>GESTIÓN</th>
                                <th>TIPO PROCESO</th>
                                <th>DIRECCIÓN SOLICITANTE</th>                                
                                <th>CANT ENTRADA</th>
                                <th>CANT SALIDA</th>
                                <th>SALDO</th>                                
                                <th>PRECIO UNI</th>
                                <th>PRECIO TOTAL</th>
                                <th>FECHA</th>
                                
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
        
    });
</script>