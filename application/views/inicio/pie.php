          </div>
              <!-- content-wrapper ends -->
              <!-- partial:partials/_footer.html -->
              <footer class="footer">
                  <div class="container-fluid clearfix">
                      <span class="float-right">
                          <a href="#">SISTEMAS-ALDIDASOFT</a> &copy; 2023
                      </span>
                  </div>
              </footer>
            <!-- partial -->
          </div>
      <!-- row-offcanvas ends -->
      </div>
      <!-- page-body-wrapper ends -->
</div>

<div class="modal" id="videoTutorial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1200px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>VIDEOTUTORIAL DE USO DEL SISTEMA</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <video src="<?php echo  base_url() ?>upload/video/tutorial.mp4" width="100%" height="100%" controls></video>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
        cargarAvatar();
    });
</script>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo base_url();?>resources/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/popper.js/dist/umd/popper.min.js"></script>

  <script src="<?php echo base_url();?>resources/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- <script src="<?php echo base_url();?>resources/node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
  --> 
  
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->

  <!-- scripts tabuladores-->
  <!--script src="<?php echo base_url();?>resources/node_modules/pwstabs/assets/jquery.pwstabs.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/tabs.js"></script-->

  <!-- scripts barra de progreso-->
  <!--script src="<?php echo base_url();?>resources/node_modules/progressbar.js/dist/progressbar.min.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/jquery-circle-progress/dist/circle-progress.min.js"></script>
  <script src="<?php echo base_url();?>resources/js/progress-bar.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/circle-progress.js"></script-->

 <!-- scripts lista Dinamica-->
  <!--script src="<?php echo base_url();?>resources/node_modules/dragula/dist/dragula.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/dragula.js"></script-->

  <!-- scripts para las notificaciones-->
  <!--script src="<?php echo base_url();?>resources/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/toastDemo.js"></script-->

  <!--scripts para los chartjs-->
  <!--script src="<?php echo base_url();?>resources/node_modules/chart.js/dist/Chart.min.js"></!--script-->

  <!-- scripts para los flot-->
  <!--script src="<?php echo base_url();?>resources/node_modules/flot/jquery.flot.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/flot/jquery.flot.resize.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/flot/jquery.flot.categories.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/flot/jquery.flot.fillbetween.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules\flot\jquery.flot.stack.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/flot/jquery.flot.pie.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/float-chart.js"></script-->

  <!-- scripts para los sparkline-->
  <!--script src="<?php echo base_url();?>resources/node_modules/jquery-sparkline/jquery.sparkline.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/sparkline.js"></script-->

  <!-- scripts para los C3-->
  <!--script src="<?php echo base_url();?>resources/node_modules/d3/d3.min.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/c3/c3.min.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/c3.js"></script-->

  <!-- scripts para morris-->
  <!--script src="<?php echo base_url();?>resources/node_modules/raphael/raphael.min.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/morris.js/morris.min.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/morris.js"></script-->

 <!-- scripts para tabla estilos-->
  <!--script src="<?php echo base_url();?>resources/node_modules/bootstrap-table/dist/bootstrap-table.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/bootstrap-table.js"></script-->

  <!-- scripts para tabla normal-->
  <script src="<?php echo base_url();?>resources/node_modules/datatables.net/js/jquery.dataTables.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
  <script src="<?php echo base_url();?>resources/js/data-table.js"></script>

  <!--  scripts para pasos-->
  <!--script src="<?php echo base_url();?>resources/bower_components/jquery.steps/build/jquery.steps.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/wizard.js"></script-->

  <!--scripts para mascaras-->
  <!--script src="<?php echo base_url();?>resources/node_modules/inputmask/dist/jquery.inputmask.bundle.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/inputmask/dist/inputmask/phone-codes/phone.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/inputmask/dist/inputmask/phone-codes/phone-be.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/inputmask/dist/inputmask/phone-codes/phone-ru.js"></script>
  <script-- src="<?php echo base_url();?>resources/node_modules/inputmask/dist/inputmask/bindings/inputmask.binding.js"></script-->


  <!-- scripts para iterador-->
  <!--script src="<?php echo base_url();?>resources/node_modules/jquery.repeater/jquery.repeater.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/form-repeater.js"></script-->


  <!-- scripts para formulario editable-->
  <!--script src="<?php echo base_url();?>resources/node_modules/moment/min/moment.min.js"></!--script>
  <script src="<?php echo base_url();?>resources/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js"></script>
  <script src="<?php echo base_url();?>resources/js/hoverable-collapse.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/editorDemo.js"></script-->

<!-- scripts para formulario buscador-->
  <!--script src="<?php echo base_url();?>resources/bower_components/typeahead.js/dist/typeahead.bundle.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/typeahead.js"></script-->

  <!-- scripts para complementos-->
  <!--script src="<?php echo base_url();?>resources/node_modules/jquery-asColor/dist/jquery-asColor.min.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/jquery-asGradient/dist/jquery-asGradient.min.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/select2/dist/js/select2.min.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/jquery-tags-input/dist/jquery.tagsinput.min.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/jquery-knob/dist/jquery.knob.min.js"></script>
  <script src="<?php echo base_url();?>resources/node_modules/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
  <script src="<?php echo base_url();?>resources/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>
  <script src="<?php echo base_url();?>resources/bower_components/switchery/dist/switchery.min.js"></script>
  <script src="<?php echo base_url();?>resources/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/form-addons.js"></script-->

    <!-- scripts para selector de fechas-->
  <script src="<?php echo base_url();?>resources/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>resources/js/formpickers.js"></script>

   <!-- scripts para cajas boleanas-->
  <!--script src="<?php echo base_url();?>resources/node_modules/icheck/icheck.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/iCheck.js"></script-->

  <!-- scripts para seleccionar divisor-->
  <!--script src="<?php echo base_url();?>resources/bower_components/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/bt-multiselect-splitter.js"></script-->

 <!-- scripts para limites-->
  <script src="<?php echo base_url();?>resources/node_modules/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
  <script src="<?php echo base_url();?>resources/js/bt-maxLength.js"></script>

  <!--scripts para validaciones de form-->
  <!--script src="<?php echo base_url();?>resources/node_modules/jquery-validation/dist/jquery.validate.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/form-validation.js"></script-->

   <!--scripts para carga de archivos-->
  <!--script src="<?php echo base_url();?>resources/node_modules/dropify/dist/js/dropify.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/dropify.js"></script-->


  <!-- scripts para zona de desceso-->
  <!--script src="<?php echo base_url();?>resources/node_modules/dropzone/dist/dropzone.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/dropzone.js"></script-->

  <!-- scripts para carga de archivo basica-->
  <!--script src="<?php echo base_url();?>resources/node_modules/jquery-file-upload/js/jquery.uploadfile.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/jquery-file-upload.js"></script-->

  <!-- scripts para calendario-->
  <!--script src="<?php echo base_url();?>resources/node_modules/moment/moment.js"></!--script>
  <script src="<?php echo base_url();?>resources/node_modules/fullcalendar/dist/fullcalendar.min.js"></script>
  <script-- src="<?php echo base_url();?>resources/js/calendar.js"></script-->
  <!-- scripts para alerta-->
  <!--script src="<?php echo base_url();?>resources/node_modules/sweetalert2/dist/sweetalert2.min.js"></!--script>
  <script-- src="<?php echo base_url();?>resources/js/alerts.js"></script-->
 <!-- scripts para modal-->
  <!--script src="<?php echo base_url();?>resources/js/modal-demo.js"></!--script-->

  <!-- inject:js -->
  <script src="<?php echo base_url();?>resources/js/off-canvas.js"></script>
  <script src="<?php echo base_url();?>resources/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url();?>resources/js/misc.js"></script>
  <!-- endinject -->

  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
  <!--script type="text/javascript">
  document.onkeydown= function(){
    return false;
  }

</!--script-->
</body>

</html>
