<?php
  include('inc/bdd.php');
  if(isset($_SESSION['id']))
  {
    $req=$bdd->prepare("SELECT * FROM utilisateurs WHERE id = :id");
    $req->execute(array(
      'id' => $_SESSION['id']
    ));
    $user=$req->fetch();
  }
?>
<html>
  <head>
    <title>EILCO - Insertion Professionnelle</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <base href="http://localhost/insertionpro/"/>
    <link rel="stylesheet" type="text/css" href="css/css.css"/>
    <link rel="stylesheet" type="text/css" href="css/circle.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  </head>
  <body class="bg-grey">
    <header class="p15 bg-white container">
      <div class="content container spb m0">
        <div>
          <a href="index">
            <img src="media/img/logo.png" alt="Logo EILCO" id="header-logo"/>
          </a>
        </div>
        <div id="nav">
          <?php include('inc/nav.php'); ?>
        </div>
      </div>
    </header>
