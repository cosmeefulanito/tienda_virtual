    <?= headerAdmin($data); ?>    
    <?= getModal("roles_modal",$data); ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-user-tag"></i> <?=$data['page_tag'];?> <button class="btn btn-primary" onclick="openModal();"><i class="fas fa-plus"></i> Nuevo</button></h1>
          <!-- <p>Start a beautiful journey here</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=$data['page_tag'];?></a></li>
        </ul>
      </div>
      <!-- <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">Roles de usuarios</div>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" id="rolesTable">
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>    
    <?= footerAdmin($data); ?>


  

   
