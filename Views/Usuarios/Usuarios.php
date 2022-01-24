    <?= headerAdmin($data); ?>    
    <?= getModal("usuarios_modal",$data); ?>    
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-user-tag"></i> <?=$data['page_tag'];?> 
          <?php if(!empty($_SESSION['permisosMod']['w'])){ ?> <button class="btn btn-info" onclick="openModal();"><i class="fas fa-plus"></i> Nuevo</button> <?php } ?>
          </h1>
        </div>
    <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=$data['page_tag'];?></a></li>
        </ul>
      </div>
      <div class="row">
        <?php //dep($_SESSION['permisos']); ?>
        <?php //dep($_SESSION['permisosMod']); ?>
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">              
              <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" id="usuariosTable">
                  <thead>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Rol</th>
                    <th>status</th>
                    <th>acciones</th>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>    
    </main>
    <?= footerAdmin($data); ?>