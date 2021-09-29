<?php
  session_start();
  include('inc/head.php');
  if($user['auth'] >= 2)
  {
    if(isset($_POST['send']))
    {
      if(isset($_GET['v']))
      {
        switch($_GET['v'])
        {
          case "add":
          if(!empty($_POST['question']))
          {
            $q = $_POST['question'];
            $type = $_POST['type'];
            $req=$bdd->prepare("INSERT INTO questions (question, type) VALUES(:question, :type)");
            $req->execute(array(
              'question' => $q,
              'type' => $type[0]
            ));
            header('Location:questions');
          }
          break;
        }
      }
    }
    if(isset($_POST['update']))
    {
      $q = $_POST['question'];
      $type = $_POST['type'];
      $req=$bdd->prepare("UPDATE questions SET question = :question, type = :type WHERE id = :id");
      $req->execute(array(
        'question' => $q,
        'type' => $type[0],
        'id' => $_GET['idQ']
      ));
      $update = "Modifications effectuées";
      header('Locations:questions/'.$_GET['idQ'].'');
    }

    if(isset($_POST['add']))
    {
      if(!empty($_POST['value']))
      {
        $req=$bdd->prepare("SELECT * FROM reponses_type WHERE idQ = :idQ ORDER BY id DESC");
        $req->execute(array(
          'idQ' => $_GET['idQ']
        ));
        $q=$req->fetch();
        $value = $q['value'] + 1;
        $v = $_POST['value'];
        $req=$bdd->prepare("INSERT INTO reponses_type (idQ, name, value) VALUES(:idQ, :name, :value)");
        $req->execute(array(
          'idQ' => $_GET['idQ'],
          'name' => $v,
          'value' => $value
        ));
        header('Locations:questions/'.$_GET['idQ'].'');
      }
    }
    echo'
      <div class="container">
          <div class="center content">
          <div class="bg-white rbox p30 m15 as-fs">';
            if($user['auth'] == 2){echo'<h3>Gestion</h3>';}else{echo'<h3>Administration</h3>';}
              echo'
              <div class="p15">';
              if(isset($_GET['v']))
              {
                switch($_GET['v'])
                {
                  case "add":
                  echo'
                  <form method="post">
                    <input type="text" name="question" placeholder="Nouvelle question" autocomplete="off"/><br />
                    <select name="type[]">';
                      $req=$bdd->query("SELECT * FROM question_type");
                      while($type=$req->fetch())
                      {
                        echo'<option value="'.$type['id'].'">'.htmlspecialchars($type['name']).'</option>';
                      }
                      echo'
                    </select><br />
                    <input type="submit" name="send" value="Créer la question"/>
                  </form>';
                  break;
                  case "answers" :
                  echo'
                  <table class="center">
                    <tr><th>N°</th><th>Question</th><th>Statistiques</th><th>Actions</th></tr>';
                  $req=$bdd->query('SELECT * FROM questions');
                  $count=$bdd->query('SELECT COUNT(*) as nbU FROM utilisateurs');
                  $countU=$count->fetch();
                  $cpt = 1;
                  while($q=$req->fetch())
                  {
                    $r=$bdd->prepare('SELECT * FROM question_type WHERE id = :id');
                    $r->execute(array(
                      'id' => $q['type']
                    ));
                    $t = $r->fetch();
                    $counta=$bdd->prepare('SELECT COUNT(*) as nbA FROM reponses WHERE idQ = :idQ');
                    $counta->execute(array(
                      'idQ' => $q['id']
                    ));
                    $countA=$counta->fetch();
                    $perc = ceil($countA['nbA']/$countU['nbU']*100);
                    echo'<tr><td>'.$cpt.'</td><td>'.htmlspecialchars($q['question']).'</td><td>'.$countA['nbA'].'/'.$countU['nbU'].' ('.round($perc).'%)</td><td><a href="admin/results/'.$q['id'].'">Voir les résultats</a></td></tr>';
                    $cpt = $cpt + 1;
                  }
                  echo'</table>';
                  break;
                  case "questions":
                  if(isset($_GET['idQ']))
                  {
                    $req=$bdd->prepare('SELECT * FROM questions WHERE id = :idQ');
                    $req->execute(array(
                      'idQ' => $_GET['idQ']
                    ));
                    $q=$req->fetch();
                    $r=$bdd->prepare('SELECT * FROM question_type WHERE id = :id');
                    $r->execute(array(
                      'id' => $q['type']
                    ));
                    $t = $r->fetch();
                    echo'
                      <form method="post">';
                      if(isset($update))
                      {
                        echo'<span class="error">'.$update.'</span><br />';
                      }echo'
                        <input type="text" value="'.htmlspecialchars($q['question']).'" name="question"/><br />
                        <select name="type[]">';
                          $req=$bdd->query("SELECT * FROM question_type");
                          while($type=$req->fetch())
                          {
                            if($t['id'] == $type['id'])
                            {
                              echo'<option value="'.$type['id'].'" selected="selected">'.htmlspecialchars($type['name']).'</option>';
                            }
                            else
                            {
                              echo'<option value="'.$type['id'].'">'.htmlspecialchars($type['name']).'</option>';
                            }
                          }
                          echo'
                        </select><br />
                        <input type="submit" name="update" value="Modifier"/>
                      </form>';
                        if($t['multiple'] == 1)
                        {
                          echo'
                          <form method="post">
                            <h2>Réponses</h2>';
                            $count=$bdd->prepare('SELECT COUNT(*) as nbR FROM reponses_type WHERE idQ = :idQ');
                            $count->execute(array(
                              'idQ' => $q['id']
                            ));
                            $countQ=$count->fetch();
                            echo'
                            <table class="center">
                              <tr><th>N°</th><th>Réponse</th><th>Actions</th></tr>';
                              if($countQ['nbR'] == 0)
                              {
                                echo'<td colspan="3">Aucune réponse pré-enregistrée.</td>';
                              }
                              else
                              {
                                $req=$bdd->prepare('SELECT * FROM reponses_type WHERE idQ = :idQ');
                                $req->execute(array(
                                  'idQ' => $q['id']
                                ));
                                while($ans=$req->fetch())
                                {
                                  echo'
                                  <tr>
                                    <td>'.$ans['value'].'</td>
                                    <td>'.$ans['name'].'</td>
                                    <td><a href="">Modifier</a> | <a href="delete/a/'.$ans['id'].'">Supprimer</a></td>
                                  </tr>';
                                }
                              }
                              echo'
                            </table><br />
                            <h2>Ajouter une réponse</h2>
                            <input type="text" name="value" placeholder="Valeur"/>
                            <input type="submit" name="add" value="Ajouter"/>
                          </form>';
                        }
                        echo'
                      </form>';
                  }
                  else
                  {
                    echo'
                    <table class="center">
                    <tr><th>N°</th><th>Question</th><th>Réponse</th><th>Actions</th></tr>';
                    $cpt = 1;
                    $req=$bdd->query('SELECT * FROM questions');
                    while($q=$req->fetch())
                    {
                      $r=$bdd->prepare('SELECT * FROM question_type WHERE id = :id');
                      $r->execute(array(
                        'id' => $q['type']
                      ));
                      $t = $r->fetch();
                      echo'<tr><td>'.$cpt.'</td><td>'.htmlspecialchars($q['question']).'</td><td>'.htmlspecialchars($t['name']).'</td><td><a href="admin/questions/'.$q['id'].'">Modifier les réponses</a> | <a href="delete/q/'.$q['id'].'">Supprimer la question</a></td></tr>';
                      $cpt = $cpt + 1;
                    }
                    echo'</table>';
                  }
                  break;
                  case "users":
                    echo'
                    <table class="center">
                      <tr><th>N°</th><th>Nom</th><th>Prénom</th><th>Taux de complétion</th><th>Actions</th></tr>';
                      $cpt = 1;
                      $req=$bdd->query('SELECT * FROM utilisateurs');
                      while($q=$req->fetch())
                      {
                        $r=$bdd->prepare('SELECT COUNT(*) as nbA FROM reponses WHERE idU = :idU');
                        $r->execute(array(
                          'idU' => $q['id']
                        ));
                        $t = $r->fetch();
                        $rq=$bdd->query('SELECT COUNT(*) as nbQ FROM questions');
                        $nbq = $rq->fetch();
                        $perc = ceil($t['nbA']/$nbq['nbQ']*100);
                        echo'<tr><td>'.$cpt.'</td><td>'.htmlspecialchars($q['nom']).'</td><td>'.htmlspecialchars($q['prenom']).'</td><td>'.$t['nbA'].'/'.$nbq['nbQ'].' ('.$perc.'%)</td><td><a href="">Supprimer le membre</a></td></tr>';
                        $cpt = $cpt + 1;
                      }
                    echo'</table>';
                  break;
                  case "results":
                    $req=$bdd->prepare('SELECT * FROM questions WHERE id = :id');
                    $req->execute(array(
                      'id' => $_GET['idQ']
                    ));
                    $q=$req->fetch();
                    $reqA=$bdd->prepare('SELECT * FROM reponses WHERE idQ = :idQ');
                    $reqA->execute(array(
                      'idQ' => $_GET['idQ']
                    ));
                    $res = array();
                    $cpt = 0;
                    if($q['type'] == 4) // Si c'est une question à choix multiples
                    {
                      $reqAT=$bdd->prepare('SELECT * FROM reponses_type WHERE idQ = :idQ');
                      $reqAT->execute(array(
                        'idQ' => $_GET['idQ']
                      ));
                      $type = array();
                      while($ans_t = $reqAT->fetch())
                      {
                        $type[$ans_t['value']] = $ans_t['name'];
                      }
                      while($ans=$reqA->fetch())
                      {
                        if(count($res) == 0) // Si c'est le premier résultat qu'on analyse
                        {
                          $res[] = ["y" => 1, "label" => $type[$ans['reponse']]];
                        }
                        else
                        {
                          if(in_array($type[$ans['reponse']], array_column($res,'label'))) // Si la valeur existe déjà
                          {
                            $key = array_search($type[$ans['reponse']],array_column($res, 'label'));
                            $res[$key]['y'] = $res[$key]['y']+1;
                          }
                          else // Si la valeur n'existe pas
                          {
                            $res[] = ["y" => 1, "label" => $type[$ans['reponse']]];
                          }
                        }
                        $cpt++;
                      }
                    }
                    else
                    {
                      while($ans=$reqA->fetch())
                      {
                        if(count($res) == 0) // Si c'est le premier résultat qu'on analyse
                        {
                          $res[] = ["y" => 1, "label" => $ans['reponse']];
                        }
                        else
                        {
                          if(in_array($ans['reponse'], array_column($res,'label'))) // Si la valeur existe déjà
                          {
                            $key = array_search($ans['reponse'],array_column($res, 'label'));
                            $res[$key]['y'] = $res[$key]['y']+1;
                          }
                          else // Si la valeur n'existe pas
                          {
                            $res[] = ["y" => 1, "label" => $ans['reponse']];
                          }
                        }
                        $cpt++;
                      }
                      unset($value);
                      array_multisort(array_column($res,'label'), SORT_ASC, $res); // Trier les données par ordre croissant
                    }
                    foreach($res as &$value) // Passage en % de la valeur y
                    {
                      $value['y'] = $value['y']/$cpt*100;
                    }
                    $dataPoints = $res;?>
                      <script>
                    window.onload = function() {

                    var chart = new CanvasJS.Chart("chartContainer", {
                      animationEnabled: true,
                      theme: "light2",
                      title:{
                        text: <?php echo json_encode($q['question']);?>
                      },
                      axisY: {
                        minimum: 0,
                        maximum: 100,
                        title: "Répartition en %"
                      },
                      data: [{
                        type: "column",
                        yValueFormatString: "#,##0.00\"%\"",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                      }]
                    });
                    chart.render();

                    }
                    </script>
                    <?php
                    echo'<div id="chartContainer" style="height: 370px; width: 100%;"></div>';
                  break;
                }
              }
              else
              {
                echo'
                <a href="admin/add">Ajouter une question</a><br />
                <a href="admin/questions">Voir les questions</a><br />
                <a href="admin/users">Gestion des membres</a><br />
                <a href="admin/answers">Voir les réponses</a>';
              }
              echo'
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript" src="inc/canvasjs.min.js"></script>
      </body>
    </html>';
  }
  else
  {
    header('Location:index');
  }
?>
