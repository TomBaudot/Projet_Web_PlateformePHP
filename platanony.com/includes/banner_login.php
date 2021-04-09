<div class="banner">
    <div class="login_div">


        <?php // Affichage d'un message d'erreur si nécessaire
            if (isset($error_msg)) {
                ?>
                <div class="alert alert-danger" role="alert" style="width: 100%">
                    <?php echo $error_msg ?>
                </div>
                <?php
            }
        ?>


        <form action="index.php?controller=auth&action=signin" method="post">
            <div class="form-group text-white">
                <label for="formGroupExampleInput"><span lang="eng">Login</span><span lang="fr">Nom d'équipe</span></label>
                <input type="text" class="form-control" name="team_name" placeholder="Your team's name" style="width: 100%">

            </div>
            <div class="form-group text-white">
                <label for="formGroupExampleInput2"><span lang="eng">Password</span><span lang="fr">Mot de passe</span></label>
                <input type="password" class="form-control" name="password" placeholder="Password" style="width: 100%" >
            </div>
            <button type="submit" class="btn btn-warning" name="login_btn">Login</button>
        </form>
    </div>
</div>


