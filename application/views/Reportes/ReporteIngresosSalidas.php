<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/reportes/entradasalida.js"></script>
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

<h1 class="page-title">REPORTE DE INGRESOS Y SALIDAS</h1>
<div class="card">
    <div class="card-body">
        <div class="container-fluid">            
            <div class="row">                    
                <div class="col-1 form-group" align="right">
                    <label>Gestión: </label>
                </div>
                <div class="col-1 form-group">
                    <select name="gestionKardex" id="gestionKardex" class="form-control">
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="col-1 form-group" align="right">
                    <label>TIPO REPORTE: </label>
                </div>
                <div class="col-1 form-group">
                    <select name="tipoReporte" id="tipoReporte" class="form-control">
                        <option value="ING">INGRESOS</option>
                        <option value="SAL">SALIDAS</option>
                    </select>
                </div>
                <div class="col-1 form-group" align="right">
                    <label>FECHA INICIO: </label>
                </div>
                <div class="col-2 form-group">                    
                    <input type="date" class="form-control" id="txtfecha_inicio" name="txtfecha_inicio" >                    
                </div>
                <div class="col-1 form-group" align="right">
                    <label>FECHA FIN: </label>
                </div>
                <div class="col-2 form-group">                    
                    <input type="date" class="form-control" id="txtfecha_fin" name="txtfecha_fin" >                    
                </div>
                
                <div class="col-1 form-group" align="left">
                    <button type="button" id = "btnGuardar" class="btn btn-success" onclick='generarReporte()'>Generar Reporte</button>
                </div>               

                
            </div>                            
            <hr>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
            <strong><div id="tipoReporteText"> </div></strong><br>
            <div id="divtablaIngresos" style="display:none;">
                <button type="button" id = "btnGuardar" class="btn btn-info" onclick='generarReporteIngresos()'>Imprimir Reporte Ingresos</button>
                <table id="idTablaResultadosIngresos" class="table table-striped table-responsive" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>FECHA</th>
                            <th>CITE (CORRELATIVO)</th>
                            <th>PROVEEDOR</th>
                            <th>VALORADO BS</th>
                            
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="divtablaSalidas" style="display:none;">
                <button type="button" id = "btnGuardar" class="btn btn-warning" onclick='generarReporteSalidas()'>Imprimir Reporte Salidas</button>
                <table id="idTablaResultadosSalidas" class="table table-striped table-responsive" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>FECHA</th>
                            <th>CITE (CORRELATIVO)</th>
                            <th>DIRECCIÓN/UNIDAD/AREA/SOLICITANTE</th>
                            <th>VALORADO BS</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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