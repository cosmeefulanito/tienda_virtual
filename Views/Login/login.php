<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="4ndr35 4570r54">
    <meta name="theme-color" content="#0f3443">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="Assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    <!-- Font-icon css-->    
    <link rel="icon" type="image/png" href="Assets/image/favicon.png"/>
    <title><?= $data["page_title"]; ?></title>
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
        <div id="divLoading">
          <div>
            <img src="<?= media();?>/image/Blocks.svg">
          </div>
        </div>
        <form class="login-form" id="loginForm" name="loginForm">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Iniciar sesión</h3>
          <div class="form-group">
            <label class="control-label">USUARIO</label>
            <input id="txtEmail" name="txtEmail" class="form-control" type="email" placeholder="Email" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="********">
          </div>
          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste tu contraseña?</a></p>
            </div>
          </div>
          <div class="alertLogin" class="text-center"></div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Iniciar sesión</button>
          </div>
        </form>
        <form id="resetForm" name="resetForm" class="forget-form">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste tu contraseña?</h3>
          <div class="form-group">
            <label for="txt_email" class="control-label">EMAIL</label>
            <input class="form-control" id="txt_email" name="txt_email" type="email" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Reestablecer</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i>Volver</a></p>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="Assets/js/jquery-3.3.1.min.js"></script>
    <script src="Assets/js/popper.min.js"></script>
    <script src="Assets/js/bootstrap.min.js"></script>
    <script src="Assets/js/main.js"></script>
    <script src="Assets/js/font-awesome.js"></script>
    <script type="text/javascript" src="Assets/js/plugins/sweetalert.min.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="Assets/js/plugins/pace.min.js"></script> 
    <script src="Assets/js/<?=$data['page_function_js']?>"></script>
    <script type="text/javascript">const base_url = '<?=base_url();?>'</script>

  </body>
</html>