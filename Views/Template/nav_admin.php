<!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?=media();?>/image/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userSession']['nombres']." ".$_SESSION['userSession']['apellidos']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userSession']['nombre']?></p>
        </div>
      </div>
      <ul class="app-menu">
        <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url()."/dashboard"?>">
            <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos'][2]['r'])){ ?>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
            <span class="app-menu__label">Usuario</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url()."/usuarios"?>"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
            <li><a class="treeview-item" href="<?= base_url()."/roles"?>" rel="noopener"><i class="icon fa fa-circle-o"></i>Roles</a></li>                     
          </ul>
        </li>
      <?php } ?>

      <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
          <li><a class="treeview-item" href="<?= base_url()."/clientes"?>"><i class="icon fa fa-user" aria-hidden="true"></i> Clientes</a></li>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][6]['r'])){ ?>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fas fa-shopping-cart" aria-hidden="true"></i>
            <span class="app-menu__label">Tienda</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(!empty($_SESSION['permisos'][4]['r'])){ ?>
            <li><a class="treeview-item" href="<?= base_url()."/productos"?>"><i class="icon fa fa-circle-o"></i>Productos</a></li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][6]['r'])){ ?>
            <li><a class="treeview-item" href="<?= base_url()."/categorias"?>" rel="noopener"><i class="icon fa fa-circle-o"></i>Categorias</a></li>                     
          </ul>
          <?php } ?>
        </li>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
          <li><a class="treeview-item" href="<?= base_url()."/pedidos"?>"><i class="icon fa fa-shopping-cart" aria-hidden="true"></i> Pedidos</a></li>
        <?php } ?>
          <li><a class="treeview-item" href="<?= base_url()."/logout"?>"><i class="icon fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
        </li>
      </ul>
    </aside>