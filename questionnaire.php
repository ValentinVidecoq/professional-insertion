<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    include('inc/head.php');
    if(isset($_POST['send']))
    {
      $count=$bdd->query('SELECT COUNT(*) as nbQ FROM questions');
      $countQ=$count->fetch();
      for($i = 1; $i <= $countQ['nbQ'];$i++)
      {
        if(isset($_POST[$i]) AND !empty($_POST[$i]))
        {
          $req=$bdd->prepare("INSERT INTO reponses (idU, idQ, reponse) VALUES(:idU, :idQ, :reponse)");
          $req->execute(array(
            'idU' => $_SESSION['id'],
            'idQ' => $i,
            'reponse' => $_POST[$i]
          ));
        }
      }
    }
    echo'
      <div class="container">
        <div class="container center content">
          <div class="bg-white rbox p30 m15 as-fs">
            <h3>Questionnaire</h3>
            <div class="p15 left">
              <form method="post">';
              $i = 0;
              $req=$bdd->query('SELECT * FROM questions');
              while($q=$req->fetch())
              {
                $r=$bdd->prepare('SELECT COUNT(*) as exist FROM reponses WHERE idU = :idU AND idQ = :idQ');
                $r->execute(array(
                  'idU' => $user['id'],
                  'idQ' => $q['id']
                ));
                $a=$r->fetch();
                if($a['exist'] == 0)
                {
                  $i++;
                  echo'<p>'.$i.'. '.$q['question'].'</p>';
                  switch($q['type'])
                  {
                    case 1: // Choix multiple

                    break;
                    case 2: // Réponse libre
                      echo'<input type="text" name="'.$q['id'].'" placeholder="Votre réponse"/>';
                    break;
                    case 3: // Date
                      echo'<input type="number" name="'.$q['id'].'" min="1900" max="2099" step="1" placeholder="2020" />';
                    break;
                    case 4: // Cases à cocher
                      $rq = $bdd->prepare('SELECT * FROM reponses_type WHERE idQ = :idQ');
                      $rq->execute(array(
                        'idQ' => $q['id']
                      ));
                    /*  echo'<div class="container">';*/
                      while($rt=$rq->fetch())
                      {
                        echo'
                        <div class="center radio p5">
                          <input id="radio'.$q['id'].'-'.$rt['value'].'" type="radio" name="'.$q['id'].'" value="'.$rt['value'].'"/>
                          <label for="radio'.$q['id'].'-'.$rt['value'].'">'.$rt['name'].'</label>
                        </div>';
                      }
                    /*  echo'</div>';*/
                    break;
                  }
                }
              }
              if($i != 0)
              {
                echo'<input type="submit" name="send" value="Envoyer"/>';
              }
              else
              {
                  echo'<p>Vous avez répondu à toutes les questions de l\'enquête,<br />Merci</p>';
              }
            echo'
            </form>
            </div>
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
