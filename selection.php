<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/style3.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/0c87a70838.js"></script>
    <title>Selection Joueur</title>
  </head>
  <body>
    <div class="block">
          <div class="centre">
            <p class="entete2">Selection du joueur</p>
            <hr class="ent">
                  <form  action="selection.php" method="POST">
                    <table>
                          <tr>
                            <td>
                            <select name="team" id="team-select">
                              <option value="">Liste des joueurs</option>                               
                              <?php 
                                try
                                {
                                $bdd = new PDO('mysql:host=localhost;dbname=id_joueur', 'root', '');
                                }
                                catch(Exception $e)
                                {
                                die('Erreur : '.$e->getMessage());
                                }
                                $reponse = $bdd->query('SELECT * FROM info');
                                while($donnees=$reponse->fetch())
                                {
                                  echo "<option><p>",$donnees['id']," - ",$donnees['prenom']," - ",$donnees['team'],"</p></option>";
                                }

                                $reponse->closeCursor();
                                ?>
                            </td>
                            </select>      
                          </tr>
                        </table>           
                    <br>
                    </form>
                      <td>
                      <form action="selection.php" method="POST">
                        <input style="border-radius:3px; border:solid 1px; padding-top:5px;" type="text" name="id" placeholder="ID du tireur"><br>
                        <input style="border-radius:3px; border:solid 1px; padding-top:5px;" type="text" name="newprenom" placeholder="Prénom du tireur"><br>
                        <input style="border-radius:3px; border:solid 1px; padding-top:5px;" type="text" name="newteam" placeholder="Team : jaune, rouge ou verte"><br>
                        <input class="button-connect" type="submit" name="edit" value="Valider le tire">
                      </form>
                    </td>
                  <br><br> 
                  <p>Le tireur était : <?php echo $_POST['newprenom']; ?></p>
                  <form action="index.php" method="POST">
                  <input class="button-connect" type="submit" name="newgame" value="Nouvelle Partie"/>
                  </form><br><br>
                  <form action="selection.php" method="POST">
                  <input class="button-connect" type="submit" value="Recharger les scores"/>
                  </form>
          </div>
          <div class="center">
          <?php

            $filename = "data.json";
            $data = file_get_contents($filename);
            $json2 = json_decode($data, true);
            $json3 = $json2['Coordonnes'];
            $id = $_POST['id'];
            $newprenom= $_POST['newprenom'];
            $newteam= $_POST['newteam'];

            $edit= $_POST['edit'];

              try
              {
              $bdd = new PDO('mysql:host=localhost;dbname=id_joueur', 'root', '');
              }
              catch(Exception $e)
              {
              die('Erreur : '.$e->getMessage());
              }
              $reponse = $bdd->query('SELECT *
              FROM info
              ORDER BY team');
              echo "<table style='margin-left:auto; margin-right:auto; width:600px; padding-left:10px;'><tr>";
              echo "<td><p style='font-size:18px; text-align:center; color:#8148C9;'>ID<hr></p></td>";
              echo "<td><p style='font-size:18px; text-align:center; color:#8148C9;'>PRENOM<hr></p></td>";
              echo "<td><p style='font-size:18px; text-align:center; color:#8148C9;'>TEAM<hr></p></td>";
              echo "<td><p style='font-size:18px; text-align:center; color:#8148C9;'>SCORE<hr></p></td></tr>";
              while($donnees=$reponse->fetch())
              {
                echo '<tr>';
                echo "<td><p style='text-align:center; color:#8148C9;'>",$donnees['id'],nl2br("</p></td>");
                echo "<td><p style='text-align:center; color:#8148C9;'>",$donnees['prenom'],nl2br("</p></td>");
                echo "<td><p style='text-align:center; color:#8148C9;'>",$donnees['team'],nl2br("</p></td>");
                echo "<td><p style='text-align:center; color:#8148C9;'>",$donnees['score'],nl2br("</p></td>");
                echo '<tr>';
              }
            $reponse->closeCursor();

            if($edit) {
              try
              {
              $bdd = new PDO('mysql:host=localhost;dbname=id_joueur', 'root', '');
              }
              catch(Exception $e)
              {
              die('Erreur : '.$e->getMessage());
              }
              $bdd->exec("UPDATE `info` SET prenom = '$newprenom', team = '$newteam', score = '$json3' WHERE `info`.`id` = $id;");
              }

          ?>
         </div>
        </div>
    </form>
  </body>
</html>