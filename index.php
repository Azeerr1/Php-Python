<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/style.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/0c87a70838.js"></script>
    <title>Inscription</title>
  </head>
  <body>

    <div class="block">
          <div class="centre">
            <p class="entete2">INSCRIPTION</p>
            <hr class="ent">
                  <form  action="insertion.php" method="POST">
                    <table>
                      <tr>
                          <tr>
                            <td>
                              <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            </td>
                            <td>
                              <input type="text" required="required" name="prenom" placeholder="Prénom"><br>
                            </td>
                          </tr>

                          <tr>
                        <td>
                        </td>
                        <td>
                        <select name="team" id="team-select">
                            <option value="">Choisir une équipe</option>
                            <option value="jaune">Jaune</option>
                            <option value="rouge">Rouge</option>
                            <option value="verte">Verte</option>
                        </select>
                       </td>
                      </tr>
                        </table>
                    <br>
                    <input class="button-connect" type="submit" id='submit' value="S'inscrire"/>
                  </form><br>
                  <form action="selection.php" method="POST">
                    <input class="button-connect" type="submit" value="Jouer"/>
                  </form>
          </div>
        </div>

    </form>

    <?php

      $newgame = $_POST['newgame'];
            if($newgame){
              try
              {
              $bdd = new PDO('mysql:host=localhost;dbname=id_joueur', 'root', '');
              }
              catch(Exception $e)
              {
              die('Erreur : '.$e->getMessage());
              }
              $reponse = $bdd->query("DELETE FROM info");
            }
            $reponse->closeCursor();


    ?>
  </body>
</html>