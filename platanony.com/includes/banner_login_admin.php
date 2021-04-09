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


        <form action="index.php?controller=admin_auth&action=signin" method="post">
            <div class="form-group text-white">
                <label for="formGroupExampleInput"><span lang="eng">Login</span><span lang="fr">Nom d'administrateur</span></label>
                <input type="text" class="form-control" name="admin_name" placeholder="Admin's name" style="width: 100%">
            </div>
            <div class="form-group text-white">
                <label for="formGroupExampleInput2"><span lang="eng">Password</span><span lang="fr">Mot de passe</span></label>
                <input type="password" class="form-control" name="admin_password" placeholder="Password" style="width: 100%">
            </div>
            <button type="submit" class="btn btn-warning" name="admin_login_btn">Login</button>
        </form>
    </div>
</div>