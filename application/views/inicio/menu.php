 <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="row row-offcanvas row-offcanvas-right">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas sidebar-float" id="sidebar">
            <ul class="nav">
                <?php foreach($rolescero as $rol):?>
                    <li class="nav-item nav-category">                      
                      <a href="<?php echo site_url($rol->link);?>" class="nav-link"><?= $rol->opcion?></a>
                    </li>
                <?php endforeach?>



                <?php $nivelanterior = 0; $con = 0;?>
                <?php foreach($roles as $rol): ?>
                <?php if($rol->nivel== 1){ ?>
                    <?php if ($nivelanterior == 2){ ?>
                            </ul>
                        </div>
                    </li>
                    <?php }?>
                    <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#submenu<?php echo $rol->id; ?>" aria-expanded="false" aria-controls="collapseExample">
                        <i class="mdi mdi-chart-donut"></i>
                        <span class="menu-title"><?=$rol->opcion?></span>
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="submenu<?php echo $rol->id; ?>">
                        <ul class="nav flex-column sub-menu">
                <?php } ?>

                <?php if ($rol->nivel == 2){?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url($rol->link);?>"><?=$rol->opcion?></a>
                    </li>
                <?php }?>
                <?php $nivelanterior = $rol->nivel;  ?>
                <?php endforeach?>
                <?php if ($nivelanterior == 2){?>
                            </ul>
                        </div>
                    </li>
                <?php }?>
            </ul>
        </nav>

        <!-- partial -->
        <div class="content-wrapper">

