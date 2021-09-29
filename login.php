<?php
  session_start();
  include('inc/head.php');
  if(!isset($_SESSION['id']))
  {
  ?>
      <div class="container">
        <div class="content bg-white center">
          <div class="content-title">Connexion</div>
          <?php
            if(!empty($error))
            {
              echo'<span class="error">'.$error.'</span>';
            }
          ?>
          <form method="post">
            <input type="email" name="mail" placeholder="Mail" autocomplete="off"/>
            <input type="password" name="password" placeholder="Mot de passe" autocomplete="off"/><br />
            <input type="submit" name="login" value="Connexion" autocomplete="off"/>
          </form>
        </div>
      </div>
    </body>
  </html>
  <?php
  }
else
{
  header('Location:index');
} ?>
