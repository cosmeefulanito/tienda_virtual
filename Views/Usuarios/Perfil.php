<?= headerAdmin($data); ?>
<?= getModal("perfilModal",$data); ?>
<main class="app-content">
  <div class="row user">
    <div class="col-md-12">
      <div class="profile">
        <div class="info">
          <img class="user-img" src="<?=media();?>/image/avatar.png">
          <h4><?= $_SESSION['userSession']['nombres']. ' '.$_SESSION['userSession']['apellidos'];?></h4>
          <p><?= $_SESSION['userSession']['nombre'];?></p>
        </div>
        <div class="cover-image"></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="tile p-0">
        <ul class="nav flex-column nav-tabs user-tabs">
          <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos personales</a></li>
          <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Datos de empresa</a></li>
        </ul>
      </div>
    </div>  
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane active" id="user-timeline">
          <div class="timeline-post">
            <div class="post-media">
              <div class="content">
                <h4>Datos personales <button type="button" class="btn btn-primary btn-sm" onclick="openModalPerfil();"><i class="fas fa-pencil-alt"></i></button></h4>
              </div>
            </div>            
              <!-- <h3 class="tile-title">Bordered Table</h3> -->
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td><strong>RUT</strong></td>
                    <td><?= $_SESSION['userSession']['identificacion'] ?></td>
                  </tr>
                  <tr>
                    <td><strong>Nombre</strong></td>
                    <td><?= $_SESSION['userSession']['nombres']. ' '.$_SESSION['userSession']['apellidos'];?></td>
                  </tr>
                  <tr>
                    <td><strong>Correo</strong></td>
                    <td><?= $_SESSION['userSession']['email'];?></td>
                  </tr>
                  <tr>
                    <td><strong>Telefono</strong></td>
                    <td><?= $_SESSION['userSession']['telefono'];?></td>
                  </tr>
                  <tr>
                    <td><strong>Fecha de registro</strong></td>
                    <td><?= $_SESSION['userSession']['datecreated'];?></td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
        <div class="tab-pane fade" id="user-settings">
          <div class="tile user-settings">
            <h4 class="line-head">Datos de empresa</h4>
            <form id="formDataFiscal" name="formDataFiscal">
              <div class="row mb-4">
                <div class="col-md-6">
                  <label>RUT</label>
                  <input class="form-control" type="text" id="txt_rut_fiscal" name="txt_rut_fiscal" value="<?= $_SESSION['userSession']['nit'] ?>">
                </div>
                <div class="col-md-6">
                  <label>Nombre</label>
                  <input class="form-control" type="text" id="txt_nombre_fiscal" name="txt_nombre_fiscal" value="<?= $_SESSION['userSession']['nombre_fiscal'] ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mb-4">
                  <label>Direccion</label>
                  <input class="form-control" type="text" id="txt_direccion_fiscal" name="txt_direccion_fiscal" value="<?= $_SESSION['userSession']['direccion_fiscal'] ?>">
                </div>
              </div>
              <div class="row mb-10">
                <div class="col-md-12">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?= footerAdmin($data); ?>