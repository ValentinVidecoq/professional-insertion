<?php
  session_start();
  if(!isset($_SESSION['id']))
  {
    include('inc/head.php');
    $error = null;
    $lerror = null;
    if(isset($_POST['register']))
    {
      if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail']) AND !empty($_POST['password']))
      {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
          $req=$bdd->query("SELECT COUNT(*) as nb FROM utilisateurs WHERE mail = '".$mail."'");
          $hv_mail = $req->fetch();
          if($hv_mail['nb'] == 0) /* On vérifie que l'adresse mail ne soit pas déjà utilisée */
          {
            $pass = $_POST['password'];
            if(strlen($pass) >= 8) /* On vérifie que le mot de passe contient au moins 8 caractères */
            {
              $pass = password_hash($pass,PASSWORD_DEFAULT);
              $req=$bdd->prepare("INSERT INTO utilisateurs (nom, prenom, mail, password) VALUES(:nom,:prenom,:mail,:password)");
              $req->execute(array(
                'nom' => $nom,
                'prenom' => $prenom,
                'mail' => $mail,
                'password' => $pass
              ));
              $req=$bdd->prepare("SELECT * FROM utilisateurs WHERE mail = :mail");
              $req->execute(array(
                'mail' => $mail
              ));
              $u = $req->fetch();
              $_SESSION['id'] = $u['id'];
              header('Location:index');
            }
            else
            {
              $error = "Mot de passe inférieur à 8 caractères";
            }
          }
          else
          {
            $error = "Mail déjà enregistré";
          }
        }
        else
        {
          $error = "Mail invalide";
        }
      }
      else
      {
          $error = "Merci de remplir tous les champs";
      }
    }
    if(isset($_POST['login']))
    {
      if(!empty($_POST['mail']) AND !empty($_POST['password']))
      {
        $mail = $_POST['mail'];
        $req=$bdd->prepare("SELECT COUNT(*) as nb FROM utilisateurs WHERE mail = :mail");
        $req->execute(array(
          'mail' => $mail
        ));
        $hv_mail = $req->fetch();
        if($hv_mail['nb'] == 1)
        {
          $pass = $_POST['password'];
          $req=$bdd->prepare("SELECT * FROM utilisateurs WHERE mail = :mail");
          $req->execute(array(
            'mail' => $mail
          ));
          $u = $req->fetch();
          if(password_verify($pass,$u['password']))
          {
            $_SESSION['id'] = $u['id'];
            header('Location:index');
          }
          else
          {
            $lerror = "Identifiants incorrects";
          }
        }
        else
        {
          $lerror = "Identifiants incorrects";
        }
      }
      else
      {
        $lerror = "Merci de remplir tous les champs";
      }
    }echo'
      <div class="container">
        <div class="content container center">
          <div class="bg-white rbox p30 m15 as-fs">
            <h3>Inscription</h3>';
              if(!empty($error))
              {
                echo'<span class="error">'.$error.'</span>';
              }echo'
            <form method="post">
              <input type="text" name="nom" placeholder="Nom" autocomplete="off"'; if(isset($_POST['nom'])){ echo' value = '.htmlspecialchars($_POST['nom']).'';}echo'><br />
              <input type="text" name="prenom" placeholder="Prénom" autocomplete="off" /><br />
              <input type="email" name="mail" placeholder="Mail" autocomplete="off"/><br />
              <input type="password" name="password" placeholder="Mot de passe" autocomplete="off"/><br />
              <input type="submit" name="register" value="S\'inscrire"/>
            </form>
          </div>
          <div class="bg-white rbox p30 m15 as-fs">
            <h3>Vous avez déjà un compte ?</h3>';
              if(!empty($lerror))
              {
                echo'<span class="error">'.$lerror.'</span>';
              }echo'
            <form method="post">
              <input type="email" name="mail" placeholder="Mail" autocomplete="off"/><br />
              <input type="password" name="password" placeholder="Mot de passe" autocomplete="off"/><br />
              <input type="submit" name="login" value="Connexion"/>
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
