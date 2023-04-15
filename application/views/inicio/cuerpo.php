<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/inicio.js"></script>

<h1 class="page-title">PANEL PRINCIPAL</h1>
<div class="row grid-margin">
    <div class="col-12 col-lg-6 grid-margin grid-margin-lg-0">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">INFORMACIÓN GENERAL</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="custom-legend-container small-chart-container">
                            <div id="sales-chart-legend" class="legend-top">
                                          
                            </div>
                            <canvas id="sales-chart" style="width:100%"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="col-12 col-lg-6 grid-margin grid-margin-lg-0">
        <div class="card">
            <div class="card-body">
                
                <h1 class="page-title">INGRESO DE MATERIALES NO APROBADOS</h1>
                <div class="card" id="tablaIngresos" >
                    <div class="card-body">
                        <div class="col-12">
                            <table id="idTablaIngreso" class="table table-striped table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="bg-dark text-white">
                                            <th>Nro</th>
                                            <th>ORDEN DE COMPRA</th>
                                            <th>NOTA_REMISION</th>
                                            <th>PROVEEDOR</th>
                                            <th>DESCRIPCION</th>
                                            <th>FECHA INGRESO</th>
                                            <th>ESTADO</th>
                             
                                        </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>-->
</div>
<!--<h1 class="page-title">LISTA DE MATERIALES SOLICITADOS, AUN NO ENTREGADOS</h1>

<div class="card"  >
    <div class="card-body">
        <div class="col-12">
            <table id="idTablaAcumulador" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Nro</th>
                        <th>CODIGO</th>
                        <th>FECHA </th>
                        <th>DESCRIPCION</th>
                        <th>UNIDAD</th>
                        <th>PARTIDA</th>
                        <th>CANTIDAD SOLICITADA</th>
                        <th>ESTADO</th>

                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>-->



<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarTablaIngresosNoAprobados();
        cargarMaterialesAcumulados();
    });
</script>