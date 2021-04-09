<div class="container">
  <br/>
  <table id="table-orange" class="table table-dark tale-hover">
      <tr>
          <th><span lang="eng">Team's name</span><span lang="fr">Nom de l'équipe</span></th>
          <th><span lang="eng">File</span><span lang="fr">Fichier</span></th>
          <th><span lang="eng">Utility Score</span><span lang="fr">Score d'utilité</span></th>
          <th><span lang="eng">Defense Score</span><span lang="fr">Score de défense</span></th>
          <th><span lang="eng">Number of Received Attack</span><span lang="fr">Nombre d'attaques reçues</span></th>
      </tr>
      <?php
          foreach($res as $list)
          {

              echo('<tr>
                       <td>'. htmlspecialchars($list['name_team']) .'</td>
                       <td><a href="get_S_files.php?filename='.$list['name_soumission'].'">'.$list['name_soumission'].'</a></td>
                         <td>'.$list['score_utility'].'</td>
                         <td>'.$list['score_defense'].'</td>
                         <td>'.$list['nb_attack'].'</td></tr>');



          }

      ?>

  </table>
</div>
