<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/reportes/reporteMef.js"></script>
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

<h1 class="page-title">REPORTES MEFP</h1>
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
                    <label>FECHA LIMITE: </label>
                </div>
                <div class="col-2 form-group">                    
                    <input type="date" class="form-control" id="txtfecha_limite" name="txtfecha_limite" >                    
                </div>
                <div class="col-1 form-group" align="left">
                    <button type="button" id = "btnGuardar" class="btn btn-success" onclick='generarReporteDetallado()'>Generar Reporte Detallado</button>
                </div> 
                <div class="col-1 form-group" align="left">
                    
                </div> 
                <div class="col-1 form-group" align="left">
                    <button type="button" id = "btnGuardar" class="btn btn-primary" onclick='generarReportePartidas()'>Generar Reporte Partidas</button>
                </div>               

                
            </div>                            
            <hr>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
            <strong><div id="tipoReporteText"> </div></strong><br>
            <div id="divtablaValorado"  style="display:none;">
                <button type="button" id = "btnGuardar" class="btn btn-info" onclick='generarReporteValoradoReporte()'>Imprimir Reporte Detallado</button>
                <table id="idTablaResultadosDetallado" class="table table-striped table-responsive" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>NRO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>UNIDAD DE MEDIDA</th>
                            <th>PRECIO UNITARIO</th>                            
                            
                            <th>SALDO INICIAL</th>
                            <th>ENTRADAS</th>
                            <th>SALIDAS</th>
                            <th>SALDO FINAL</th>
                            <th>SALDO INICIA</th>
                            <th>ENTRADAS</th>
                            <th>SALIDAS</th>
                            <th>SALDO FINAL</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="divtablaPartidas" style="display:none;">
                <button type="button" id = "btnGuardar" class="btn btn-warning" onclick='generarReportePartidasReporte()'>Imprimir Reporte Partidas</button>
                <table id="idTablaResultadosPartidas" class="table table-striped table-responsive" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>NRO</th>                            
                            <th>PARTIDA</th>                                                        
                            <th>CANTIDAD INICIAL</th>
                            <th>SALDO INICIAL BS</th>
                            <th>CANTIDAD FINAL</th>
                            <th>SALDO FINAL BS</th>
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
        
    });
</script>