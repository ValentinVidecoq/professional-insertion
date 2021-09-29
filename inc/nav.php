<?php
  echo'
  <nav>
    <ul>';
    if(isset($_SESSION['id']))
    {
      if($user['auth'] == "3")
      {
        echo "<li><a href='admin'>Administration</a></li>";
      }
      if($user['auth'] == "2")
      {
        echo "<li><a href='admin'>Gestion</a></li>";
      }
    }
    else
    {
      echo'
      <li><a href="register">Connexion</a></li>
      <li><a href="register">Inscription</a></li>';
    }
    echo'
    </ul>
  </nav>';
?>
