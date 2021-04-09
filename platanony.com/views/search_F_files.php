
<div class="container">
  <table id="table-orange" class="table table-dark">
      <thead>
      <tr>
          <th scope="col"><span lang="eng">Team's name</span><span lang="fr">Nom de l'équipe</span></th>
          <th scope="col"><span lang="eng">File link</span><span lang="fr">Lien vers le fichier F</span></th>
      </tr>
      </thead>
      <tbody>
      <tr>

            <th>

                <div id="dropdown_container">
                    <select id="teams_dropdown" class="select_table">
                        <option value="displayText" selected="selected">Équipe/Team</option>

                        <?php
                        if(isset($teams_data) && $teams_data){
                            foreach ($teams_data as $team_data){
                                echo "<option value='" . $team_data['id_team'] . "'>" . htmlspecialchars($team_data['name_team']) . "</option>";
                            }
                        }
                        ?>

                    </select>
                    <div class="select_arrow">
                    </div>

                </div>

            </th>

            <th id="link_file_container">

            </th>



      </tr>
      </tbody>
  </table>

  <table id="table-orange" class="table table-dark">
      <thead>
      <tr>
          <th scope="col"><span lang="eng">Team's name</span><span lang="fr">Nom de l'équipe</span></th>
          <th scope="col"><span lang="eng">A File link</span><span lang="fr">Lien vers le fichier A</span></th>
          <th scope="col"><span lang="eng">Attack score</span><span lang="fr">Score d'attaque</span></th>
      </tr>
      </thead>
      <tbody>
      <tr>

            <th>

                <div id="dropdown_container">
                    <select id="teams_dropdown_A" class="select_table">
                        <option value="displayText" selected="selected">Équipe/Team</option>

                        <?php
                        if(isset($teams_data2) && $teams_data2){
                            foreach ($teams_data2 as $team_data){
                                echo "<option value='" . $team_data['id_team'] . "'>" . htmlspecialchars($team_data['name_team']) . "</option>";
                            }
                        }
                        ?>

                    </select>
                    <div class="select_arrow">
                    </div>

                </div>

            </th>

            <th id="link_Afile_container">

            </th>
            <th id="score_attack">

            </th>


      </tr>
      </tbody>
  </table>
</div>


<script type="text/javascript">
    display_team();
    display_Afile();
</script>
