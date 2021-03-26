<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Tienda virtual de tecnologia">
    <meta name="author" content="Andrés Astorga">
    <meta name="theme-color" content="#04B177">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="/Assets/image/favicon.ico"> -->
    <!-- <link rel="shortcut icon" type="image/jpg" href="<?= base_url();?>/Assets/image/favicon.ico"/> -->

    <link rel="icon" type="image/png" href="Assets/image/favicon.png"/>
    <!-- <link rel="icon" type="image/png" href="https://example.com/favicon.png"/> -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="Assets/image/favicon.ico">     -->
    <!-- <link href="/Assets/image/favicon.ico" rel="icon" type="image/x-icon" /> -->
    <title><?= $data['page_title']; ?></title>
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="Assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    <!-- Font-icon css-->
    <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?= base_url()."/dashboard"?>">Mi tienda</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url()."/opciones"?>"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="<?= base_url()."/perfil"?>"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="<?= base_url()."/logout"?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <?= require_once('nav_admin.php') ?>