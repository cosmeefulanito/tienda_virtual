<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="4ndr35 4570r54">
    <meta name="theme-color" content="#0f3443">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
    <!-- Font-icon css-->
    
    <link rel="icon" type="image/png" href="<?= media(); ?>/image/favicon.png"/>
    <title><?= $data["page_title"]; ?></title>
    <!-- <?php echo "<pre>";print_r($data);echo "</pre>"; ?> -->
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1><?=$data['page_title'];?></h1>
      </div>
      <div class="login-box">
        <form class="login-form" id="loginFormReset" name="loginFormReset">
          <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
          <div class="form-group">
            <input type="hidden" name="idusuario" id="idusuario" value="<?=$data['id_persona'];?>">
            <input type="hidden" name="txt_email" id="txt_email" value="<?=$data['Email'];?>">
            <input type="hidden" name="txt_token" id="txt_token" value="<?=$data['token'];?>">
            <label class="control-label">Nueva contraseña</label>
            <input id="txtNuevoPass" name="txtNuevoPass" class="form-control" type="password" placeholder="***" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Confirma contraseña</label>
            <input id="txtConfirmaPass" name="txtConfirmaPass" class="form-control" type="password" placeholder="***">
          </div>
          <div class="alertLogin" class="text-center"></div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Reestablecer</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/font-awesome.js"></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script type="text/javascript">const base_url = '<?=base_url();?>'</script>
    
    <!-- The javascript plugin to display page loading on top-->
<!-- <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>  -->
    <script src="<?= media(); ?>/js/<?=$data['page_function_js']?>"></script>
    
   

  </body>
</html>