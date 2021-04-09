<?php // Affichage d'un message d'erreur si nécessaire
if (isset($success_msg)) {
    ?>
    <div class="alert alert alert-success text-center w-50 mx-auto" role="alert" style="border-radius: 10px;">
        <?php echo $success_msg ?>
    </div>
    <?php
}
?>
