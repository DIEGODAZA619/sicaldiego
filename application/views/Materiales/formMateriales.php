<script src="<?php echo  base_url() ?>scriptjs/jquery.js"></script>
<script src="<?php echo  base_url() ?>scriptjs/materiales/materiales.js"></script>

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

<h1 class="page-title">CONTROL DE MATERIALES</h1>
<div class="card">
    <div class="card-body">
        <div class="col-12">
            <div class="col-2 col-lg-2 ml-lg-auto">
                <button type="button" name='btnRegistroMaterial' class="btn btn-success" onclick='adicionarMaterial()'><i class="mdi mdi-check"></i>Adicionar Material</button>
            </div>
            <hr>
            <table id="idTablaMateriales" class="table table-striped table-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                            <th>Nro</th>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>UNIDAD</th>
                            <th>MATERIAL</th>
                            <!--<th>IMAGEN</th>-->
                            <th>Opciones</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal " id="registroMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><b>Nuevo Material</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMateriales" enctype="multipart/form-data">
                    <div class="col-12 row">
                        <input type="text" class="form-control" id="texto" name="texto" hidden>
                        <input type="text" class="form-control" id="id_material" name="id_material" hidden>
                        
                        <div class="col-4 form-group">
                            <label class="form-control-label">Categoria:</label>
                            <select class="form-control" id="cbcategoria" name="cbcategoria"  onchange=cargarComboSubCategoria()>
                            </select>
                            <div id="cbcategoria_error" style="display: none;"><small><label class="error text-danger">La Categoria es requerida.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Sub Categoria:</label>
                            <select class="form-control" id="cbsubcategoria" name="cbsubcategoria" onchange=cargarComboMaterial()>
                            </select>
                            <div id="cbsubcategoria_error" style="display: none;"><small><label class="error text-danger">La Sub Categoria es requerida.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Material:</label>
                            <select class="form-control" id="cbmaterial" name="cbmaterial">
                            </select>
                            <div id="cbmaterial_error" style="display: none;"><small><label class="error text-danger">El Material es requerido.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Unidad:</label>
                            <select class="form-control" id="cbunidad" name="cbunidad">
                            </select>
                            <div id="cbunidad_error" style="display: none;"><small><label class="error text-danger">La Unidad es requerida.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Descripción:</label>
                            <input type="text" class="form-control" id="txtdescripcion" name="txtdescripcion">
                            <div id="txtdescripcion_error" style="display: none;"><small><label class="error text-danger">El Descripcion es requerido.</label></small></div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-control-label">Codigo:</label>
                            <input type="text" class="form-control" id="txtcodigo" name="txtcodigo" readonly />
                            <div id="txtcodigo_error" style="display: none;"><small><label class="error text-danger">El Codigo es requerido.</label></small></div>
                        </div>
                        
                        <!--
                        <div class="col-4 form-group">
                            <label class="form-control-label">Foto:</label>
                            <input class="form-control" name="file-input" id="file-input" type="file" />
                             <br />
                            <img id="imgSalida" width="50%"  src="" />
                        </div>
                        -->
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




<div class="modal " id="cargarArchivoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"> Cargar Archivo</h3>
                <button type="button" class="close cerrarCargar" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>

            <div class="modal-body ">
                <form action="" method="post" enctype="multipart/form-data" id="formRegistroArchivo">

                    <input type="hidden" name="idMaterial" id="idMaterial">
                    <div id="divFile" align="center"><input type="file" name="fileImg" id="fileImg"></div>
                </form>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-danger cerrarCargar" data-dismiss="modal" aria-label="Close">
                    Cerrar
                </button>
                <button class="btn btn-success" id="btnSubmit" onclick="guardarArchivoM();">Guardar</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarfunciones();
        cargarCombos();
    });

    $(".cerrarVerFoto , .cerrarCargar").click(function () {
        $("#cargarArchivoModal").hide();
        $("#verfotoModal").hide();
        $("#divCapa").removeClass("overlay");
        return false;
    });


</script>

<script type="text/javascript" language="javascript">
$(window).load(function(){

 $(function() {
  $('#file-input').change(function(e) {
      addImage(e); 
     });

     function addImage(e){
      var file = e.target.files[0],
      imageType = /image.*/;
    
      if (!file.type.match(imageType))
       return;
  
      var reader = new FileReader();
      reader.onload = fileOnload;
      reader.readAsDataURL(file);
     }
  
     function fileOnload(e) {
      var result=e.target.result;
      $('#imgSalida').attr("src",result);
     }
    });
  });
</script>
