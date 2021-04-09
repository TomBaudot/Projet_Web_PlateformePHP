<div class="container">
  <br/>
  <table id="table-orange" class="table table-dark tale-hover">
      <tr>
          <th><span lang="eng">Team's name</span><span lang="fr">Nom de l'équipe</span></th>
          <th><span lang="eng">File</span><span lang="fr">Fichier</span></th>
          <th><span lang="eng">Attack</span><span lang="fr">Attaquer</span></th>
      </tr>
      <?php
          foreach($array_files as $list)
          {

              echo('<tr>
                       <td>'. htmlspecialchars($list['name_team']) .'</td>
                       <td><a href="get_S_files.php?filename='.$list['name_soumission'].'">'.$list['name_soumission'].'</a></td>
                         <td><a href="index.php?controller=attack&action=uploadAttack&id_team='.$list['id_team'].'&id_soumission='.$list['id_soumission'].'"><input type="submit" class="btn btn-primary" value="Envoyer attaque"></a></td></tr>');



          }

      ?>

  </table>
</div>
