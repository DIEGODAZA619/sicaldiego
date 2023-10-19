<!DOCTYPE html>
<html lang="en">
<head>
  <title>SICAL</title>
    <link rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css">
</head>
<style>
    .div-1 {
    	background-color: #296a99;
    }
</style>
<style>
    .div-2 {
      background-color: #acc3da82;
    }
</style>
<body class="navbar-primary">
  <div class="container-scroller">
    <div class="div-3">
    <div class="container-fluid page-body-wrapper">
      <div class="row " >
        <div class="content-wrapper-login full-page-wrapper d-flex align-items-center auth-pages">
          <div class="card col-lg-3 mx-auto ">
            <div class="card-body px-6 py-6">
              <img style="width: 100%;" src="<?php echo base_url();?>resources/images/logos/logo2.png" alt="">
              <?= form_open('Login/logued')?>
                <div class="form-group">
                  <label>Usuario *</label>
                  <input  name = "username" class="form-control p_input"  placeholder="Usuario" required="true">

                </div>
                <div class="form-group">
                  <label>Contraseña *</label>
                  <input name ="pass" type="password" class="form-control p_input" placeholder="Contraseña" required="true">

                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary  btn-block enter-btn">Entrar</button>
                </div>
                <!--p class="sign-up">Olvidaste tu contraseña?<a href="#">Entra Aqui</a></!--p-->
               <?= form_close()?>

               <? if ($error != "")
                 {?>
                   <div class='panel-body'><div class='alert alert-danger'>
                    <?= $error?> &times;
                    </div></div>
                 <?}
              ?>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer_login">
          <span id="nombre-sistema">SISTEMA DE CONTROL DE ALMACENES</span>
          <div class="container-fluid clearfix">
            <span class="float-right">
                <a href="#">SISTEMAS-SENAPE</a> &copy; 2023
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>