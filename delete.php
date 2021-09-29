<?php
  session_start();
  include('inc/head.php');
  if(isset($_SESSION['id']))
  {
    if($user['auth'] == 3)
    {
      if(isset($_GET['id']) AND isset($_GET['type']))
      {
          switch($_GET['type'])
          {
            case "q":
              $req=$bdd->prepare("DELETE FROM questions WHERE id = :id");
              $req->execute(array(
                'id' => $_GET['id']
              ));
              header('Location:http://localhost/insertionpro/admin/questions');
            break;
            case "a":
              $rq = $bdd->prepare('SELECT * FROM reponses_type WHERE id = :id');
              $rq->execute(array(
                'id' => $_GET['id']
              ));
              $q=$rq->fetch();
              $req=$bdd->prepare("DELETE FROM reponses_type WHERE id = :id");
              $req->execute(array(
                'id' => $_GET['id']
              ));
              header('Location:http://localhost/insertionpro/admin/questions/'.$q['idQ'].'');
            break;
          }
      }
    }
  }
?>
