<?php
  session_start();
  include('inc/head.php');
?>
    <div class="container">
      <div class="center content container">
          <?php
          if(isset($_SESSION['id']))
          {
            $count=$bdd->query('SELECT COUNT(*) as nbQ FROM questions');
            $countQ=$count->fetch();
            $counta=$bdd->prepare('SELECT COUNT(*) as nbA FROM reponses WHERE idU = :user_id');
            $counta->execute(array(
              'user_id' => $_SESSION['id']
            ));
            $countA=$counta->fetch();
            $perc = ($countA['nbA']/$countQ['nbQ'])*100;
            echo'
            <div class="bg-white rbox container p30 m15">
              <div class="m15">
                <img src="media/img/student.png" width="100px";/>
              </div>
              <div style="width:200px;">
                <h3 class="m0">'.htmlspecialchars($user['prenom']).' '.htmlspecialchars($user['nom']).'</h3>';
                switch($user['auth'])
                {
                  case 1:
                    $rank = "Ex-Étudiant";
                  break;
                  case 2:
                    $rank = "Gestionnaire";
                  break;
                  case 3:
                    $rank = "Administrateur";
                  break;
                }echo'
                <span>'.$rank.'</span>
              </div>
            </div>
            <div class="bg-white rbox container fd-c p30 m15">
              <h3>Complétion du questionnaire</h3><br />
              <div class="c100 p'.round($perc).'">
                <span>'.round($perc).'%</span>
                <div class="slice">
                  <div class="bar"></div>
                  <div class="fill"></div>
                </div>
              </div>
            </div>
            <div class="bg-white rbox container p30 m15">
              <div style="width:150px;">
                <a href="account" class="button block">Mon Compte</a><br />
                <a href="questionnaire" class="button block">Questionnaire</a><br />
                <a href="logout" class="button block">Déconnexion</a>
              </div>
            </div>';
          }
          else
          {
            echo'
            <div class="bg-white rbox container p30 m15">
              <div class="m15">
                <img src="media/img/survey.png" width="100px";/>
              </div>
              <div style="width:250px;">
                <h3>Insertion Professionnelle</h3>
                <p>
                  Cette plateforme regroupe toutes les statistiques concernant l\'insertion professionnelle des anciens étudiants de l\'EILCO.
                </p>
              </div>
            </div>
            <div class="bg-white rbox container p30 m15">
              <div class="m15">
                <img src="media/img/register.png" width="120px";/>
              </div>
              <div style="width:250px;">
                <h3>Vous êtes un ex-étudiant ?</h3>
                <p>
                  Créez votre profil et remplissez le questionnaire.
                </p>
                <a href="register" class="button">Inscription</a>
              </div>
            </div>
            <div class="bg-white rbox container p30 m15">
              <div class="m15">
                <img src="media/img/student.png" width="100px";/>
              </div>
              <div style="width:250px;">
                <h3>Déjà inscrit ?</h3>
                <p>
                  Connectez-vous et consultez vos réponses.
                </p>
                <a href="register" class="button">Connexion</a>
              </div>
            </div>';
          }
          ?>
      </div>
    </div>
  </body>
</html>
