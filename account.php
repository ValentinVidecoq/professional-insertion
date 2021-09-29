<?php
  session_start();
  include('inc/head.php');
  if(isset($_SESSION['id']))
  {
    if(isset($_POST['update']))
    {
      if(empty($_POST['mail']))
      {
        $mail = $user['mail'];
      }
      else
      {
        $mail = $_POST['mail'];
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
          $mail = $user['mail'];
          $error = "Mail invalide";
        }
        else
        {
          $req=$bdd->query("SELECT COUNT(*) as nb FROM utilisateurs WHERE mail = '".$mail."'");
          $hv_mail = $req->fetch();
          if($hv_mail['nb'] != 0) /* On vérifie que l'adresse mail ne soit pas déjà utilisée */
          {
            $mail = $user['mail'];
            $error = "Mail déjà enregistré";
          }
        }
      }
      if(empty($_POST['password']))
      {
        $password = $user['password'];
      }
      else
      {
        $password = $_POST['password'];
        if(strlen($password) >= 8) /* On vérifie que le mot de passe contient au moins 8 caractères */
        {
          $password = password_hash($password,PASSWORD_DEFAULT);
        }
        else
        {
          $password = $user['password'];
          $error = "Mot de passe inférieur à 8 caractères";
        }
      }
        $req=$bdd->prepare("UPDATE utilisateurs SET mail = :mail, password = :password WHERE id = :id");
        $req->execute(array(
          'mail' => $mail,
          'password' => $password,
          'id' => $_SESSION['id']
        ));
        if(!isset($error)){$error = "Modifications effectuées";}
        //header('Location:account');
        $req=$bdd->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $req->execute(array(
          'id' => $_SESSION['id']
        ));
        $user=$req->fetch();
    }
        echo'
        <div class="container">
          <div class="center content container">';
            echo'
            <div class="bg-white rbox p30 m15 as-fs">
              <h3>Modification du compte</h3>';
                if(isset($error))
                {
                  echo'<span class="error">'.$error.'</span>';
                }echo'
              <form method="post">
                <input type="text" value="'.$user['prenom'].'" disabled="disabled"/><br />
                <input type="text" value="'.$user['nom'].'" disabled="disabled" /><br />
                <input type="email" name="mail" placeholder="Mail" value="'.$user['mail'].'"autocomplete="off"/><br />
                <input type="password" name="password" placeholder="Mot de passe" autocomplete="off"/><br />
                <input type="submit" name="update" value="Modifier"/>
              </form>
            </div>
          </div>
        </div>
      </body>
    </html>';
}
else
{
  header('Location:index');
}
?>
