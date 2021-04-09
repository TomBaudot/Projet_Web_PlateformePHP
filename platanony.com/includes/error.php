<?php // Affichage d'un message d'erreur si nécessaire
if (isset($error_msg)) {
    ?>
    <div class="alert alert-danger text-center w-50 mx-auto" role="alert" style="border-radius: 10px;">
        <?php echo $error_msg ?>
    </div>
    <?php
}
?>
