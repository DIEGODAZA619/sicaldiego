<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/ingresos/ingresos.js"></script>
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

<h1 class="page-title">INGRESO DE MATERIALES</h1>
<div class="card" id="tablaIngresos" style="display:none">

    <div class="card-body">
        <div class="row">
        <div class="col-6">
            <h1 class="page-title">ORDEN DE COMPRA(S)</h1>
        </div>
        <div class="col-6">
            <button type="button" id="btnrango" class="btn btn-success float-right" onclick='abrirDialogIngresoMaterial()' ><i class="mdi mdi-pencil"></i> Nuevo Ingreso</button>
        </div>
        </div>
    </div>
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
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="card" id="cargarIngresos" style="display:none">
    <input type="hidden" name="txtIdIngreso" id="txtIdIngreso">
    <div class="card-body">
        <div class="row col-12 fondoClaroNaranja" >
            <div class="col-6" >
                <span id="orden_compra"></span><span id="proveedor"></span>
                                           <span id="descripcion"></span>
                                           <span id="fechaIngreso"></span>
                
            </div>
           <!-- <div class="col-6"><a class="btn btn-warning " href="#idTablaMaterial">SELECCIONA MATERIALES PARA ESTA ORDEN DE COMPRA</a></div>-->
           <div class="col-6"><a class="btn btn-warning " href="javascript:abrirListaMaterialModal();">SELECCIONA MATERIALES PARA ESTA ORDEN DE COMPRA</a></div>
        </div>
 <div class="modal " id="listaMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Formulario de Ingreso</b></h3>
                <button type="button" class="close cerrarModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
        
                    <div class="col-12" id="idTablaMaterial">
                        <h2 class="page-title">LISTA DE MATERIALES A SELECCIONAR</h2>
                        <table id="idTablaMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr class="bg-dark text-white">
                                        <th>Nro</th>
                                        <th>PARTIDA</th>
                                        <th>CODIGO</th>
                                        <th>DESCRIPCION</th>
                                        <th>UNIDAD</th>
                                        <th>TIPO</th>
                                        <th>CANTIDAD</th>
                                        <th>ESTADO</th>
                                        <th>Opciones</th>
                                    </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                  </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-danger cerrarModal" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                    <button id="guardarIngreso" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span>Agregar</button>
                </div>
            </div>
        </div>
    </div>   



    </div>
    <BR>
    <!--h1 class="page-title">Formulario de Ingreso</!--h1>
     <div class="card-body">
        <form id="formularioIngresoMaterial">
            <div  class=" col-lg-12 alert alert-danger"  id="validacionIngreso" style="display: none;"></div>

            <div class="row">
                <input type="hidden" class="form-control" id="accion" name="accion" required="required">
                <input type="hidden" class="form-control" id="id_ingreso" name="id_ingreso" required="required">
                <input type="hidden" class="form-control" id="id_material" name="id_material" required="required">
                <input type="hidden" class="form-control" id="id_registro" name="id_registro" required="required">

                <div class="col-lg-3">
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
                <div class="col-lg-3">
                    <BR>
                    <button id="guardarIngreso" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>Agregar</button>
                </div>
            </div>
        </form>
    </div-->
</div>

<br>
<div class="card" id="materialSeleccionado" style="display: none;">
    
    <div class="card-body">
        <div class="col-12">
            <h1 class="page-title">MATERIALES SELECCIONADOS</h1>        
        </div> 
        <div class="col-12">
            <table id="idTablaAcumuladorIn" class="table table-striped table-responsive" cellspacing="0" width="100%">
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

<div class="modal " id="habilitarIngresoMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1200px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" ><b>REGISTRO DE INGRESO DE MATERIALES</b></h3>
            </div>
            <div  class=" col-lg-12 alert alert-danger"  id="validacionRegistroIngreso" style="display: none;"></div>

            <div class="modal-body">
                <form id="formularioRegistroIngreso">
                    <input type="hidden" name="txtaccion" id="txtaccion">
                    <input type="hidden" name="txtidRegistro" id="txtidRegistro">
                    <div class="col-12 row">
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                                <label for="recipient-name" class="form-control-label">Número de Orden de Compra:</label>
                        </div>
                        <div class="col-4 form-group">
                                <input class="form-control" type="text" name="txtOrden" id="txtOrden" >
                        </div>

                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label"></label>
                        </div>
                        <div class="col-4 form-group">
                                
                            
                        </div> <br><br>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label">Nota de Remisión:</label>
                        </div>
                        <div class="col-4 form-group">
                                <input class="form-control" type="text" name="txtNotaRemision" id="txtNotaRemision" >
                            
                        </div>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label">Fecha Nota Remisión:</label>
                        </div>
                        <div class="col-4 form-group">
                                <input type="date" class="form-control" id="txtfecha_nota_remision" name="txtfecha_nota_remision" >
                            
                        </div>
                        <br><br>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                                <label for="recipient-name" class="form-control-label">Nro. Factura(s):</label>
                        </div>
                        <div class="col-4 form-group">
                                <input class="form-control" type="text" name="txtNumeroFactura" id="txtNumeroFactura" >
                          
                        </div>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label">Fecha Factura:</label>
                        </div>
                        <div class="col-4 form-group">
                                <input type="date" class="form-control" id="txtfecha_factura" name="txtfecha_factura" >
                            
                        </div>
                        <br>
                        <br>

                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label">Proveedor:</label>
                        </div>
                        <div class="col-10 form-group">
                                <SELECT class="form-control" name="slProveedor" id = "slProveedor" >
                                </SELECT>
                        </div>

                        <br>
                        <br>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                            <label for="recipient-name" class="form-control-label">Descripción Ingreso:</label>
                        </div>
                        <div class="col-lg-10 grid-margin grid-margin-lg-0">
                            <div class="input-group">
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" ></textarea><br>
                            </div>
                        </div>
                        <div class="col-lg-2 grid-margin grid-margin-lg-0">
                        </div>
                        <div class="col-lg-10 grid-margin grid-margin-lg-0">
                            <div class="input-group">
                                <p class="text text-danger" > * maximo 250 caracteres. (<span id="contadorTaComentario" >0/250</span>)</p>
                            </div>
                        </div>
                            <br>
                    </div>
                </form>
                <div id="idvalidacion" name="idvalidacion" class=" col-12 alert alert-danger" role="alert" style="display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id = "btnGuardar" class="btn btn-success" onclick='registrarIngreso()'>Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="formularioIngresoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Formulario de Ingreso</b></h3>
                <button type="button" class="close cerrarModal2" data-dismiss="modal" aria-label="Close">
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
                        <div class="col-lg-12">
                            <div id="cant_almacen"> </div>
                        </div>
                        <div class="col-lg-12"><div id="cant_solicitada"> </div>
                        </div>
                        <div class="col-lg-12 fondoClaroNaranja"><strong><div id="cant_no_solicitada"></div> </strong>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-danger cerrarModal2" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                <button id="guardarIngreso" type="button" class="btn btn-success" onclick="guardarIngreso()"><span class="glyphicon glyphicon-floppy-disk"></span>Agregar</button>
            </div>
        </div>
    </div>
</div>
<style>
    /* Add animation (Chrome, Safari, Opera) */
@-webkit-keyframes example {
  from {top:-100px;opacity: 0;}
  to {top:0px;opacity:1;}
}

/* Add animation (Standard syntax) */
@keyframes example {
  from {top:-100px;opacity: 0;}
  to {top:0px;opacity:1;}
}
    #idTablaMaterial{
        display: block;
    }
    #idTablaMaterial:target {
          /* Add animation */
  -webkit-animation-name: example; /* Chrome, Safari, Opera */
  -webkit-animation-duration: 0.8s; /* Chrome, Safari, Opera */
  animation-name: example;
  animation-duration: 0.8s;
      display: block;
    }
    .c_critico{
        background-color: #F19D9D; 
    }
    .c_semicritico{
        background-color: antiquewhite ; /* #d9edf7; coral;*/
    }
</style>  
<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarfunciones();
        init_contadorTa("txtmotivo","contadorTaComentario", 250);

        /*$('#txtNumeroFactura').on('input', function () {
            this.value = this.value.replace(/[^0-9,]/g, '').replace(/,/g, '.');
            });*/

      $(".cerrarModal").click(function () {
        $("#listaMaterialModal ").hide();
        //$("#divCapa").removeClass("overlay");
        
    });
       $(".cerrarModal2").click(function () {
        $("#formularioIngresoModal ").hide();
        $("#divCapa").removeClass("overlay");
        
    });
       

    });
</script>