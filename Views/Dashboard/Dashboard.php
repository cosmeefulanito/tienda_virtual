    <?= headerAdmin($data); ?>    
    <main class="app-content">
      <div class="app-title">
        <div>          
          <h1><i class="fa fa-dashboard"></i><?=$data['tag_page'];?></h1>
          <!-- <p>Start a beautiful journey here</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>/dashboard"><?=$data['tag_page'];?></a></li>
        </ul> 
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">Dashboard</div>
            <?php //dep($_SESSION['userSession']); ?>
            <?php //echo getPermisosModulo(8); ?>
            <?php //dep($_SESSION['permisos']); ?>
            <?php //dep($_SESSION['permisosMod']); ?>
          </div>
        </div>
      </div>
    </main>    
   <?= footerAdmin($data); ?>