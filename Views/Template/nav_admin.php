<!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="Assets/image/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">Andrés Astorga</p>
          <p class="app-sidebar__user-designation">Administrador</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?= base_url()."/dashboard"?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
            <span class="app-menu__label">Usuarios</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url()."/usuarios"?>"><i class="icon fa fa-circle-o"></i>Usuario</a></li>
            <li><a class="treeview-item" href="<?= base_url()."/roles"?>" rel="noopener"><i class="icon fa fa-circle-o"></i>Roles</a></li>
            <li><a class="treeview-item" href="<?= base_url()."/permisos"?>"><i class="icon fa fa-circle-o"></i> Permisos</a></li>            
          </ul>
          <li><a class="treeview-item" href="<?= base_url()."/clientes"?>"><i class="icon fa fa-user" aria-hidden="true"></i> Clientes</a></li>
          <li><a class="treeview-item" href="<?= base_url()."/productos"?>"><i class="icon fa fa-archive" aria-hidden="true"></i> Productos</a></li>
          <li><a class="treeview-item" href="<?= base_url()."/pedidos"?>"><i class="icon fa fa-shopping-cart" aria-hidden="true"></i> Pedidos</a></li>
          <li><a class="treeview-item" href="<?= base_url()."/logout"?>"><i class="icon fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
        </li>
      </ul>
    </aside>